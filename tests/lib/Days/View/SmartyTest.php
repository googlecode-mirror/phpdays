<?php
/**
 *
 * @copyright    Copyright (c) 2009 phpDays foundation (http://phpdays.org)
 * @license      http://www.opensource.org/licenses/mit-license.php The MIT License
 * @package      phpDays
 * @subpackage   tests
 */

require_once 'lib/Days/View/Interface.php';
require_once 'lib/Days/View/Smarty.php';
require_once 'lib/Smarty/Smarty.php';
require_once 'lib/Days/Engine.php';
require_once 'lib/Days/Config.php';
require_once 'lib/Days/Config/Yaml.php';
require_once 'lib/Spyc/Spyc.php';

/**
 * Tests for the Days_View_Smarty class.
 */
class Days_View_SmartyTest extends PHPUnit_Framework_TestCase {
    protected $view;

    protected function setUp() {
        $this->view = new Days_View_Smarty();
    }

    /**
     * @covers Days_View_Smarty::get
     */
    public function testGetDefaultDefaultValue() {
        $this->assertNull($this->view->get('NoSuchKey'));
    }

    /**
     * @covers Days_View_Smarty::get
     */
    public function testGetSpecifiedDefaultValue() {
        $value = 'Specified Default Value';
        $this->assertEquals($value,
            $this->view->get('NoSuchKey', $value));
    }
}
?>