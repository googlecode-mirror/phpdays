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
require_once dirname(__FILE__) . '/InterfaceTest.php';
require_once dirname(__FILE__) . '/_stubs/Days_Engine.php';
require_once dirname(__FILE__) . '/_stubs/Days_Config.php';

/**
 * Tests for the Days_View_Smarty class.
 */
class Days_View_SmartyTest extends Days_View_InterfaceTest {

    protected function setUp() {
        $this->view = new Days_View_Smarty();
    }
}