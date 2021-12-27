<?php

use http\Exception\BadUrlException;

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
        // throw new BadUrlException('Page Not Found', 404);
        echo "Page Not Found";
        break;
}

