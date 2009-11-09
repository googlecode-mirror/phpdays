<?php
/** Disable access to script */
if ($_SERVER['REQUEST_URI'] == $_SERVER["SCRIPT_NAME"]) {
    Header('HTTP/1.0 404 Not Found');
    exit();
}
// set error level
require_once '../../phpdays/lib/Days/Engine.php';
Days_Engine::run('../app/', 'development');