<?php
/**
 * View - Smarty adapter.
 *
 * Part of "php:Days - php5 framework" project (http://phpdays.sf.net).
 *
 * @copyright    Copyright (c) 2009 phpDays foundation (http://phpdays.org)
 * @license      http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link         http://code.google.com/p/phpdays/wiki/EnLibDaysViewSmarty
 * @package      phpDays
 * @subpackage   phpDays library
 * @author       Anton Danilchenko <happy@phpdays.org>
 */
class Days_View_Smarty implements Days_View_Interface {
    /** @var Smarty */
    protected $_engine;

    public function __construct() {
        // create template engine instance
        $this->_engine = new Smarty();
        // configure template engine
        $this->_engine->template_dir  = Days_Engine::appPath() . 'View/';
        $this->_engine->compile_dir   = Days_Engine::appPath() . 'system/view/';
        $this->_engine->cache_dir     = Days_Engine::appPath() . 'system/cache/';
        $this->_engine->caching       = Days_Config::load()->get('cache/lifetime', 0) > 0;
        $this->_engine->plugins_dir   = array('phpdays', 'plugins');
    }

    public function render($template) {
        if (! $this->_engine->template_exists($template))
            throw new Days_Exception("Template file '{$template}' not found");
        return $this->_engine->fetch($template);
    }

    public function get($var, $default=null) {
        return $this->_engine->get_template_vars($var);
    }

    /**
     *
     * @param <type> $var
     * @param <type> $value
     * @param bool $merge Merge new value with old value
     * @param string $delimiter Values separator
     */
    public function set($var, $value, $merge=false, $delimiter='-') {
        // add value to existing
        if ($merge) {
            $oldValue = $this->_engine->get_template_vars($var);
            // set seperator for existing value only
            if (! empty($oldValue))
                $value = "{$value} {$delimiter} {$oldValue}";
        }
        // set new value
        $this->_engine->assign($var, $value);
    }
}