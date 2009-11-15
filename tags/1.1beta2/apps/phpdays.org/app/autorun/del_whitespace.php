<?php
Days_Event::add('system.send_content','del_whitespace');

function del_whitespace() {
    Days_Response::setContent(preg_replace('#\s{2,}#','',Days_Response::getContent()));
}