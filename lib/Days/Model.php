<?php
/**
 * Model (MVC pattern) - base class for all application defined models.
 *
 * Part of "php:Days - php5 framework" project (http://phpdays.googlecode.com).
 *
 * @copyright    Copyright (c) 2009 phpDays foundation (http://phpdays.org)
 * @license      http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link         http://code.google.com/p/phpdays/wiki/EnLibDaysLog
 * @package      Days
 * @subpackage   Days
 * @author       Anton Danilchenko <happy@phpdays.org>
 */
abstract class Days_Model extends Days_Db_Table {
    /**
     * Create model object and set conditions.
     *
     * @param mixed Condition and placeholder values
     */
    public function __construct() {
        // execute parent constructor
        parent::__construct();
        // get all parameters, passed to method
        $params = func_get_args();
        // set conditions to current model object
        if (count($params) > 0) {
            $this->where($params);
        }
    }

    /**
     * Add conditions from passed models and find references between models.
     *
     * @param Days_Model $model Model object (pass many models in next parameters)
     * @return Days_Model
     */
    public function with(Days_Model $model) {
        // get all parameters, passed to method
        $params = func_get_args();
        // check params type
        foreach ($params as $model) {
            if (! $model instanceof Days_Model) {
                throw new Days_Exception('Incorrect parameter type. Expected Days_Model parameters');
            }
        }
        // load all references between models
        // load all conditions from passed models
        foreach ($params as $model) {
            // get table name
            $table = $model->name();
            // get where clause
            $where = $model->where();
            // add condition
            $this->where($where);
        }
        // link to current model
        return $this;
    }

    /**
     * Add "where" condition OR return current conditions.
     *
     * @param string $conditions Condition string with numerical placeholders
     * @param mixed Palceholders values
     * @return Days_Model
     */
    public function where($conditions=null) {
        // get all parameters, passed to method
        $params = func_get_args();
        // delete first parameter - condition string
        array_shift($params);
        // get table name
        $table = $this->name();
        // return already setted conditions
        if (is_null($conditions)) {
            return (isset ($this->_where[$table]) ? $this->_where[$table] : '');
        }
        // insert placeholders to condition
        $where = '...';
        // get previous setted condition
        if (isset ($this->_where[$table])) {
            $where = "{$this->_where[$table]} AND {$where}";
        }
        // set condition
        $this->_where[$table] = $where;
        // link to current model
        return $this;
    }

    /**
     * Set sort order of returned lines.
     *
     * @param int $column Name of column with ASC or DESC
     * @return Days_Model
     */
//    public function sort($column) {
//        // get all parameters, passed to method
//        $params = func_get_args();
//        // set parameters to sort order
//        foreach ($params as $column) {
//            $this->_sort[] = $column;
//        }
//        // link to current model
//        return $this;
//    }

    /**
     * Return database object.
     *
     * @param string $schema Name of database configuration section
     * @return Days_Db
     */
//    public function db($schema=null) {
//        return Days_Db::factory($schema);
//    }

    /**
     * Return unique key for current row.
     *
     * @return string
     */
//    public function key() {
//        return "{$this->name()}_{$this->_id}";
//    }
}
