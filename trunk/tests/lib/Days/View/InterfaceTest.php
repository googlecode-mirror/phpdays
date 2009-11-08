<?php
/**
 *
 * @copyright    Copyright (c) 2009 phpDays foundation (http://phpdays.org)
 * @license      http://www.opensource.org/licenses/mit-license.php The MIT License
 * @package      phpDays
 * @subpackage   tests
 */

/**
 * Common tests for classes implementing the Days_View_Interface
 * interface.
 */
abstract class Days_View_InterfaceTest extends PHPUnit_Framework_TestCase {
    /**
     * @var Days_View_Interface
     */
    protected $view;

    public function testGetDefaultDefaultValue() {
        $this->assertNull($this->view->get('NoSuchKey'));
    }

    public function testGetSpecifiedDefaultValue() {
        $value = 'Specified Default Value';
        $this->assertEquals($value,
            $this->view->get('NoSuchKey', $value));
    }

    public function testSetVariable() {
        $name = 'Variable';
        $value = 'Value';
        $this->view->set($name, $value);
        $this->assertEquals($value, $this->view->get($name));
    }
    
    public function testSetAndReplace() {
        $name = 'Variable';
        $firstValue = 'First';
        $secondValue = 'Second';
        $this->view->set($name, $firstValue);
        $this->view->set($name, $secondValue);
        $this->assertEquals($secondValue, $this->view->get($name));
    }
    
    public function testUnset() {
        $name = 'Unset';
        $value = 'Not set';
        $this->view->set($name, null);
        $this->assertEquals($value, $this->view->get($name, $value));
    }

    /**
     * @dataProvider emptyValues
     */
    public function testSetToEmpty($value) {
        $name = 'Empty';
        $this->view->set($name, $value);
        $this->assertEquals($value, $this->view->get($name, $value));
    }
    
    public function emptyValues() {
        return array(
            array(''),
            array('0'),
            array(0),
            array('  '),
            array("\n"),
            array("\t")
            );
    }
}