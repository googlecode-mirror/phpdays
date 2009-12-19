<?php
/**
 * Response  contain data for send to user after application spot execution.
 *
 * Part of "php:Days - php5 framework" project (http://phpdays.googlecode.com).
 *
 * @copyright    Copyright (c) 2009 phpDays foundation (http://phpdays.org)
 * @license      http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link         http://code.google.com/p/phpdays/wiki/EnLibDaysResponse
 * @package      Days
 * @subpackage   Days
 * @author       Anton Danilchenko <happy@phpdays.org>
 */
class Days_Response {
    /** Redirect to specified page */
    const REDIRECT    = '400';
    /** Redirect to previous page */
    const PREV_PAGE   = '401';
    /** Redirect to current page */
    const RELOAD      = '402';
    /** Forbidden */
    const FORBIDDEN   = '403';
    /** Show 404 error page */
    const NOT_FOUND   = '404';
    /** Header list */
    private static $_headers = array();
    /** Page content */
    private static $_content = '';


    /**
     * Get content.
     *
     * @return string
     */
    public static function getContent() {
        return self::$_content;
    }

    /**
     * Set content.
     *
     * @param string $content
     * @return string
     */
    public static function setContent($content) {
        self::$_content = $content;
    }

    /**
     * Set content to send.
     *
     * @param string $content
     * @return void
     */
    public static function addContent($content) {
        self::$_content .= $content;
    }

    /**
     * Add header to list.
     *
     * @param string $type Type of header
     * @param string $value Destination path (only for 'redirect' and 'reload' types)
     * @return void
     */
    public static function addHeader($type, $value='') {
        // add only unique headers
        self::$_headers[$type] = $value;
    }

    /**
     * Send one header.
     *
     * @return bool Headers sent
     */
    public static function sendHeaders() {
        // headers already sent
        if (headers_sent($fileName, $line)) {
            Days_Log::add("Headers not sent such as sended in file '{$fileName}' on line {$line}");
            return false;
        }
        // on Ajax query
        if (Days_Request::isAjax()) {
            // JSON encoded data
            Header('Content-Type: text/javascript; charset=UTF-8');
            Header('Content-type: application/json; charset=UTF-8');
            self::_sendHeadersNocache();
            return true;
        }
        // send special headers only
        foreach (self::$_headers as $type=>$value)
            switch((string)$type) {
                case self::NOT_FOUND:
                    Header('HTTP/1.0 404 Not Found');
                    return true;
                    break;
                case self::FORBIDDEN:
                    Header('HTTP/1.1 403 Forbidden');
                    return true;
                    break;
                case self::PREV_PAGE:
                    // redirect on previous page
                    self::_sendHeadersRedirect(Days_Url::prev());
                    return true;
                    break;
                case self::REDIRECT:
                case self::RELOAD:
                    self::_sendHeadersRedirect($value);
                    return true;
                    break;
            }
        // send all additional headers
        foreach (self::$_headers as $type=>$value) {
            // send header info
            switch ((string)$type) {
                case 'htm':
                case 'html':
                case 'xhtml':
                    Header('Content-Type: text/html; charset=UTF-8');
                    self::_sendHeadersNocache();
                    break;
                case 'xml':
                    Header("Content-Type: text/xml; charset=UTF-8");
                    self::_sendHeadersNocache();
                    break;
                case 'wml':
                    Header('Content-Type: text/vnd.wap.wml; charset=UTF-8');
                    self::_sendHeadersNocache();
                    break;
                case 'json':
                    Header('Content-Type: text/javascript; charset=UTF-8');
                    self::_sendHeadersNocache();
                    break;
                case 'js':
                    Header('Content-type: application:x-javascript; charset=UTF-8');
                    self::_sendHeadersNocache();
                    break;
                case 'jpg':
                case 'jpeg':
                    Header("Content-Type: image/jpeg");
                    self::_sendHeadersNocache();
                    break;
                case 'gif':
                    Header("Content-Type: image/gif");
                    self::_sendHeadersNocache();
                    break;
                case 'png':
                    Header("Content-Type: image/png");
                    self::_sendHeadersNocache();
                    break;
            }
        }
        // all headers sent
        return true;
    }

    /**
     * Send headers and content to user browser.
     *
     * @return void
     */
    public static function sendContent() {
        // send cookie
        session_write_close();
        // send content
        echo self::$_content;
    }

    /**
     * Send headers "no cache data".
     *
     * @return void
     */
    private static function _sendHeadersNocache() {
        Header('Cache-Control: no-store, no-cache, must-revalidate');
        Header("Cache-Control: post-check=0, pre-check=0", false);
        Header('Pragma: no-cache');
        Header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
        Header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    }

    /**
     * Redirect browser to path:
     * - absolute (with http://host.com)
     * - relative (without http://host.com)
     * - reload current page (empty string)
     *
     * @param string $destination
     * @return void
     */
    private static function _sendHeadersRedirect($destination='') {
        global $_SERVER;
        // set full adress (with prefix http://)
        $redirectUrl = $destination;
        // set current protocol
        $protocol = (empty($_SERVER['HTTPS']) ? 'http://' : 'https://' );
        // reload current page
        if ('' == $destination) {
            $redirectUrl = $protocol . $_SERVER['HTTP_HOST'] . '/' . ltrim($_SERVER['REQUEST_URI'], '/');
        }
        // short adress (without prefix http://)
        elseif (! preg_match('`^https?://`', $destination)) {
            $redirectUrl = $protocol . $_SERVER['HTTP_HOST'] . '/' . ltrim($destination, '/');
        }
        // location to absolute url
        Header("Location: {$redirectUrl}");
    }
}