<?php
include_once __DIR__ . "/system/includes.php";

$db = new Database();

$user = new User($db);

dump($user);
display($db->getConnection());


dump($user->getAllUser());
dump($user->generateGUID());
dump($user->generatePassword('1234'));
dump($user->hashGenerator('1234'));