<?php

/**
 * Helper Functions
 */
trait HashGeneratorFunctions
{
  /**
   * Generic Hash Function
   */
  public function hashGenerator(string $textForEncryption) : string
  {
    return HASH( "sha256", $textForEncryption );
	}
  
  /**
   * Password Generator
   */
  public function generatePassword(string $password, string $salt = null) : string
  {
    $password = (is_null($salt)) ? $password : MD5($salt) . $password;
    return $this->hashGenerator($password);
  }
  
  /*
   * Globally Unique Identifier(GUID)
   * - is a 128-bit number used to identify information in computer systems
   */
  public function generateGUID()
  {
    $uniqid = uniqid(rand(), true);
    //$hash = md5($uniqid); // strtoupper(md5($uniqid));
    $hash = $this->hashGenerator($uniqid);
    $hexValues  = [
      substr($hash, 0, 8),
      substr($hash, 8, 4),
      substr($hash, 12,  4),
      substr($hash, 16,  4),
      substr($hash, 20, 12)
    ];
    
    // GUID format is XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX for readability    
    return implode("-", $hexValues);
  }
}