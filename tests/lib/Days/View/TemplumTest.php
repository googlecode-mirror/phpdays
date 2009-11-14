<?php
/**
 *
 * @copyright    Copyright (c) 2009 phpDays foundation (http://phpdays.org)
 * @license      http://www.opensource.org/licenses/mit-license.php The MIT License
 * @package      phpDays
 * @subpackage   tests
 */

require_once 'lib/Days/View/Interface.php';
require_once 'lib/Days/View/Abstract.php';
require_once 'lib/Days/View/Templum.php';
require_once dirname(__FILE__) . '/InterfaceTest.php';
require_once dirname(__FILE__) . '/_stubs/Days_Engine.php';
require_once dirname(__FILE__) . '/_stubs/Days_Config.php';
require_once dirname(__FILE__) . '/_stubs/Days_Exception.php';
require_once 'lib/Templum/Templum.php';

/**
 * Tests for the Days_View_TemplumTest class.
 */
class Days_View_TemplumTest extends Days_View_InterfaceTest {
	/**
	 * @var string
	 */
    protected static $tempDir = null;

    public static function setUpBeforeClass() {
        self::$tempDir = self::_tempDir() . '/';
        mkdir(self::$tempDir . 'View/');
        mkdir(self::$tempDir . 'system/view', 0777, true);
    }

    public static function tearDownAfterClass() {
        Days_Engine::setAppDir('');
        self::_rmDir(self::$tempDir);
    }
    protected function setUp() {
        Days_Engine::setAppDir(self::$tempDir);
        $this->view = new Days_View_Templum();
    }
    
    protected function assertPreConditions() {
        $this->assertNotNull(self::$tempDir);
    }

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
}