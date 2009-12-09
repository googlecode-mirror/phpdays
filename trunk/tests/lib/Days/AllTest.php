<?php
/**
 *
 * @copyright    Copyright (c) 2009 phpDays foundation (http://phpdays.org)
 * @license      http://www.opensource.org/licenses/mit-license.php The MIT License
 * @package      phpDays
 * @subpackage   tests
 */
$path = realpath(dirname(__FILE__).'/../../../');
set_include_path(get_include_path() . PATH_SEPARATOR . $path);

require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__) . '/EventTest.php';
require_once dirname(__FILE__) . '/ViewTest.php';
require_once dirname(__FILE__) . '/View/ConfigTest.php';
require_once dirname(__FILE__) . '/View/DwooTest.php';
require_once dirname(__FILE__) . '/View/PhpTest.php';
require_once dirname(__FILE__) . '/View/SmartyTest.php';
require_once dirname(__FILE__) . '/View/TemplumTest.php';


class Days_AllTests
{
    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('PHPUnit Framework');
        $suite->addTestSuite('Days_EventTest');
        $suite->addTestSuite('Days_ViewTest');
        $suite->addTestSuite('Days_View_ConfigTest');
        $suite->addTestSuite('Days_View_DwooTest');
        $suite->addTestSuite('Days_View_PhpTest');
        $suite->addTestSuite('Days_View_SmartyTest');
        $suite->addTestSuite('Days_View_TemplumTest');
        return $suite;
    }
}