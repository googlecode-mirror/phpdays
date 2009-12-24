<?php
/**
 * Controller (MVC pattern) - used as base class for application controllers.
 *
 * Part of "php:Days - php5 framework" project (http://phpdays.googlecode.com).
 *
 * @copyright    Copyright (c) 2009 phpDays foundation (http://phpdays.org)
 * @license      http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link         http://code.google.com/p/phpdays/wiki/EnLibDaysController
 * @package      Days
 * @subpackage   Days
 * @author       Anton Danilchenko <happy@phpdays.org>
 */
class Days_Controller {
    /** @var Days_View_Abstract */
    protected $_view;
    /** @var string Path to content template */
    protected $_content;
    /** @var string Path to layout template */
    protected $_layout;
    /** @var array Template variables */
    protected $_variables = array();

    /**
     * Create template engine object.
     */
    public function __construct() {
        $templateEngine = Days_Config::load()->get('view/engine', 'php');
        $this->_view = Days_View::factory($templateEngine);
    }

    public function getContent($withLayout=true) {
        // set variables to view
        foreach ($this->_variables as $name=>$value) {
            $this->_view->set($name, $value);
        }
        // set main content in layout
        $this->_view->set('content', $this->_view->render($this->_content));
        // return only content
        if (! $withLayout) {
            return self::_postFilter($this->_view->get('content'));
        }
        // insert content into layout
        return self::_postFilter($this->_view->render($this->_layout));
    }

    /**
     * Set layout template name.
     *
     * @param string $template Layout template name
     * @param bool $rewrite Replace defined layout template name
     */
    public function setLayout($template, $rewrite=true) {
        if (is_null($this->_layout) OR $rewrite) {
            $this->_layout = "layout/{$template}." . Days_Url::getSpec('ext');
        }
    }

    /**
     * Set template name.
     *
     * @param string $template Template name
     * @param bool $rewrite Replace defined template name
     */
    public function setTemplate($template, $rewrite=true) {
        if (is_null($this->_content) OR $rewrite) {
            $this->_content = "content/{$template}." . Days_Url::getSpec('ext');
        }
    }

    /**
     * Always call after create object instance.
     */
    public function init() {
    }

    /**
     * Return SESSION variable by name.
     *
     * @return mixed
     */
    public function session($name, $value=null) {
        // set value
        if (! is_null($value)) {
            Days_Request::session($name, $value);
        }
        // return value
        return Days_Request::session($name);
    }

    /**
     * Return POST variable by name.
     *
     * @return mixed
     */
    public function post($name, $value=null) {
        // set value
        if (! is_null($value)) {
            Days_Request::post($name, $value);
        }
        // return value
        return Days_Request::post($name);
    }

    /**
     * Return URL variable by name.
     *
     * @return mixed
     */
    public function url($name) {
        // return value
        return Days_Url::get($name);
    }

    /**
     * Add EVENT handler by event name.
     *
     * @return mixed
     */
    public function event($name, array $observer) {
        // set value
        return Days_Event::add($name, $observer);
    }

    /**
     * Add log message to developer only.
     *
     * @return bool Message saved to log
     */
    public function log($message) {
        // set value
        return Days_Log::add($message);
    }

    /**
     * Redirect to specified page.
     *
     * @param string $path Path to page for redirect
     */
    public function redirect($path=null) {
        // reload page
        if (is_null($path)) {
            throw new Days_Exception('', Days_Response::RELOAD);
        }
        // go to special page
        if (404==$path) {
            throw new Days_Exception('', Days_Response::NOT_FOUND);
        }
        if (403==$path) {
            throw new Days_Exception('', Days_Response::FORBIDDEN);
        }
        throw new Days_Exception($path, Days_Response::REDIRECT);
    }

    /**
     * Set variable to template.
     *
     * @param sthing $name Name of template variable
     * @param mixed $value Value, setted to template variable
     */
    public function __set($name, $value) {
        $this->_variables[$name] = $value;
    }

    protected static function _postFilter($content) {
        // add base path after all url adresses
        $basePath = Days_Config::load()->get('url/base', '');
        if ('' != $basePath) {
            $content = preg_replace('`(= *[\'"]/)`', "\$1{$basePath}/", $content);
        }
        return $content;
    }
}
