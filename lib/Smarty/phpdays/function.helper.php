<?php
/**
 * Call method in class Days_Model_Helper_[Name].
 *
 * Part of "php:Days - php5 framework" project (http://phpdays.sf.net).
 *
 * @copyright	Copyright (c) 2009 phpDays foundation (http://phpdays.org)
 * @license	http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link	http://phpdays.sf.net/
 * @package	phpDays
 * @subpackage	phpDays Smarty library
 * @author	Anton Danilchenko <happy@phpdays.org>
 * @param       Parameters
 *  - name: part of Days_Model_Helper_[Name]
 *  - action: name of method in specified class
 *  - to: name of variable to assign result
 */
function smarty_function_helper($params, &$smarty) {
    // check required parameters
    if (! isset ($params['name']))
        throw new Days_Exception('Not passed `name` parameter in smarty plugin `helper`');
    if (! isset ($params['to']))
        throw new Days_Exception('Not passed `to` parameter in smarty plugin `helper`');
    // create model
    $model = Days_Model::factory("helper_{$params['name']}");
    // check method
    if (! isset ($params['action']))
        throw new Days_Exception('Not passed `action` parameter in smarty plugin `helper`');
    if (! method_exists($model, $params['action'])) {
        $class = get_class($model);
        throw new Days_Exception("Not defined method `{$params['action']}` in class `{$class}`");
    }
    // return result
    $content = call_user_func(array($model, $params['action']));
    $smarty->assign($params['to'], $content);
}