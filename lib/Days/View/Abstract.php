<?php
/**
 * Abstract View - base class for all view adapters.
 *
 * Part of "php:Days - php5 framework" project (http://phpdays.googlecode.com).
 *
 * @copyright    Copyright (c) 2009 phpDays foundation (http://phpdays.org)
 * @license      http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link         http://code.google.com/p/phpdays/wiki/EnLibDaysViewAbstract
 * @package      Days
 * @subpackage   View
 * @author       Anton Danilchenko <happy@phpdays.org>
 */
abstract class Days_View_Abstract {
    protected function _include($template, array $params=array()) {
        // check template file
        $templatePath = Days_Engine::appPath() . 'View/' . $template;
        if (! file_exists($templatePath))
            throw new Days_Exception("Template file '{$template}' not found");
        // load template
        extract($params);
        ob_start();
        require ($templatePath);
        return ob_get_clean();
    }

    protected function _helper($name, $method, array $params=array()) {
        // set correct helper name
        $name = ucfirst($name);
        $name = "Days_Helper_{$name}";
        // create helper
//        $helper = new $name();
        // return helper result
        return call_user_func_array(array($name, $method), $params);
    }
}