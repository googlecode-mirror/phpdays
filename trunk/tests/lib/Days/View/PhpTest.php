<?php
/**
 *
 * @copyright    Copyright (c) 2009 phpDays foundation (http://phpdays.org)
 * @license      http://www.opensource.org/licenses/mit-license.php The MIT License
 * @package      phpDays
 * @subpackage   tests
 */

require_once 'lib/Days/View/Interface.php';
require_once 'lib/Days/View/Php.php';

/**
 * Tests for the Days_View_Php class.
 */
class Days_View_PhpTest extends PHPUnit_Framework_TestCase {
    protected $view;

    protected function setUp() {
        $this->view = new Days_View_Php();
    }

    /**
     * @covers Days_View_Php::get
     */
    public function testGetDefaultDefaultValue() {
        $this->assertNull($this->view->get('NoSuchKey'));
    }

    /**
     * @covers Days_View_Php::get
     */
    public function testGetSpecifiedDefaultValue() {
        $value = 'Specified Default Value';
        $this->assertEquals($value,
            $this->view->get('NoSuchKey', $value));
    }
}
?>
