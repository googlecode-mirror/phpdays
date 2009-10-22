<?php
/**
 *
 * @copyright    Copyright (c) 2009 phpDays foundation (http://phpdays.org)
 * @license      http://www.opensource.org/licenses/mit-license.php The MIT License
 * @package      phpDays
 * @subpackage   tests
 */
require_once 'PHPUnit/Framework.php';
require_once 'lib/Days/View.php';

/**
 * Tests for the Days_View class.
 */
class Days_View_Engine {
}
class Days_ViewTest extends PHPUnit_Framework_TestCase {

    /**
     * @covers Day_View::factory
     */
    public function testResultClassName() {
        $ref = new Days_View_Engine();
        $factory_ref = Days_View::factory('engine');
        $this->assertTrue($ref == $factory_ref);
    }
}
?>