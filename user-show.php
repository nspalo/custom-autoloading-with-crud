<?php
/**
 * Sample User Info
 */ 
include_once __DIR__ . "/system/includes.php";


$database = new Database();
$user = new User($database);

/**
 * Sample User Data
 */
$UserData = [
  "username" => "Admin",
  "password" => "1234",
];

if($user->alreadyExist($UserData["username"], $UserData["password"]) === false)
{
  echo 'User not found!';
}
else
{
  echo 'User found!';

  $userData = $user->findUser($UserData["username"], $UserData["password"]);
  display($userData);
}

echo '<hr/>All Users';
$users = $user->getAllUser();
display($users);