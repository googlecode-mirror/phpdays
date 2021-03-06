<?php
/**
 * Php View - php adapter.
 *
 * Part of "php:Days - php5 framework" project (http://phpdays.googlecode.com).
 *
 * @copyright    Copyright (c) 2009 phpDays foundation (http://phpdays.org)
 * @license      http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link         http://code.google.com/p/phpdays/wiki/EnLibDaysViewPhp
 * @package      Days
 * @subpackage   View
 * @author       Anton Danilchenko <happy@phpdays.org>
 */
class Days_View_Php extends Days_View_Abstract implements Days_View_Interface {
    /** @var array Template variables */
    protected $_vars = array();
    
    /** @var string Directory with templates */
    private $_templateDir;

    /**
     * Initialize template engine.
     */
    public function __construct(Days_View_Config $viewConfig) {
        $this->_templateDir = $viewConfig->getTemplateDir();
    }

    /**
     * Return result template with setted variables.
     *
     * @param string $template Template name
     * @return string
     */
    public function render($template) {
        return $this->_include($template, $this->_vars);
    }

    /**
     * Returns a value of a template variable.
     *
     * If a template variable does not exist or its value is null,
     * returns a default value.
     *
     * @param string $var Name of a template variable
     * @param string $default Default value to return
     * @return string
     */
    public function get($var, $default=null) {
        return (isset($this->_vars[$var]) ? $this->_vars[$var] : $default);
    }

    /**
     * Set a variable.
     *
     * @param string $var Variable name
     * @param mixed $value Variable value
     */
    public function set($var, $value) {
        $this->_vars[$var] = $value;
    }

    /**
     * Include file and return its content with assigned variables.
     *
     * @param string $template Template name
     * @param array $vars Variables, inserted into template
     * @return string
     */
    protected function _include($template, array $vars=array()) {
        // check template file
        $templatePath = $this->_templateDir . $template;
        if (! file_exists($templatePath))
            throw new Days_Exception("Template file '{$template}' not found");
        // load template
        extract($vars);
        ob_start();
        require ($templatePath);
        return ob_get_clean();
    }
}