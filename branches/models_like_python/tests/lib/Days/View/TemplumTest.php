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
require_once 'lib/Days/View/Config.php';
require_once 'lib/Days/Exception.php';
require_once 'lib/Templum/Templum.php';
require_once dirname(__FILE__) . '/InterfaceTest.php';

/**
 * Tests for the Days_View_TemplumTest class.
 */
class Days_View_TemplumTest extends Days_View_InterfaceTest {

    protected function setUp() {
        $this->view = new Days_View_Templum(new Days_View_Config());
    }
}