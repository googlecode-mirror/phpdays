<?php
/**
 * BlogComment
 *
 * @author Anton Danilchenko
 */
class Model_BlogComment extends Days_Model_Comment {
    protected $_title   = 'type: String, required';
    protected $_author  = 'type: User, required';
    protected $_post    = 'type: BlogPost, required';
    protected $_created = 'type: DateTime, now: create';
}