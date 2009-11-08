<?php
/**
 *
 * @copyright    Copyright (c) 2009 phpDays foundation (http://phpdays.org)
 * @license      http://www.opensource.org/licenses/mit-license.php The MIT License
 * @package      phpDays
 * @subpackage   tests
 */

require_once 'lib/Days/View/Interface.php';
require_once 'lib/Days/View/Templum.php';
require_once 'lib/Days/Engine.php';
require_once 'lib/Days/Config.php';
require_once 'lib/Days/Config/Yaml.php';
require_once 'lib/Spyc/Spyc.php';
require_once dirname(__FILE__) . '/InterfaceTest.php';

/**
 * Stubs
 */
class Templum {
    public static function singleton() {
    }

    public static function setTemplateDir($var) {
    }

    public static function setCompileDir($var) {
    }
}

/**
 * Tests for the Days_View_TemplumTest class.
 */
class Days_View_TemplumTest extends Days_View_InterfaceTest {

    protected function setUp() {
        $this->view = new Days_View_Templum();
    }
}