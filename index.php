<?php
session_start();
$request = $_SERVER['REQUEST_URI'];

switch ($request) {
    case '':
    case '/':
        $redirect = '/views/main.php';
        break;
    case '/login':
        $redirect = '/views/login.php';
        break;
	case '/singup':
		$redirect = '/views/singup.html';
		break;
    default:
        http_response_code(404);
        $redirect = '/views/404.php';
        exit();
}

$_SESSION['site'] = $redirect;
//require_once __DIR__ . '/views/core/header.php';
require_once __DIR__ . $redirect ?? __DIR__ . '/index.php';
// require_once __DIR__ . '/views/core/footer.php';
?>