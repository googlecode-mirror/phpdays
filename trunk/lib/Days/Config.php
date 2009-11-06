<?php
/**
 * Config - used for read files in different formats and convert it to array.
 *
 * Part of "php:Days - php5 framework" project (http://phpdays.googlecode.com).
 *
 * @copyright    Copyright (c) 2009 phpDays foundation (http://phpdays.org)
 * @license      http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link         http://code.google.com/p/phpdays/wiki/EnLibDaysConfig
 * @package      phpDays
 * @subpackage   phpDays library
 * @author       Anton Danilchenko <happy@phpdays.org>
 */
class Days_Config {
    /** Default config name */
    private static $_defConfig = 'production';
    private static $_confPath = 'config';
    /** Already loaded configurations */
    private static $_configs = array();
    /** Configuration parameters */
    private $_config = array();

    private function __construct($filename) {
        // set full path
        $filename = self::$_confPath . $filename . '.yaml';
        // load config
        $this->_config = Days_Config_Yaml::load($filename);;
    }

    public function get($sectionPath=null, $default=null) {
        // return full configuration
        if (is_null($sectionPath)) {
            return $this->_config;
        }
        // parse sections by '/'
        $sections = explode('/', $sectionPath);
        // find parameter
        $resultConfig = $this->_config;
        foreach ($sections as $sectionName)
            // goto in
            if (array_key_exists($sectionName, $resultConfig))
                $resultConfig = $resultConfig[$sectionName];
            // section not found
            else
                return $default;
        // return section options
        return $resultConfig;
    }

    public static function setDefaultConfig($configName) {
        self::$_defConfig = $configName;
    }

    public static function setConfigPath($path) {
        self::$_confPath = $path;
    }

    /**
     * Return config object (singleton factory).
     *
     * @param $filename string: Config name (by default use main system config)
     * @return Days_Config
     */
    public static function load($filename=null) {
        // get default configuration
        if (is_null($filename))
            $filename = self::$_defConfig;
        // load configuration
        if (! in_array($filename, self::$_configs))
            self::$_configs[$filename] = new self($filename);
        // return loaded configuration
        return self::$_configs[$filename];
    }
}