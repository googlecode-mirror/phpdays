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
require_once 'lib/Days/View/Php.php';

/**
 * Tests for the Days_View_Php class.
 */
class Days_View_PhpTest extends PHPUnit_Framework_TestCase {
    public function testGet() {
        $var = 'var';
        $set_value = 'value';
        $view = new Days_View_Php();
        $view->set($var, $set_value);
        $get_value = $view->get($var);
        $this->assertEquals($set_value, $get_value);
        $get_value = $view->get('no such key');
        $this->assertNull($get_value);
        $default_value = 'default value';
        $get_value = $view->get('no such key', $default_value);
        $this->assertEquals($get_value, $default_value);
    }
}
?>
