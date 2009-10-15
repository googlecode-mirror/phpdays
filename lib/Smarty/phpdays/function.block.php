<?php
/**
 * Include block by name.
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
 *  - name: name of block (placed in `View/block` directory)
 *  - to: name of variable to assign result
 */
function smarty_function_block($params, Smarty &$smarty) {
    // check required parameters
    if (! isset ($params['name']))
        throw new Days_Exception('Not passed `name` parameter in smarty plugin `block`');
    // set correct name
    $path = "block/{$params['name']}.html";
    // check file
    if (! $smarty->template_exists($path))
        throw new Days_Exception("Not found file `{$path}`");
    // get content
    $content = $smarty->fetch($path);
    // set to variable
    if (isset ($params['to']))
        $smarty->assign($params['to'], $content);
    else
        return $content;
}