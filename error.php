<?php

require_once("classes/App.php");
$core = new Core();

/**
 * @author Chris Coyier
 * @source https://css-tricks.com/snippets/php/error-page-to-handle-all-errors/
 */
$status = $_SERVER['REDIRECT_STATUS'];
$codes = array(
    403 => array('403 Forbidden', 'The server has refused to fulfill your request.'),
    404 => array('404 Not Found', 'The document/file requested was not found on this server.'),
    405 => array('405 Method Not Allowed', 'The method specified in the Request-Line is not allowed for the specified resource.'),
    408 => array('408 Request Timeout', 'Your browser failed to send a request in the time allowed by the server.'),
    500 => array('500 Internal Server Error', 'The request was unsuccessful due to an unexpected condition encountered by the server.'),
    502 => array('502 Bad Gateway', 'The server received an invalid response from the upstream server while trying to fulfill the request.'),
    504 => array('504 Gateway Timeout', 'The upstream server failed to send a request in the time allowed by the server.'),
);
$data['title'] = $codes[$status][0];
$data['message'] = $codes[$status][1];
//if ($data['title'] == false || strlen($status) != 3) {
//    $data['message'] = 'Please supply a valid status code.';
//}

$core->render("error.php", NULL, $data); // unified error page
