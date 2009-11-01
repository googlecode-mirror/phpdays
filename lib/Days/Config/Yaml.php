<?php
/**
 * YAML Config - used for read files in yaml format and convert it to array.
 *
 * Part of "php:Days - php5 framework" project (http://phpdays.sf.net).
 *
 * @copyright    Copyright (c) 2009 phpDays foundation (http://phpdays.org)
 * @license      http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link         http://code.google.com/p/phpdays/wiki/EnLibDaysConfigYaml
 * @package      phpDays
 * @subpackage   phpDays library
 * @author       Anton Danilchenko <happy@phpdays.org>
 */
class Days_Config_Yaml {
    public static function load($filename) {
        // cache object
#        $oCache = Days_Cache::instance();
        // load configuration file from cache
#        if ($oCache->isCached($filename)) {
#            $config = $oCache->getCache($filename);
#        }
        // load configuration file and set to cache
#        else {
            // check file
            if (! file_exists($filename))
                throw new Days_Exception("Configuration file '{$filename}' not found");
            // use fast Yaml module for php (if exists)
            if (function_exists('syck_load'))
                $config = syck_load(file_get_contents($filename));
            // use php class
            else
                $config = Spyc::YAMLLoad($filename);
            // renew cache
#            $oCache->setCache($filename, $config);
#        }
        // return result array
        return $config;
    }
}