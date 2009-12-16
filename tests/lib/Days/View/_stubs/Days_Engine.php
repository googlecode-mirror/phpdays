<?php
/**
 * This is a fake class for Days_Engine.
 * 
 * @copyright    Copyright (c) 2009 phpDays foundation (http://phpdays.org)
 * @license      http://www.opensource.org/licenses/mit-license.php The MIT License
 * @package      phpDays
 * @subpackage   tests
 */

/**
 * A stub for the Days_Engine class.
 */
class Days_Engine {
    private static $appDir = '';

    public static function appPath() {
        return self::$appDir;
    }
   
    public static function setAppDir($dir) {
        self::$appDir = $dir;
    }  
}