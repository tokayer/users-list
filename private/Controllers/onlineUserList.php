<?php

$onlineUsers = (new User())->where('is_online', 'true');

header('Content-Type: application/json;');
echo json_encode(array_values($onlineUsers));