<?php

use Validation\Validator;

require __DIR__ . '/vendor/autoload.php';


$validator = Validator::make([
    'test' => 'required|string|length:3'
]);

$result = $validator->validate([
    'test' => 'four',
]);

echo $result->toJson();

