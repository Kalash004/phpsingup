<?php
session_start();
$request = $_SERVER['REQUEST_URI'];

switch ($request) {
    case '':
    case '/':
        $redirect = '/views/main.php';
        break;
    case '/login':
        $redirect = '/views/login.html';
        break;
    case '/login.php': 
        $redirect = '/core/login.php';
        break;
	case '/singup':
		$redirect = '/views/singup.html';
		break;
    case '/singup.php': 
        $redirect = '/core/singup.php';
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