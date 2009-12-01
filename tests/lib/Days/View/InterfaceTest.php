<?php
/**
 *
 * @copyright    Copyright (c) 2009 phpDays foundation (http://phpdays.org)
 * @license      http://www.opensource.org/licenses/mit-license.php The MIT License
 * @package      phpDays
 * @subpackage   tests
 */
require_once dirname(__FILE__) . '/_stubs/Days_Engine.php';
require_once dirname(__FILE__) . '/_stubs/Days_Config.php';
/**
 * Common tests for classes implementing the Days_View_Interface
 * interface.
 */
abstract class Days_View_InterfaceTest extends PHPUnit_Framework_TestCase {
    /** @var Days_View_Interface */
    protected $view;
    protected static $viewConfig;

    public function testTemplateNotFound() {
        $this->setExpectedException('Days_Exception');
        $this->view->render('NoSuchFile');
    }
    
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

    /**
     * Fixture setup.
     */
    
    /** @var array View configuration */
    //protected static $viewConfig = null;
        
    /** @var string Application directory */
    private static $_tempDir = null;

    public static function setUpBeforeClass() {
        self::$_tempDir = self::_tempDir() . '/';
        Days_Engine::$appDir = self::$_tempDir;
        self::_createDirTree();
    }
    public static function tearDownAfterClass() {
        self::_rmDir(self::$_tempDir);    
    }
    
    protected function assertPreConditions() {
        $this->assertNotNull(self::$_tempDir);
    }

    /**
     * End of the fuxture setup.
     */
    
    /** 
     * Utility functions
     */
    private static function _tempDir() {
        $tempName = tempnam(sys_get_temp_dir(), 'phpdays_');
        if ($tempName && unlink($tempName) && mkdir($tempName)) {
            return $tempName;
        } else {
            return null;
        }
    }
    private static function _rmDir($dir) {
        foreach (glob("$dir/*") as $file) {
            is_dir($file) ? self::_rmDir($file) : unlink($file);
        }
        file_exists($dir) && rmdir($dir);
    }
    private static function _createDirTree() {
        $config = new Days_View_Config();
        mkdir($config->getTemplateDir());
        mkdir($config->getCompileDir(), 0777, true);
        mkdir($config->getCacheDir(), 0777, true); 
    }
}