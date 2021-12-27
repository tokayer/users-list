<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (! isset($_POST['email'], $_POST['name'])) {
        throw new HttpInvalidParamException("Missing parameters", 400);
    }

    $user = new User();
    if (! $user->find($_POST['email'])) {
        $user = $user->create(['email' => $_POST['email'], 'name' => $_POST['name']]);
    } else {
        $user = $user->update([
            'is_online'     => 'true',
            'last_entrance' => getCurrentDate(),
            'visit_count'   => $user->visit_count += 1
        ]);
    }
}

require(PRIVATE_PATH . '/views/mainPage.php');

