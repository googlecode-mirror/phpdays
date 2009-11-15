<?php
/** Classes used as a simple ActiveRecord emulation */
class User {
    public function find() { }
}
class User_Phone {
    public function find() { }
}

/** Application class (for tests) */
class Myapp {
    /** @var Templum */
    private $_engine = null;

    /** Make new instance of template engine. */
    public function __construct() {
        // set configuration
        Templum::setTemplateDir(realpath(dirname(__FILE__) . '/template'));
        Templum::setCompileDir(realpath(dirname(__FILE__) . '/compile'));
        // create template engine instance
        $this->_engine = Templum::singleton();
        // clear all stored compiled templates (only for tests)
        $this->_engine->clearCompiled();
    }

    /** Return result page content. */
    public function getContent() {
        // assign variables to template
//        $this->_oTemplate->test = array (1,2,3,4,5);
//        $this->_oTemplate->users['Nico'] = 'Nikolay Hack';
//        $this->_oTemplate->users['Tigg'] = 'Bobby Dic';
        // set variables (case sensitive)
        $data = new stdClass();
        $data->project_name = 'Templum 1.0';
        $data->PROJECT_NAME = 'Template engine on php5';
        // set object as variable
        $oUser = new User();
        $oUser->name = 'Mike Dotten';
        $oUserPhones = new User_Phone();
        $oUserPhones->mobile1 = '+0175723457';
        $oUserPhones->mobile2 = '+0111234567';
        $oUser->phone = $oUserPhones;
        $data->user = $oUser;
        // set array
        $data->records['Red'] = 'Green';
        $data->records['Black'] = 'White';
        $data->records['Blue'] = 'Pink';
        $data->records[] = 'Gray';
        $data->records[] = 'Brown';
        // compile template and return result
        return $this->_engine->get('test.html', (array)$data);
    }
}

// show template
include (dirname(__FILE__) . '/../Templum.php');
// create application
$oApp = new Myapp();
// print page
echo $oApp->getContent();