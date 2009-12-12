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
abstract class Days_Model {
    /** @var string Name of current model (without prefix "Model") */
    protected $_name;
    /** @var int Count of returned rows in result set (maximum value is 1000) */
    protected $_limit = 1000;
    /** @var array Conditions as [tableName]=>[where clause with inserted values] */
    protected $_where = array();

    /**
     * Create model object and set conditions.
     *
     * @param mixed Condition and placeholder values
     */
    public function __construct($conditions) {
        // get all parameters, passed to method
        $params = func_get_args();
        // autodetect name of current model and save it
        $this->_name = substr(__CLASS__, strpos(__CLASS__, 'Model_'));
        // set conditions to current model object
        if (count($params) > 0) {
            $this->where($params);
        }
    }

    /**
     * Add conditions from passed models and find references between models.
     *
     * @param Days_Model $model Model object (pass many models in next parameters)
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
     * @return this
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
     * Set limit of returned lines.
     *
     * @param int $rows Count of result rows
     * @return this
     */
    public function limit($rows) {
        if ($rows < 1000 AND $rows>0) {
            $this->_limit = $rows;
        }
        // link to current model
        return $this;
    }

    /**
     * Return model name (without prefix "Model")
     *
     * @return string
     */
    public function name() {
        return $this->_name;
    }

    /**
     * Return unique key for current row.
     *
     * @return string
     */
//    public function key() {
//        return "{$this->name()}_{$this->_id}";
//    }
}