<?php
/**
 * Blog
 *
 * @author Anton Danilchenko
 */
class Model_BlogPost extends Days_Model {
    protected $_name     = 'type: String, min: 2, max: 100, required';
    protected $_url      = 'type: String, min: 2, max: 100, required, unique';
    protected $_title    = 'type: String, max: 255, required';
    protected $_content  = 'type: Text, min: 100, required';
    protected $_blog     = 'type: Blog, required';
    protected $_category = 'type: BlogCategory';
    protected $_tags     = 'type: +BlogTag';
    protected $_author   = 'type: User, required';
    protected $_created  = 'type: DateTime, now: create, required';
    protected $_media    = 'type: +String';
}