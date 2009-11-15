<?php
/**
 * Return specified value if string is empty.
 *
 * Parameters:
 *  - value: default value
 *
 * @version 1.0
 * @link http://templum.googlecode.com
 * @license Apache License 2.0 http://www.apache.org/licenses/LICENSE-2.0
 * @author Anton Danilchenko <anton.danilchenko@gmail.com>
 */
class Templum_Component_Filter_Default extends Templum_Component_Filter_Abstract {
    protected $_required = array('value');

    public function handle(array $params=array(), $content) {
        // check variables
        $this->_check($params);
        // set default value if data empty
        if (empty($content))
            $content = $params['value'];
        // schow result
        return "<?php echo '{$content}'; ?>";
    }
}