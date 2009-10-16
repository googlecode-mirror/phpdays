<?php
/**
 * Templum - php template engine.
 *
 * Parameters:
 *  - cond: condition
 *
 * @version 1.0
 * @link http://templum.googlecode.com
 * @license Apache License 2.0 http://www.apache.org/licenses/LICENSE-2.0
 * @author Anton Danilchenko <anton.danilchenko@gmail.com>
 */
class Templum_Component_Block_If extends Templum_Component_Block_Abstract {
    protected $_required = array('cond');

    protected function _handle(array $params=array(), $content) {
        // delete quotes
        $params['cond'] = trim($params['cond'], '\'"');
        // return code
        return "<?php if({$params['cond']}) { ?>{$content}<?php } ?>";
    }
}