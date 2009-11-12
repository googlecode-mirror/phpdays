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
    private $_rootDir;

    public static function factory($engine) {
        $engine = ucfirst($engine);
        $className = "Days_View_{$engine}";
        return new $className();
    }
    
    protected function _rootDir($dir=null) {
        // return dir
        if (is_null($dir))
            return $this->_rootDir;
        $this->_rootDir = $dir;
    }

    private function __construct() {
    }
}
