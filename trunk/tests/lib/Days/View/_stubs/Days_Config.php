<?php
/**
 * This is a fake class for Days_Config.
 * 
 * @copyright    Copyright (c) 2009 phpDays foundation (http://phpdays.org)
 * @license      http://www.opensource.org/licenses/mit-license.php The MIT License
 * @package      phpDays
 * @subpackage   tests
 */

/**
 * A stub for the Days_Config class.
 */
class Days_Config {

    public static function load() {
        return new Days_Config();
    }
    
    public function get($var1, $var2) {
        return 543;
    }
}