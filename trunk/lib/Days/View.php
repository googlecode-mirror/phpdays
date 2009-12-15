<?php
/**
 * View (MVC pattern) - show template based on defined variables.
 *
 * Part of "php:Days - php5 framework" project (http://phpdays.googlecode.com).
 *
 * @copyright    Copyright (c) 2009 phpDays foundation (http://phpdays.org)
 * @license      http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link         http://code.google.com/p/phpdays/wiki/EnLibDaysView
 * @package      Days
 * @subpackage   Days
 * @author       Anton Danilchenko <happy@phpdays.org>
 */
class Days_View {

    /** @var Days_View_Config View configuration */
    private static $_viewConfig = null;
    
    public static function factory($engine) {
        $engine = ucfirst($engine);
        $className = "Days_View_{$engine}";
        return new $className(self::getViewConfig());
    }

    private function __construct() {
    }

    public static function setViewConfig(Days_View_Config $config) {
        self::$_viewConfig = $config;
    }
    
    public static function getViewConfig() {
        if (!isset(self::$_viewConfig)) {
            self::$_viewConfig = new Days_View_Config();
        }
        return self::$_viewConfig;
    }
}
