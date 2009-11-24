<?php
/**
 * View configuration contains directories and cache time.
 *
 * Part of "php:Days - php5 framework" project (http://phpdays.googlecode.com).
 *
 * @copyright    Copyright (c) 2009 phpDays foundation (http://phpdays.org)
 * @license      http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link         http://code.google.com/p/phpdays/wiki/EnLibDaysViewAbstract
 * @package      Days
 * @subpackage   View
 * @author       Anton Danilchenko <happy@phpdays.org>
 */

class Days_View_Config {
    /** @var string Subdirectory for templates. */
    const TEMPLATE_DIR = 'View/';
    
    /** @var string Subdirectory for compiled templates. */
    const COMPILE_DIR  = 'system/view/';
    
    /** @var string Subdirectory for cached templates. */
    const CACHE_DIR    = 'system/cache/';
    
    /** @var string Application's directory. */
    private static $_appDir = null;

    /** @var string Template directory. */
    private static $_templateDir;
    
    /** @var string Directory for compiled templates. */
    private static $_compileDir;
    
    /** @var string Directory for cached templates. */
    private static $_cacheDir;
    
    /** @var int Caching time in seconds. */
    private static $_caching;
    
    public function __construct() {
        $appPath = Days_Engine::appPath();
        if (0 == strcmp($appPath, self::$_appDir)) {
            return;
        }
                    
        self::$_appDir = $appPath;
        if ('/' != substr(self::$_appDir, -1)) {
            self::$_appDir .= '/';
        }
        self::$_templateDir = self::$_appDir . self::TEMPLATE_DIR;
        self::$_compileDir = self::$_appDir . self::COMPILE_DIR;
        self::$_cacheDir = self::$_appDir . self::CACHE_DIR;
        self::$_caching = 
            Days_Config::load()->get('cache/lifetime', 0);
    }
    
    /**
     * Get the directory where templates are stored.
     * 
     * @return string Directory for templates.
     */
    public function getTemplateDir() {
        return self::$_templateDir;
    }
    
    /**
     * Get the directory where the compiled templates are stored.
     * 
     * @return string Directory for compiled templates.
     */
    public function getCompileDir() {
        return self::$_compileDir;
    }
    
    /**
     * Get the directory where the cached templates are stored.
     * 
     * @return string Directory for cached templates.
     */
    public function getCacheDir() {
        return self::$_cacheDir;
    }
    
    /**
     * Get time for how long cached templates are valid.
     * 
     * @return int Time in seconds for how long templates are cached.
     */
    public function getCaching() {
        return self::$_caching;
    }
}