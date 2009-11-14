<?php
/**
 * Show array variable in loop.
 *
 * Parameters:
 *  - var: name of variable
 *  - value: name of loop variable
 *  - key: name of loop key variable (optional)
 *
 * @version 1.0
 * @link http://templum.googlecode.com
 * @license Apache License 2.0 http://www.apache.org/licenses/LICENSE-2.0
 * @author Anton Danilchenko <anton.danilchenko@gmail.com>
 */
class Templum_Component_Block_Loop extends Templum_Component_Block_Abstract {
    protected $_required = array('var', 'value');

    protected function _handle(array $params=array(), $content) {
        // set '$key=>$value'
        $cond = "{$params['value']}";
        if (isset($params['key']))
            $cond = "{$params['key']}=>{$cond}";
        return "<?php if (isset({$params['var']}) AND ! empty({$params['var']})) foreach ({$params['var']} as {$cond}) {?> {$content} <?php } ?>";
    }
}