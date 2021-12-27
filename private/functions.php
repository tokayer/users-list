<?php

function getCurrentDate(): string
{
    $dateFormat = 'Y-m-d H:i:s';
    return date($dateFormat, time());
}
