<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    return;
}

$post_body_raw = file_get_contents('php://input');
$post_params = json_decode($post_body_raw, true);
$userEmail = $post_params['email'] ?? null;

if ($userEmail === null) {
    return;
}

$user = new User();

$user = $user->find($userEmail);

$user->update(['is_online' => 'false']);