<?php
/**
 * Model (MVC pattern) - base class for all application defined models.
 *
 * Part of "php:Days - php5 framework" project (http://phpdays.sf.net).
 *
 * @copyright    Copyright (c) 2009 phpDays foundation (http://phpdays.org)
 * @license      http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link         http://code.google.com/p/phpdays/wiki/EnLibDaysLog
 * @package      phpDays
 * @subpackage   phpDays library
 * @author       Anton Danilchenko <happy@phpdays.org>
 */
class Days_Model {
    private static $_path;
    private static $_prefix;
    /** Models instances */
    private static $_models = array();

    /**
     * Return model instance by name.
     *
     * @param string $model Model name (without prefix `App_Model_`)
     * @param array $params Parameters placed into constructor
     * @return Days_Db_Table
     */
    public static function factory($model, array $params=array()) {
        // include module
        $model = self::ucwords($model);
        $modelClass = self::$_prefix . "Model_{$model}";
        // create model instance
        if (! isset(self::$_models[$modelClass])) {
            // autoload class
            class_exists($modelClass, true);
            // create module instance
            self::$_models[$modelClass] = new $modelClass();
        }
        // return module instance
        return self::$_models[$modelClass];
    }

    public static function setPath($path) {
        self::$_path = $path;
    }

    public static function setPrefix($prefix) {
        self::$_prefix = ucfirst($prefix) . '_';
    }

    /**
     * Upper case letter in each word (after ` ` and `_`).
     *
     * @param string $word String to processing
     * @return string
     */
    protected static function ucwords($word) {
        $word = str_replace('_', ' ', $word);
        $word = ucwords($word);
        return str_replace(' ', '_', $word);
    }
}