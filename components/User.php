<?php

/**
 * User Class
 * Should hold all user related functions
 */
class User
{ 
  use HashGeneratorFunctions;
  
  private $database;
  
  public function __construct(databaseInterface $database)
  {
    $this->database = $database;    
  }
  
  public function __destruct()
  {
    unset($this->database);
  }
  
  public function alreadyExist(string $username, string $password) : bool
  {
    return (0 == count($this->findUser($username, $password))) ? false : true;
  }
  
  public function findUser(string $username, string $password) : array
  {
    $user     = array();
    $password = $this->generatePassword($password);
    $sql      = "SELECT `username`, `password`, `name`, `email` FROM `users` WHERE `username`='{$username}' AND `password`='{$password}';";   
    
    $this->database->query($sql);
    
    if(1 == $this->database->getAffectedRows())
    {
      $user = $this->database->getRowNext();
    }
    
    return $user;
  }
  
  public function getAllUser() : array
  {
    $users = array();
    $sql   = "Select `username`, `password`, `name`, `email` from users;";

    $this->database->query($sql);
    
    if(0 != $this->database->getAffectedRows())
    {
      $users = $this->database->getRows();
    }
    
    return $users;
  }
  
  public function createUser(string $username, string $password, string $name, string $email) : bool
  {
    $password = $this->generatePassword($password);
    
    $SQL = "/* Add User */
    INSERT INTO `users`( `username`, `password`, `name`, `email` )
    VALUES('{$username}', '{$password}', '{$name}', '{$email}')
    ;";
    
    $this->database->query( $SQL );    
    return (0 != $this->database->getAffectedRows()) ? true : false;
  }
  
  public function deleteUser(string $username, string $password)// : bool
  {
    $password = $this->generatePassword($password);
    
    $SQL = "/* Delete User */
    DELETE FROM `users` WHERE `username`='{$username}' AND `password`='{$password}'
    ;";
    
    $this->database->query( $SQL );
    return (0 != $this->database->getAffectedRows()) ? true : false;    
  }
  
}