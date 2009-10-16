<?php
/**
 * Templum - php template engine.
 *
 * @version 1.0
 * @link http://templum.googlecode.com
 * @license Apache License 2.0 http://www.apache.org/licenses/LICENSE-2.0
 * @author Anton Danilchenko <anton.danilchenko@gmail.com>
 */
class Templum {
    /** Path to current directory. */
    private static $_rootDir;
    /** Path to compiled templates directory. */
    private static $_compileDir;
    /** Path to raw templates directory. */
    private static $_templateDir;
    /** @var Templum_Compiler */
    private static $_compiler;
    /** @var Templum */
    private static $_instance;

    public static function singleton() {
        // create instance
        if (! isset(self::$_instance)) {
            self::$_instance = new self();
        }
        // return instance
        return self::$_instance;
    }

    private function __construct() {
        // set date (need for save cache file in Windows)
        if (! date_default_timezone_get())
            date_default_timezone_set('Europe/Kiev');
        // set parameters
        self::$_rootDir = dirname(__FILE__) . '/';
        // set template dir
        if (! isset (self::$_templateDir))
            self::setTemplateDir(self::$_rootDir . 'template');
        // set compile dir
        if (! isset (self::$_compileDir))
            self::setCompileDir(self::$_rootDir . 'compile');
        self::$_compiler = Templum::factory('Compiler');
        // load interfaces and abstract classes
        self::_include('Component_Abstract');
        self::_include('Component_Block_Abstract');
        self::_include('Component_Function_Abstract');
        self::_include('Component_Filter_Abstract');
        self::_include('Component_Processor_Abstract');
    }

    /**
     * Return executed template.
     *
     * @var string
     */
    public function get($template, array $vars=array()) {
        return self::$_compiler->get($template, $vars);
    }

    public static function setTemplateDir($path) {
        self::checkDir($path);
        self::$_templateDir = rtrim($path, '/') . '/';
    }

    public static function setCompileDir($path) {
        self::checkDir($path, true);
        self::$_compileDir = rtrim($path, '/') . '/';
    }

    public static function getTemplateDir() {
        return self::$_templateDir;
    }

    public static function getCompileDir() {
        return self::$_compileDir;
    }

    /**
     * Create Templum object.
     *
     * @param array $config: Template engine settings
     *  - template_dir: Path to templates directory
     *  - compile_dir: Path to cache directory
     * @return Templum
     */
    public static function factory($className, array $params=array()) {
        self::_include($className);
        $className = "Templum_{$className}";
        // create new object
        return new $className($params);
    }

    protected static function _include($file) {
        $classPath = self::$_rootDir . str_replace('_', '/', $file) . '.php';
        if (! file_exists($classPath))
            throw new Templum_Exception("Not found file `{$classPath}`");
        include_once ($classPath);
    }


    /**
     * Check directory on readable and writable.
     *
     * @param string $path path to directory
     * @param bool $writable Check on writeble
     */
    public static function checkDir($path, $writable=false) {
        // check directory
        if (! is_dir($path) OR ! is_readable($path) )
            throw new Templum_Exception("Directory `{$path}` should be created and readable");
        if ($writable AND ! is_writable($path))
            throw new Templum_Exception("Directory `{$path}` should be writable");
    }

    /**
     * Check if template file exists.
     *
     * @param string $template Template file name
     * @var bool
     */
    public static function exists($template) {
        // check file on disk
        return file_exists(self::$_templateDir . $template);
    }

    /** Clear all compiled templates */
    public function clearCompiled() {
        if (isset (self::$_compileDir) AND ! empty (self::$_compileDir))
            self::$_compiler->clearCompiled();
    }
}

class Templum_Exception extends Exception {
}