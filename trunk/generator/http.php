<?php
/**
 * Generate application from web browser.
 *
 * @copyright    Copyright (c) 2009 phpDays foundation (http://phpdays.org)
 * @license      http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link         http://code.google.com/p/phpdays/wiki/EnLibDaysAcl
 * @package      Days
 * @subpackage   Tool
 * @author       Anton Danilchenko <happy@phpdays.org>
 * @version      1.1
 */
// include dependencies
include_once (realpath(dirname(__FILE__) . '/../lib/Days/Tool/AppGenerator.php'));
// start application
try {
    // create generator object
    $generator = Days_Tool_AppGenerator::singleton();
}
catch (Exception $ex) {
    print $ex->getMessage();
}