<?php
/**
 * Db (database) table row - used for work with table row.
 *
 * Part of "php:Days - php5 framework" project (http://phpdays.googlecode.com).
 *
 * @copyright    Copyright (c) 2009 phpDays foundation (http://phpdays.org)
 * @license      http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link         http://code.google.com/p/phpdays/wiki/EnLibDaysDbRow
 * @package      Days
 * @subpackage   Db
 * @author       Anton Danilchenko <happy@phpdays.org>
 */
class Days_Db_Row implements ArrayAccess {
    /** Physical values in current table. */
    protected $_values = array();
    /** Virtual values from other tables. */
    protected $_references = array();
    /** @var Days_Db_Table */
    protected $_table;
    /** @var Days_Db_Rowset */
    protected $_rowset;

    public function __construct(array $data, Days_Db_Table $table, Days_Db_Rowset $rowset) {
        $this->_table = $table;
        $this->_rowset = $rowset;
        // set data
        foreach ($data as $key=>$value)
            $this->$key = $value;
    }

    public function save() {
        $this->_rowset->save($this);
    }

    public function delete() {
        $this->_rowset->delete($this);
    }

    /**
     * Set variable (as property).
     *
     * @param string $offset Int or string variable name
     * @param string $value Value of specified variable
     */
    public function __set($offset, $value) {
        $this->offsetSet($offset, $value);
    }

    /**
     * Set variable (as array key).
     *
     * Use cases:
     *  - $row['key'] = $value;
     *
     * @param $offset string: Int or string variable name
     * @param $value string: Value of specified variable
     */
    final public function offsetSet($offset, $value) {
        $this->_values[$offset] = $value;
    }

    /**
     * Return joined table with special conditions.
     *
     * @param string $offset Table name to join
     * @param array $params Conditions for join table
     * @return mixed
     */
    public function __call($offset, array $params=array()) {
        return $this->offsetGet($offset);
    }

    /**
     * Return specified variable.
     *
     * @param string $offset Int or string variable name
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
        // load virtual value
        if (! array_key_exists($offset, Days_Db_Table::info()) AND ! array_key_exists($offset, $this->_values)) {
            // current row not saved physical
            if (! isset ($this->id))
                return null;
            // recive parent table name
            if (false!==($pos=strpos($this->_table->name(), "{$offset}_"))) {
                $tableName = substr($this->_table->name(), 0, $pos) . $offset;
            }
            // refers to itself
            elseif ('child'==$offset OR 'parent'==$offset) {
                $tableName = $this->_table->name();
            }
            // recive child table name
            else {
                $tableName = $this->_table->name($offset);
            }
            // get referenced rows
            $referenceTable = Days_Model::factory('table_' . $tableName);
            $currentTableName = $this->_table->name();
            // set column name and value
            switch ($offset) {
                case 'child':
                    $currentTableColumnName  = 'pid';
                    $currentTableColumnValue = $this->id;
                    break;
                case 'parent':
                    $currentTableColumnName  = 'pid';
                    $currentTableColumnValue = $this->pid;
                    break;
                default:
                    $currentTableColumnName  = 'id';
                    $currentTableColumnValue = $this->id;
                    break;
            }
            // join outer table
            if ($tableName!=$currentTableName)
                $referenceTable->join($currentTableName);
            // find tows by criteria
            $this->_values[$offset] = $referenceTable->find('all', array(
                'where'   => array(
                    "{$currentTableName}.{$currentTableColumnName}"=>$currentTableColumnValue),
                'columns' => array(
                    "{$tableName}.*")));
        }
        // return value
        return (isset($this->_values[$offset]) ? $this->_values[$offset] : null);
    }

    /**
     * Check if variable exists.
     *
     * @param string $offset Int or string variable name
     * @return bool
     */
    public function __isset($offset) {
        return $this->offsetExists($offset);
    }

    /**
     * Check if variable exists (as array key).
     *
     * @param string $offset Int or string variable name
     * @return bool
     */
    final public function offsetExists($offset) {
        return isset($this->_values[$offset]);
    }

    /**
     * Delete variable.
     *
     * @param string $offset Int or string variable name
     */
    public function __unset($offset) {
        $this->offsetUnset($offset);
    }

    /**
     * Delete variable (as array key).
     *
     * @param string $offset Int or string variable name
     */
    final public function offsetUnset($offset) {
        unset ($this->_values[$offset]);
    }

    public function toArray() {
        return $this->_values;
    }
}