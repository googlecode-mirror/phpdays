<?php
/**
 * Db (database) table rowset - used for work with table rows collection.
 *
 * Part of "php:Days - php5 framework" project (http://phpdays.googlecode.com).
 *
 * @copyright    Copyright (c) 2009 phpDays foundation (http://phpdays.org)
 * @license      http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link         http://code.google.com/p/phpdays/wiki/EnLibDaysDbRowset
 * @package      Days
 * @subpackage   Db
 * @author       Anton Danilchenko <happy@phpdays.org>
 */
class Days_Db_Rowset implements Countable, ArrayAccess, Iterator {
    /** @var array Instances of Days_Db_Row */
    protected $_rows = array();
    /** @var Days_Db_Table Parent table */
    protected $_table;

    public function  __construct(Days_Db_Table $table) {
        $this->_table = $table;
    }

    /**
     * Create new row.
     *
     * @param array $data Data to insert in row
     * @return Days_Db_Row
     */
    public function create(array $data=array()) {
        $row = new Days_Db_Row($data, $this->_table, $this);
        $this->_rows[] = $row;
        return $row;
    }

    public function save(Days_Db_Row $row) {
        $this->_table->save($row);
    }

    public function delete(Days_Db_Row $row) {
        $this->_table->delete($this);
    }

    /**
     * Return count of variables.
     *
     * @return int
     */
    public function count() {
        return count($this->_rows);
    }

    /**
     * Set pointer to first position.
     */
    public function rewind() {
        reset($this->_rows);
    }

    /**
     * Return current element.
     */
    public function current() {
        return current($this->_rows);
    }

    /**
     * Return variable name for current element.
     */
    public function key() {
        return key($this->_rows);
    }

    /**
     * Set pointer to next element.
     */
    public function next() {
        return next($this->_rows);
    }

    /**
     * Check if current element exists.
     */
    public function valid() {
        return (false!==$this->current()) ;
    }

    /**
     * Set variable (as property).
     *
     * @param $offset string: Int or string variable name
     * @param $value string: Value of specified variable
     * @return void
     */
    public function __set($offset, $value) {
        $this->offsetSet($offset, $value);
    }

    /**
     * Set variable (as array key).
     *
     * Use cases:
     *  - $rowset[] = $row;
     *  - $rowset[2] = $row;
     *
     * @param string $offset Int or string variable name
     * @param string $value Value of specified variable
     */
    final public function offsetSet($offset, $value) {
        // set row into rowset
        if (is_null($offset) OR is_numeric($offset)) {
            // check row type
            if (! $value instanceof Days_Db_Row)
                throw new Days_Exception('Value should be a type of Days_Db_Row');
            // add new element
            if (is_null($offset))
                $this->_rows[] = $value;
            // replace existing row
            else
                $this->_rows[$offset] = $value;
        }
        // set value for current row
        else {
            // check current row position
            if (! $this->current())
                throw new Days_Exception('Not exist current row in rowset');
            $this->current()->$offset = $value;
        }
    }

    /**
     * Check current variable (as property).
     *
     * @param string $offset Int or string variable name
     * @return bool
     */
    public function __isset($offset) {
        return $this->offsetExists($offset);
    }

    /**
     * Check current variable (as array key).
     *
     * @param string $offset Int or string variable name
     * @return bool
     */
    final public function offsetExists($offset) {
        return isset($this->_rows[$offset]);
    }

    /**
     * Unset existing variable (as property).
     *
     * @param string $offset Int or string variable name
     */
    public function __unset($offset) {
        $this->offsetUnset($offset);
    }

    /**
     * Unset existing variable (as array key).
     *
     * @param string $offset Int or string variable name
     */
    final public function offsetUnset($offset) {
        unset ($this->_rows[$offset]);
    }

    /**
     * Return joined table with special conditions.
     *
     * @param string $offset Table name to join
     * @param array $params Conditions for join table
     * @return mixed
     */
    public function __call($offset, array $params=array()) {
        if (! $this->valid())
            return null;
        return $this->current()->__call($offset, $params);
    }

    /**
     * Return specified variable (as property).
     *
     * @param $offset string: Int or string variable name
     * @return mixed
     */
    public function __get($offset) {
        return $this->offsetGet($offset);
    }

    /**
     * Return specified variable (as array key).
     *
     * @param string $offset Int or string variable name
     * @return mixed
     */
    final public function offsetGet($offset) {
        // get row from rowset
        if (is_numeric($offset)) {
            return isset($this->_rows[$offset]) ? $this->_rows[$offset] : null;
        }
        // return field value from current row
        else {
            if (! $this->valid())
                return null;
            return $this->current()->$offset;
        }
    }

    public function toArray() {
        $rows = array();
        foreach ($this->_rows as $row)
            $rows[] = $row->toArray();
        return $rows;
    }

    /**
     * Set object in row state.
     *
     * @return int
     */
    protected function _cleanup() {
        $this->_rows = array();
    }
}