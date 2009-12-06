<?php
/**
 * User
 *
 * @author Anton Danilchenko
 */
class Days_Model_User extends Days_Model {
    protected $_email     = 'type: Email, max: 150';
    protected $_password  = 'type: Password, min: 2, max: 20, required';
    protected $_nic       = 'type: String, min: 2, max: 30';
}