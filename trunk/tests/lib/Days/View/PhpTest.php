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
require_once 'lib/Days/View/Php.php';
require_once 'lib/Days/View/Config.php';
require_once 'lib/Days/Exception.php';
require_once dirname(__FILE__) . '/InterfaceTest.php';

/**
 * Tests for the Days_View_Php class.
 */
class Days_View_PhpTest extends Days_View_InterfaceTest {

    protected function setUp() {
        // Create a stub for the Days_View_Config class.
        $config = $this->getMock('Days_View_Config');
        // Configure the stub.
        $config->expects($this->once())
            ->method('getTemplateDir')
            ->will($this->returnValue($this->getTemplateDir()));
        $this->view = new Days_View_Php($config);
    }
}