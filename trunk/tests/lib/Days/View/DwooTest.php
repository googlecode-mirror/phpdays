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
require_once 'lib/Days/View/Dwoo.php';
require_once 'lib/Days/Exception.php';
require_once 'lib/Days/View/Config.php';
require_once 'lib/Dwoo/Dwoo.php';
require_once 'lib/Dwoo/Dwoo/IDataProvider.php';
require_once 'lib/Dwoo/Dwoo/Data.php';
require_once 'lib/Dwoo/Dwoo/Exception.php';
require_once dirname(__FILE__) . '/InterfaceTest.php';

/**
 * Tests for the Days_View_Dwoo class.
 */
class Days_View_DwooTest extends Days_View_InterfaceTest {

    protected function setUp() {
        $this->createDirectories();
        // Create a stub for the Days_View_Config class.
        $config = $this->getMock('Days_View_Config');
        // Configure the stub.
        $config->expects($this->once())
            ->method('getTemplateDir')
            ->will($this->returnValue($this->getTemplateDir()));
        $config->expects($this->once())
            ->method('getCompileDir')
            ->will($this->returnValue($this->getCompileDir()));
        $config->expects($this->once())
            ->method('getCacheDir')
            ->will($this->returnValue($this->getCacheDir()));
        $this->view = new Days_View_Dwoo($config);
    }
    
    protected function tearDown() {
        $this->removeDirectories();
    }
    
    private function createDirectories() {
        mkdir($this->getTemplateDir());
        mkdir($this->getCompileDir(), 0777, true);
        mkdir($this->getCacheDir(), 0777, true);
    }
    
    private function removeDirectories() {
        rmdir($this->getTemplateDir());
        rmdir($this->getCompileDir());
        rmdir($this->getCacheDir());    
    }
}