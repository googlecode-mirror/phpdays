<?php
/**
 *
 * @copyright    Copyright (c) 2009 phpDays foundation (http://phpdays.org)
 * @license      http://www.opensource.org/licenses/mit-license.php The MIT License
 * @package      phpDays
 * @subpackage   tests
 */

require_once 'lib/Days/View/Interface.php';
require_once 'lib/Days/View/Dwoo.php';
require_once 'lib/Days/Engine.php';
require_once 'lib/Dwoo/Dwoo/IDataProvider.php';
require_once 'lib/Dwoo/Dwoo/Data.php';
require_once 'lib/Dwoo/Dwoo/Exception.php';

/**
 * Stubs
 */
class Dwoo {
    public function setCompileDir($var) {
    }

    public function setCacheDir($var) {
    }
}

/**
 * Tests for the Days_View_Dwoo class.
 */
class Days_View_DwooTest extends PHPUnit_Framework_TestCase {
    protected $view;

    protected function setUp() {
        $dwoo_data = $this->getMock('Dwoo_Data');
        $this->view = new Days_View_Dwoo();
    }

    /**
     * @covers Days_View_Dwoo::get
     */
    public function testGetDefaultDefaultValue() {
        $this->assertNull($this->view->get('NoSuchKey'));
    }

    /**
     * @covers Days_View_Dwoo::get
     */
    public function testGetSpecifiedDefaultValue() {
        $value = 'Specified Default Value';
        $this->assertEquals($value, $this->view->get('NoSuchKey', $value));
    }
}
?>