<?php
/**
 * Days_EventTest - Test Class for Days_Event
 *
 * @copyright    Copyright (c) 2009 phpDays foundation (http://phpdays.org)
 * @license      http://www.opensource.org/licenses/mit-license.php The MIT License
 * @package      phpDays
 * @subpackage   tests
 */
$path = realpath(dirname(__FILE__).'/../../../');
set_include_path(get_include_path() . PATH_SEPARATOR . $path);

require_once 'PHPUnit/Framework.php';
require_once 'lib/Days/Event.php';
require_once 'lib/Days/Exception.php';
require_once dirname(__FILE__) . '/Event/Func.php';

/**
 * Test for Days_Event.
 *
 */
class Days_EventTest extends PHPUnit_Framework_TestCase {

    /**
     * @dataProvider eventsToAdd
     */
    public function testAddEvent($event, $func) {
        Days_Event::add($event, $func);
        $observers=Days_Event::get($event);
        $this->assertFalse(empty($observers));
    }

    /**
     * @dataProvider eventsToRun
     */
    public function testRunEvent($event, $param, $result) {
        ob_start();
        Days_Event::run($event,$param);
        $real_result=ob_get_clean();

        $this->assertEquals($real_result, $result);
    }

    public function eventsToAdd() {
        return array(
            array('need_summ','summ'),
            array('need_summ','sub'),
            array('user_login_succ','user_login_succ')
            );
    }

    public function eventsToRun() {
        return array(
            array('need_summ', array(7,2), '95'),
            array('need_summ', array(4,2), '62'),
            array('user_login_succ', array(),'Yahoo!')
            );
    }
}