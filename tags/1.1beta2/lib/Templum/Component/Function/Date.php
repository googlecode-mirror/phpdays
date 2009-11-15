<?php
/**
 * Print current date or transform existing date.
 *
 * Parameters:
 *  - format: date format (optional)
 *  - date: date in any style (optional)
 *
 * @version 1.0
 * @link http://templum.googlecode.com
 * @license Apache License 2.0 http://www.apache.org/licenses/LICENSE-2.0
 * @author Anton Danilchenko <anton.danilchenko@gmail.com>
 */
class Templum_Component_Function_Date extends Templum_Component_Function_Abstract {
    protected $_required = array();
    private static $_dateTimeFormat = array(
        // DATE
        'YYYY'  => 'Y',     // 2009 (year)
        'YY'    => 'y',     // 09 (year)
        'MONTH' => 'F',     // February (month)
        'MON'   => 'M',     // Feb (month)
        'MM'    => 'm',     // 02 (month)
        'M'     => 'n',     // 2 (month)
        'DAY'   => 'l',     // Sunday (day)
        'DD'    => 'd',     // 05 (day)
        'D'     => 'j',     // 5 (day)
        // TIME
        'HH'    => 'H',     // 08 (hours)
        'H'     => 'G',     // 8 (hours)
        'II'    => 'i',     // 03 (minutes)
        'I'     => 'i',     // 03 (minutes)
        'SS'    => 's',     // 04 (seconds)
        'S'     => 's');    // 04 (seconds)

    protected function _handle(array $params=array()) {
        // get parameters
        $format = isset($params['format']) ? $params['format'] : 'YYYY-MM-DD HH:MM:SS';
        // date in timestamp format
        $timestamp = isset($params['date']) ? $params['date'] : time();
        // existing date
        if (! is_numeric($timestamp))
            $timestamp = self::_getDatetimeToTimestamp($timestamp);
        // translate format string
        $format = str_replace(array_keys(self::$_dateTimeFormat), array_values(self::$_dateTimeFormat), $format);
        // translate date and save result
        $content = date($format, $timestamp);
        $content = addslashes($content);
        // print date
        return "<?php echo '{$content}'; ?>";
    }

    /**
     * Transform mysql date or datetime to timestamp format.
     *
     * Handle date and datetime formats:
     *  - full form ("YYYY-MM-DD HH:MM:SS", "YYYY/MM/DD HH-MM-SS", "YYYY:MM:DD HH-MM-SS", ...)
     *  - short form ("YYYY-MM-DD", "YYYY/MM/DD", ...)
     *
     * @param string $datetime Date and time into string format
     * @return int Timestamp
     */
    private static function _getDatetimeToTimestamp($datetime) {
        // parse data string
        $aDatetimeInfo = split('[ ./:-]', $datetime);
        // set all not setted information
        for ($iNum=0; $iNum<=5; $iNum++)
            if (empty($aDatetimeInfo[$iNum]))
                $aDatetimeInfo[$iNum] = 0;
        // return timestamp
        return mktime($aDatetimeInfo[3], $aDatetimeInfo[4], $aDatetimeInfo[5], $aDatetimeInfo[1], $aDatetimeInfo[2], $aDatetimeInfo[0]);
    }
}