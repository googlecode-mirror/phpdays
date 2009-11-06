<?php
/**
 * Controller (MVC pattern) - used as base class for application controllers.
 *
 * Part of "php:Days - php5 framework" project (http://phpdays.googlecode.com).
 *
 * @copyright    Copyright (c) 2009 phpDays foundation (http://phpdays.org)
 * @license      http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link         http://code.google.com/p/phpdays/wiki/EnLibDaysController
 * @package      phpDays
 * @subpackage   phpDays library
 * @author       Anton Danilchenko <happy@phpdays.org>
 */
class Days_Controller {
    /** @var Days_View */
    protected $_view;
    /** Path to content template */
    protected $_content;
    /** Path to layout template */
    protected $_layout;

    /**
     * Create template engine object.
     *
     * @param string $template Path to content template file
     */
    public function __construct($template) {
        $this->_content = $template;
        $templateEngine = Days_Config::load()->get('view/engine', 'php');
        $this->_view = Days_View::factory($templateEngine);
    }

    public function getContent($withLayout=true) {
        // set main content in layout
        $this->_view->set('content', $this->_view->render($this->_content));
        // return only content
        if (! $withLayout)
            return self::postFilter($this->_view->get('content'));
        // insert content into layout
        return self::postFilter($this->_view->render($this->_layout));
    }

    protected static function postFilter($content) {
        // add base path after all url adresses
        $basePath = Days_Config::load()->get('url/base', '');
        if (''!=$basePath)
            $content = preg_replace('`(= *[\'"]/)`', "\$1{$basePath}/", $content);
        return $content;
    }

    /**
     * Set layout name.
     *
     * @param string $template Template name
     * @param bool $rewrite Replace defined layout name
     */
    public function setLayout($template, $rewrite=true) {
        if (is_null($this->_layout) OR $rewrite)
            $this->_layout = "layout/{$template}." . Days_Url::getSpec('ext');
    }

    /**
     * Always call after create object instance.
     */
    public function init() {
    }
}