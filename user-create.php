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
  "name" => "Sample User 2",
  "email" => "su2@test.com",
];

if($user->alreadyExist($UserData["username"], $UserData["password"]) === false)
{
  echo 'User not found!';
  
  $user->createUser($UserData["username"], $UserData["password"], $UserData["name"], $UserData["email"]);
  $users = $user->getAllUser();
  
  display($users);
  echo '<br>User was created!';
}
else
{
  echo 'User already exists!';
  display($user->findUser($UserData["username"], $UserData["password"]));
}

