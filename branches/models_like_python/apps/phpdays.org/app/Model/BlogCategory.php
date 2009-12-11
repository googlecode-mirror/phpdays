<?php
/**
 * BlogCategory
 *
 * @author Anton Danilchenko
 */
class Model_BlogCategory extends Days_Model {
    protected $_name     = 'type: String, min: 2, max: 50, required';
    protected $_url      = 'type: String, min: 2, max: 50, required';
}