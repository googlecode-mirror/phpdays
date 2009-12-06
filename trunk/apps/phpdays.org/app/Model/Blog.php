<?php
/**
 * Blog
 *
 * @author Anton Danilchenko
 */
class Model_Blog extends Days_Model {
    protected $_name    = 'type: String, min: 2, max: 100, required';
    protected $_url     = 'type: String, min: 2, max: 100, required';
    protected $_owner   = 'type: User, required';
    protected $_created = 'type: DateTime, now: create, required';
    protected $_changed = 'type: DateTime, now: always, required';
}