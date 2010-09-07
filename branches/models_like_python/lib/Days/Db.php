<?php
/**
 * Db (database) - used for work with different database engines.
 *
 * Part of "php:Days - php5 framework" project (http://phpdays.googlecode.com).
 *
 * @copyright    Copyright (c) 2009 phpDays foundation (http://phpdays.org)
 * @license      http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link         http://code.google.com/p/phpdays/wiki/EnLibDaysDb
 * @package      Days
 * @subpackage   Days
 * @author       Anton Danilchenko <happy@phpdays.org>
 */
class Days_Db {
    /**
     * Return new database object.
     *
     * @param $schema string: Name of database schema in config
     * @return Days_Db
     */
    private static $_instance;
    private static $db_data;
    public static function factory($schema='default', $dbtype='Zend') {
        // receive database configuration
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

    /**
     * Update DB to reflect Models Definition in models.yaml
     * @return
     */
    public static function dbUpdate($_appPath){
        $DB_updater = $_appPath.'system/cache/db_update';
        $model_file = $_appPath.'config/models.yaml';
        $model_mtime = filemtime($model_file);
        if(!file_exists($DB_updater)){
            $db_mtime = $model_mtime-10;
        }else{
            $db_mtime = filemtime($DB_updater);
        }
        if($model_mtime > $db_mtime){
            //$input_array = Days_Config_Yaml::load($model_file);
            $input_array = Days_Db::load($model_file)->get();
            $input_array = array_slice($input_array,17);
            array_shift($input_array);
            $DB_array = array();
            foreach($input_array as $db_table=>$db_column){
                $DB_Col = array();
                foreach($db_column as $field=>$properties){
                    $restr_properties = array();
                    $mod_properties = array();
                    $length = 0;
                    foreach($properties as $condition => $value){
                        if(is_int($condition)){
                            $condition = $value;
                        }
                        $value = str_replace('+','',$value);
                        switch($condition){
                            case 'type':
                                $metadata = 'Days_Model_'.ucfirst($value);
                                $data_type = $metadata::$type;
                                if($value=='text')
                                $text_flag = 1;
                                break;
                            case 'max':
                                if($data_type == 'varchar'){
                                $length = $value;
                                }
                                break;
                            case 'min':
                                break;
                            case 'required':
                                $mod_properties[] = 'NOT NULL';
                                break;
                            case 'key':
                                $mod_properties[] = 'PRIMARY KEY';
                                break;
                            case 'index':
                                $mod_properties[] = 'INDEX'.'('.$value.')';
                                break;
                            case 'unique':
                                $mod_properties[] = 'UNIQUE';
                                break;
                            case 'break':
                                break;
                            case 'http':
                                break;
                            case 'positive':
                                break;
                            default:
                                throw new Days_Exception("Undefined Field type in Models Definition.");
                        }
                    }
                if(($data_type=='varchar')&&(!$length)){
                    $length = 25;
                    if($text_flag){
                        $length = 100;
                    }
                }
                if($length){
                    $data_type = $data_type.'('.$length.')';
                }
                $restr_properties[] = $data_type;
                foreach($mod_properties as $property){
                    $restr_properties[] = $property;
                }
                $DB_Col[$field] = $restr_properties;
                }
            $DB_array[strtolower($db_table)] = $DB_Col;
            }
            $db_info = Days_Config::load()->get('db/default');
            $db_info['adapter'] = ucfirst($db_info['adapter']);
            $db_conn = Zend_Db::factory('Pdo_'.$db_info['adapter'], array(
                'host'     => $db_info['host'],
                'username' => $db_info['username'],
                'password' => $db_info['password'],
                'dbname'   => $db_info['dbname']
            ));
            $db_tables = $db_conn->listTables();
            $model_tables = array_keys($DB_array);
            /*foreach($model_tables as $model){
                $models[] = strtolower($model);
            }*/
            $create_tables = array_diff($model_tables,$db_tables);
            //Tables to be updated
            $update_tables = array_diff($model_tables,$create_tables);
            foreach($DB_array as $table_name=>$field){
                $query = "CREATE TABLE IF NOT EXISTS $table_name(";
                $data = null;
                foreach ($field as $col_name=>$property){
                    if(is_null($data)){
                    $data = $col_name.' ';
                    }else{
                    $data = $data.','.$col_name.' ';
                    }
                    foreach ($property as $charac){
                        $data = $data.$charac.' ';
                    }
                }
                $data = rtrim($data);
                $query = $query.$data.')';
               $db_conn->query($query);
            }
            //Tables to be deleted
            $del_tables = array_diff($db_tables,$model_tables);
            //Deletion of table after backup
            foreach($del_tables as $table_name){
                $back_up = str_replace('\\','\/',$_appPath)."system/backup/$table_name.sql";
                //To backup before delete
                $query = "SELECT * INTO OUTFILE '$back_up' FROM $table_name";
                $db_conn->query($query);
                //To delete the table
                $query = "DROP TABLE IF EXISTS $table_name";
                $db_conn->query($query);
            }
            //Updating existing tables
            foreach($update_tables as $table){
                $table_desc = $db_conn->describeTable($table);
                $col_names = array_keys($table_desc);
                $model_table_desc = $DB_array[$table];
                $model_col_names = array_keys($model_table_desc);
                $update_col = array_diff($model_col_names,$col_names);
                foreach($update_col as $col_name){
                    $query = 'ALTER TABLE '.$table.' ADD COLUMN('.$col_name.' ';
                    $data = null;
                    foreach ($model_table_desc[$col_name] as $charac){
                            $data = $data.$charac.' ';
                        }
                    $data = rtrim($data);
                    $query = $query.$data.')';
                    $db_conn->query($query);
                }
                $del_col = array_diff($col_names,$model_col_names);
                foreach($del_col as $col_name){
                    $query = 'ALTER TABLE '.$table.' DROP COLUMN '.$col_name;
                    $db_conn->query($query);
                }
            }
            $f_handle = fopen($DB_updater,'w');
            fclose($f_handle);
        }
    }
    /**
     * Loads Model file into the static variable $db_data
     * @param $model: pathname of models yaml file
     * @return Days_Db Singleton object
     */
    public static function load($model){
        if (! file_exists($model))
                throw new Days_Exception("Model Definition file '{$filename}' not found");
        // use fast Yaml module for php (if exists)
        if (function_exists('syck_load'))
            self::$db_data = syck_load(file_get_contents($model));
        else
            self::$db_data = Spyc::YAMLLoad($model);
        //creating an instance of Days_Db and returning the same
        self::$_instance = new self();
        return (self::$_instance);
    }
    /**
     * Returns DB info array
     * @return array
     */
    public function get(){
        // return DB info array
        return self::$db_data;
    }
}