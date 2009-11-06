<?php
/**
 * Db (database) table - used for work with table data.
 *
 * Part of "php:Days - php5 framework" project (http://phpdays.googlecode.com).
 *
 * @copyright    Copyright (c) 2009 phpDays foundation (http://phpdays.org)
 * @license      http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link         http://code.google.com/p/phpdays/wiki/EnLibDaysDbTable
 * @package      phpDays
 * @subpackage   phpDays library
 * @author       Anton Danilchenko <happy@phpdays.org>
 */
class Days_Db_Table {
    /** Table name */
    protected $_name;
    /** @var Zend_Db_Adapter_Abstract */
    protected $_db;
    /** @var Zend_Db_Select */
    protected $_select;
    /** Order by column */
    protected $_order = 'date_create';
    /** Table names to join */
    protected $_join = array();
    protected static $_structure;

    public function __construct() {
        // automatically define table name (if not defined)
        if (! isset($this->_name)) {
            // delete prefix
            $className = preg_replace('`^.*Model_Table_`', '', get_class($this));
            // add slash after upper case letters
            $name = preg_replace('`[^_]([A-Z])`', '_$1', $className);
            // table name in lower case
            $this->_name = strtolower($name);
        }
        // load tables structure
        if (is_null(self::$_structure)) {
            self::$_structure = Days_Config::load('database')->get();
        }
        // check table definition
        if (! array_key_exists($this->_name, self::$_structure)) {
            throw new Days_Exception("Not defined table structure for `{$this->_name}`");
        }
        // set adapter for all tables
        if (! $this->_db) {
            $this->_db = Days_Db::factory();
            $this->_select = $this->_db->select();
        }
    }

    /**
     * Quote table name or column name.
     *
     * @param string $name Column or table name
     * @return string
     */
    protected function _quote($name) {
        return $this->_db->quoteIdentifier($name);;
    }

    /**
     * Return result rowset.
     *
     * @param string $type Return result as: all, first, last, one, count
     * @param array $cond Conditions
     *  - count (int): Count of rows in result set
     *  - page (int): Current page number (start from 1)
     *  - columns (array): Column names
     *  - where (array): Pairs `column=>$value` or `column_with_value`
     *  - group (array): Group by columns
     *  - order (array): Sorting by columns
     * @return Days_Db_Rowset|Days_Db_Row|int|null
     */
    public function find($type='last', array $cond=array()) {
        // check parameters
        if (! isset($cond['page']) OR ! is_numeric($cond['page']) OR $cond['page']<1)
            $cond['page'] = 1;
        // check columns
        if (! isset ($cond['columns']))
            $cond['columns'] = '*';
        // get select object
        $select = $this->_select->from($this->_name, $cond['columns']);
        // join with tables
        foreach (array_unique($this->_join) as $joinTable) {
            $currentTable = $this->name();
            $joinId = "_{$joinTable}_id";
            $currentId = "_{$currentTable}_id";
            // 1x1
            if (is_array($this->info($joinId))) {
                $select->join($joinTable, "{$this->_quote($currentTable)}.{$this->_quote($joinId)}={$this->_quote($joinTable)}.{$this->_quote($joinId)}", array());
            }
            // 1xN
            elseif (is_array($this->info($currentId, $joinTable))) {
                $select->join($joinTable, "{$this->_quote($currentTable)}.{$this->_quote($currentId)}={$this->_quote($joinTable)}.{$this->_quote($currentId)}", array());
            }
            // MxN
            else {
                // table name (or equivalent table view)
                $centerTable = "_{$joinTable}-{$currentTable}";
                $select->join($centerTable, "{$this->_quote($currentTable)}.{$this->_quote($currentId)}={$this->_quote($centerTable)}.{$this->_quote($currentId)}", array());
                $select->join($joinTable, "{$this->_quote($centerTable)}.{$this->_quote($joinId)}={$this->_quote($joinTable)}.{$this->_quote($joinId)}", array());
            }
        }
        // set limit
        if (isset($cond['count']) AND is_numeric($cond['count']) AND $cond['count']>0)
            $select->limitPage($cond['page'], $cond['count']);
        // set where conditions
        if (isset($cond['where'])) {
            if (! is_array($cond['where']))
                $cond['where'] = array($cond['where']);
            foreach ($cond['where'] as $name=>$value) {
                // set condition with inserted value
                if (is_numeric($name)) {
                    $select->where($value);
                }
                // insert value into condition string
                else {
                    // replace magic column names
                    preg_match('`([a-z0-9_.]+) *(<|>|<=|>=|<>|!=|=|IN|NOT IN)?`i', $name, $mathes);
                    // real column name (from magic column name)
                    $column = $this->column($mathes[1]);
                    $sign = (isset($mathes[2]) ? strtoupper($mathes[2]) : '=');
                    // many values in one position
                    if (is_array($value) AND count($value)>1 AND 'NOT IN'!=$sign)
                        $sign = 'IN';
                    $question = (('IN'==$sign OR 'NOT IN'==$sign) ? '(?)' : '?');
                    $name = "{$column} {$sign} {$question}";
                    $select->where($name, $value);
                }
            }
        }
        // set group by
        if (isset($cond['group']))
            $select->group($cond['group']);
        // set sorting order
        if (isset($cond['order']))
            $select->order($cond['order']);
        // profile SQL query
        Days_Log::profile((string)$select, 'Db_Table', Days_Log::PROFILE);
        // fetch result
        $rowset = new Days_Db_Rowset($this);
        switch ($type) {
            case 'all':
                $results = $select->query();
                while ($row = $results->fetch(Zend_Db::FETCH_ASSOC)) {
                    if (is_array($row))
                        $rowset[] = new Days_Db_Row($row, $this, $rowset);
                }
                break;
            case 'last':
                $results = $select->order("{$this->_order} DESC")->query();
                while ($row = $results->fetch(Zend_Db::FETCH_ASSOC)) {
                    if (is_array($row))
                        $rowset[] = new Days_Db_Row($row, $this, $rowset);
                }
                break;
            case 'first':
                $results = $select->order("{$this->_order} ASC")->query();
                while ($row = $results->fetch(Zend_Db::FETCH_ASSOC)) {
                    if (is_array($row))
                        $rowset[] = new Days_Db_Row($row, $this, $rowset);
                }
                break;
            case 'one':
                $row = $select->limit(1)->query()->fetch(Zend_Db::FETCH_ASSOC);
                $rowset = (is_array($row) ? new Days_Db_Row($row, $this, $rowset) : null);
                break;
            case 'count':
                $rowset = $select->reset(Zend_Db_Select::FROM)
                    ->reset(Zend_Db_Select::COLUMNS)
                    ->from($this->_name, array('sum'=>'COUNT(*)'))
                    ->query()->fetch(Zend_Db::FETCH_COLUMN);
                break;
            default:
                throw new Days_Exception("Passed incorrect result type '{$type}' in find() method");
        }
        // reset table object for new query
        $select->reset();
        $this->_join = array();
        // return result rowset
        return $rowset;
    }

    /**
     * Join specified table.
     *
     * @param string $table Table name
     * @return Days_Db_Table
     */
    public function join($table) {
        $this->_join[] = $table;
        return $this;
    }

    /**
     * Return table name.
     *
     * @param string $subtable Add this suffix after table name
     * @return string Table name
     */
    public function name($postfix=null) {
        return $this->_name . (is_null($postfix) ? '' : "_{$postfix}");
    }

    /**
     * Get table info.
     *
     * @param string $column Return only this column info (or all columns, if not specified)
     * @param string $table Table name (or current table, if not specified)
     * @return array
     */
    public function info($column=null, $table=null) {
        // set table name
        $table = (is_null($table) ? $this->_name : $table);
        // return info for all columns
        if (is_null($column)) {
            return self::$_structure[$table]['columns'];
        }
        // convert magic column name
        $column = $this->column($column);
        // check column in table
        if (! isset(self::$_structure[$table]['columns'][$column]))
            return null;
        // return info about one column
        return self::$_structure[$table]['columns'][$column];
    }

    /**
     * Convert magic column name to physical.
     *
     * @param string $name Column name
     * @return Physical column name
     */
    public function column($name) {
        // replace column name
        if ('id'==$name OR 'pid'==$name)
            $name = "_{$this->_name}_{$name}";
        return $name;
    }

    /**
     * Create empty rowset.
     *
     * @return Days_Db_Rowset
     */
    public function create() {
        $rowset = new Days_Db_Rowset($this);
        return $rowset;
    }

    public function save(Days_Db_Row $row) {
        if (! isset($row->id))
            $this->_insert($row);
        else
            $this->_update($row);
    }

    /**
     * Delete row.
     *
     * @return bool Row deleted successfull.
     */
    public function delete(Days_Db_Row $row) {
        if (! isset($row->id)) {
            throw new Days_Exception('Not specified `id` for row to delete');
        }
        $where = $this->_db->quoteInto("_{$this->_name}_id=?", $row->id);
        return ($this->_db->delete($this->_name, $where) > 0);
    }

    /**
     * Callback function on create new row.
     */
    protected function _insert(Days_Db_Row $row) {
        $data = $row->toArray();
        $this->_db->insert($this->_name, $data);
        $id = $this->_db->lastInsertId();
        $row->id = $id;
        return $id;
    }

    /**
     * Callback function on update row.
     */
    protected function _update(Days_Db_Row $row) {
        $data = $row->toArray();
        $where = $this->_db->quoteInto("_{$this->_name}_id=?", $row->id);
        return $this->_db->update($this->_name, $data, $where);
    }
}