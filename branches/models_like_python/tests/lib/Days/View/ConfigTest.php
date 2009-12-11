<?php
/**
 *
 * @copyright    Copyright (c) 2009 phpDays foundation (http://phpdays.org)
 * @license      http://www.opensource.org/licenses/mit-license.php The MIT License
 * @package      phpDays
 * @subpackage   tests
 */
require_once 'lib/Days/View/Config.php';
require_once dirname(__FILE__) . '/_stubs/Days_Engine.php';
require_once dirname(__FILE__) . '/_stubs/Days_Config.php';

/**
 * Tests for the Days_View_Config class.
 */
class Days_View_ConfigTest extends PHPUnit_Framework_TestCase {

    public function testSlashAdded() {
        $dir = 'app directory';
        Days_Engine::$appDir = $dir;
        $config = new Days_View_Config();
        $dir .= '/';
        $this->assertEquals($dir . Days_View_Config::TEMPLATE_DIR,
            $config->getTemplateDir());
        Days_Engine::$appDir = $dir;
        $this->assertEquals($dir . Days_View_Config::TEMPLATE_DIR,
            $config->getTemplateDir());
    }
    
    public function testDirectories() {
        $dir = 'app directory/';
        Days_Engine::$appDir = $dir;
        $config = new Days_View_Config();
        $this->assertEquals($dir . Days_View_Config::TEMPLATE_DIR,
            $config->getTemplateDir());
        $this->assertEquals($dir . Days_View_Config::COMPILE_DIR,
            $config->getCompileDir());
        $this->assertEquals($dir . Days_View_Config::CACHE_DIR,
            $config->getCacheDir());
    }
}