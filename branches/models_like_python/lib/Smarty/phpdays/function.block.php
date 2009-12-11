<?php
/**
 * Include block by name.
 *
 * Part of "php:Days - php5 framework" project (http://phpdays.googlecode.com).
 *
 * @copyright    Copyright (c) 2009 phpDays foundation (http://phpdays.org)
 * @license    http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link    http://phpdays.googlecode.com/
 * @package    phpDays
 * @subpackage    phpDays Smarty library
 * @author    Anton Danilchenko <happy@phpdays.org>
 * @param       Parameters
 *  - name: name of block (placed in `View/block` directory)
 *  - to: name of variable to assign result
 */
function smarty_function_block($params, Smarty &$smarty) {
    // check required parameters
    if (! isset ($params['name']))
        throw new Days_Exception('Not passed `name` parameter in smarty plugin `block`');
    // set template path
    $template = "block/{$params['name']}.html";
    // check file
    if (! $smarty->template_exists($template))
        throw new Days_Exception("Not found file `{$template}`");

    //specify the name of the controller
    $className = $params['name'];
    $classPathParts = explode('/', $className);
    for ($i=0; $i<count($classPathParts); $i++) {
        $classPathParts[$i] = ucfirst($classPathParts[$i]);
    }
    $controller = implode('_', $classPathParts);
    $controllerClass = 'Controller_Block_' . $controller;
    //execute of the controller, if it exists
    if(class_exists($controllerClass)) {
        // create controller
        $controllerObj = new $controllerClass($template);
        if (! $controllerObj instanceof Days_Controller)
            throw new Days_Exception("Controller '{$controllerClass}' should be extended from 'Days_Controller'");
        // call init() method for prepare object
        $controllerObj->init();
        $content = $controllerObj->getContent(false);
        unset($controllerObj);
    } else {
        $content = $smarty->fetch($template);
    }
    // set to variable
    if (isset ($params['to']))
        $smarty->assign($params['to'], $content);
    else
        return $content;
}