<?php
/**
 * Sample User Register
 */ 
include_once __DIR__ . "/system/includes.php";

$database = new Database();
$user = new User($database);

/**
 * Sample User Data
 */
$UserData = [
  "username" => "SampleUser2",
  "password" => "123ABC",
];

if($user->alreadyExist($UserData["username"], $UserData["password"]) === false)
{
  echo 'Unable to delete, user not found!';
}
else
{
  display($user->findUser($UserData["username"], $UserData["password"]));
  $user->deleteUser($UserData["username"], $UserData["password"]);
  echo 'User already deleted!';
}

$users = $user->getAllUser();
display($users);