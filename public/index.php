<?php
// TODO: turn off errors
ini_set('display_errors', 1);
error_reporting(E_ALL);

// TODO: we don't need the file
require('../private/initialize.php');

switch ($_SERVER['REQUEST_URI']) {
    case '/':
        require(PRIVATE_PATH . '/views/entrancePage.html');
        break;
    case '/main-page':
        require(PRIVATE_PATH . '/Controllers/mainPage.php');
        break;
    case '/online-user-list':
        require(PRIVATE_PATH . '/Controllers/onlineUserList.php');
        break;
    case '/user-offline':
        require(PRIVATE_PATH . '/Controllers/userOffline.php');
        break;
    default:
        echo "404";
        // throw 404 using header
        break;
}

