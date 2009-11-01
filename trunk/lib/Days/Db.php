<?php
/**
 * Db (database) - used for work with different database engines.
 *
 * Part of "php:Days - php5 framework" project (http://phpdays.sf.net).
 *
 * @copyright    Copyright (c) 2009 phpDays foundation (http://phpdays.org)
 * @license      http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link         http://code.google.com/p/phpdays/wiki/EnLibDaysDb
 * @package      phpDays
 * @subpackage   phpDays library
 * @author       Anton Danilchenko <happy@phpdays.org>
 */
class Days_Db {
    /**
     * Return new database object.
     *
     * @param $schema string: Name of database schema in config
     * @return Days_Db
     */
    public static function factory($schema='default', $dbtype='Zend') {
        // recive databace configuration
        $aConfig = Days_Config::load()->get("db/{$schema}", array());
        // check schema in configuration
        if (empty($aConfig))
            throw new Days_Exception("Not defined database configuration section 'db/{$schema}'");
        // set correct type of database driver
        $aConfig['adapter'] = 'PDO_' . strtoupper($aConfig['adapter']);
        // buffering data only for mysql driver
        if ('PDO_MYSQL'==$aConfig['adapter'])
            $aConfig[PDO::MYSQL_ATTR_USE_BUFFERED_QUERY] = true;
        // create Zend_Db object
        $_db = Zend_Db::factory($aConfig['adapter'], $aConfig);
        // prepare object to work with correct character encoding
        $_db->query('SET CHARACTER SET utf8');
        $_db->query('SET NAMES utf8');
        // set objects in result set
        $_db->setFetchMode(Zend_Db::FETCH_OBJ);
        return $_db;
    }

    /**
     * Private constructir.
     *
     * @return Days_Db
     */
    private function __construct() {
    }
}