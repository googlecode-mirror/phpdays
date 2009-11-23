<?php
ini_set("include_path", "..".PATH_SEPARATOR.ini_get("include_path"));
require_once 'PHPUnit/Framework.php';
require_once 'Templum.php';

class TemplumTest extends PHPUnit_Framework_TestCase
{
    const TEMPLATE_DIR = '../template';
    const CACHE_DIR = '../cache';
    /**
     * @var    Templum
     * @access protected
     */
    protected $object;


    /**
     * Sets up the fixture.
     * This method is called before a test is executed.
     *
     * @access protected
     */
    public function setUp() {
        $this->object = new Templum(self::TEMPLATE_DIR, self::CACHE_DIR);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     *
     * @access protected
     */
    protected function tearDown()
    {
    }

    /**
     * @todo Implement testSetTemplateDir().
     */
    public function testSetTemplateDir() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testSetCompileDir().
     */
    public function testSetCompileDir() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testSetHelperDir().
     */
    public function testSetHelperDir() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testSetCallbackOnCreate().
     */
    public function testSetCallbackOnCreate() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testSetCallbackOnCall().
     */
    public function testSetCallbackOnCall() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testHasExist().
     */
    public function testHasExist() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testClearCompiled().
     */
    public function testClearCompiled() {
        // set path to dir
        $aPath = self::CACHE_DIR . '/unit_test.html';
        // create file
        $oFd = fopen($aPath, 'w');
        fwrite($oFd, 'Test text');
        fclose($oFd);
        // clear all cache in dir
        $this->_oTemplum->clearCache();
        // check file on disk
        $bExist = file_exists($aPath);
        // set result
        $this->assertFalse($bExist);
    }

    /**
     * @todo Implement testGetTemplate().
     */
    public function testGetTemplate() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }
}