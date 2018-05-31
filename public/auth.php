<?php
/*function require_auth() {
	$AUTH_USER = 'admin';
	$AUTH_PASS = 'admin';
	header('Cache-Control: no-cache, must-revalidate, max-age=0');
	$has_supplied_credentials = !(empty($_SERVER['PHP_AUTH_USER']) && empty($_SERVER['PHP_AUTH_PW']));
	$is_not_authenticated = (
		!$has_supplied_credentials ||
		$_SERVER['PHP_AUTH_USER'] != $AUTH_USER ||
		$_SERVER['PHP_AUTH_PW']   != $AUTH_PASS
	);
	if ($is_not_authenticated) {
		header('HTTP/1.1 401 Authorization Required');
		header('WWW-Authenticate: Basic realm="Access denied"');
		//exit;
		$errmsg = array("status"=>"Authentication Failed.", "msg"=>"Please enter correct login details.");
		echo json_encode($errmsg);
	}
}

require_auth();*/
header('Content-type: application/json');

if (isset($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'])
    && $_SERVER['PHP_AUTH_USER'] === 'admin'
    && $_SERVER['PHP_AUTH_PW'] === 'admin') {

    // User is properly authenticated...

} else {
    header('WWW-Authenticate: Basic realm="Secure Site"');
    header('HTTP/1.0 401 Unauthorized');
    $errmsg = array("status"=>"Authentication Failed.", "msg"=>"Please enter correct login details.");
    echo json_encode($errmsg);
	 exit();
}
