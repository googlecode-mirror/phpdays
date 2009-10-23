<?php
/**
 *
 * @copyright    Copyright (c) 2009 phpDays foundation (http://phpdays.org)
 * @license      http://www.opensource.org/licenses/mit-license.php The MIT License
 * @package      phpDays
 * @subpackage   tests
 */
require_once 'PHPUnit/Framework.php';
require_once 'lib/Days/View/Interface.php';
require_once 'lib/Days/View/Smarty.php';

/**
 * Stubs
 */
class Smarty {
    var $template_dir;
    var $compile_dir;
    var $cache_dir;
    var $caching;
    var $plugins_dir;
    public function get_template_vars() {
    }
}
class Days_Engine {
    public static function addPath() {
        return '/tmp/';
    }
    public static function apppath() {
    }
}
class Days_Config {
    public static function load() {
        return new LoadConfig();
    }
}
class LoadConfig {
    public function get($param1, $param2) {
        return 10;
    }
}

/**
 * Unit tests for the Days_View_Smarty class.
 */
class Days_View_SmartyTest extends PHPUnit_Framework_TestCase {

    public function testDefaultValues() {
        $view = new Days_View_Smarty();
        $this->assertNull($view->get('no such key'));

        $this->assertEquals($view->get('no such key', 'default'), 'default');

        $this->markTestIncomplete();
    }
}
?>