<?php
// disable access to script
if ($_SERVER['REQUEST_URI'] == $_SERVER["SCRIPT_NAME"]) {
    Header('HTTP/1.0 404 Not Found');
    exit();
}
// set error level
require_once '../../lib/Days/Engine.php';
// set path to application dir AND stage in "development" status
Days_Engine::run('../app/', 'development');