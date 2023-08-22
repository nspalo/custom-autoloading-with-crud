<?php
/**
 * Custom Autoloader Class for Autoloading required classes
 * author: Noel Palo
 * gitrepo: <ToDo:upload-in-public>
 */
class nspaloClassAutoloader
{
	private const configPath = __DIR__ . "/../config/autoload.json";
  
	private static function components($className): void
	{
		$paths = json_decode(
		  file_get_contents(self::configPath),
		  true
		);
		
		foreach( $paths as $path )
		{
		  $includePath = __DIR__ . $path;
		  $includePath = str_replace(array("\\", "/"), DIRECTORY_SEPARATOR, $includePath);
		
		  set_include_path($includePath);
		  spl_autoload($className); // this replaces [ include|require - *_once ]
		}		
	}
  
	public static function load(): void
	{
		spl_autoload_extensions( ".php" );
		spl_autoload_register( array( static::class, 'components' ) );
	}
}
