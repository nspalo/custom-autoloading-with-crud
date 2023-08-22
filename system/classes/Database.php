<?php
/*
 * Databasa Class
 */
class Database implements DatabaseInterface
{	
	private $connection;
	private $sqlResult;
	private $sqlLastInserted;
	private $sqlAffectedRows;
	private $sqlLogPath;
	private $configPath;
	private $config;

	private function getDatabaseConfig()
	{
		return json_decode(
			file_get_contents(__DIR__ . $this->configPath),
			true
		);
	}
  
	private function logDatabseErrors($query = null)
	{		
		$error_datetime = date("F j, Y g:i:s A O");
		$backtrace      = debug_backtrace();		
		$error          = $this->getError();
		
		// Log all database errors for debugging
		file_put_contents(
			dirname(__FILE__) . $this->sqlLogPath,
			"DATE AND TIME   : {$error_datetime}\n" .
			"QUERY STRING    : {$query}\n" .
			"SQL ERROR[{$error['error_no']}] : {$error['error_message']}\n" .
			"ERROR LOCATION  : {$backtrace[1]['function']} ({$backtrace[0]['file']}:{$backtrace[0]['line']})\n" .
			"--------------------------------------------------------------\n", 
			FILE_APPEND
		);
		
		return array( "DB_ERROR" => $error );
	}
  
  private function freeQueryResult()
  {
    if( $this->sqlResult )
    {
      $this->sql_free_result = mysqli_free_result($this->sqlResult);
    }
  }
  
	public function __construct()
	{
    $pathPrefix            = "./..";
		$this->connection      = null;
		$this->sqlResult       = null;
		$this->sqlLastInserted = null;
		$this->sqlAffectedRows = null;
		$this->sqlLogPath      = $pathPrefix . "/logs/database-errors.log";
		$this->configPath      = $pathPrefix . "/config/database.json";
		$this->config          = $this->getDatabaseConfig();
    
    /**
     * Connect to the database
     */
		$this->connect(
      $this->config["hostname"],
      $this->config["username"],
      $this->config["password"],
      $this->config["database"]
    );
	}
  
	public function __destruct()
	{
		$this->freeQueryResult();
		$this->close();
		unset( $this->config          );
		unset( $this->connection      );
		unset( $this->sqlResult       );
		unset( $this->sqlLastInserted );
		unset( $this->sqlAffectedRows );
		unset( $this->sql_log_enabled );
		unset( $this->timezone        );
	}
	
	public function connect( $hostname, $username, $password, $database )
	{
		if( is_null( $this->connection ) )
		{
			$this->connection = @mysqli_connect( $hostname, $username, $password, $database );
    }		
		
		if( ! $this->connection )
		{
			return $this->logDatabseErrors("database connection error!");
		}
		
		return $this->connection;
	}
	
	public function close()
	{
        return (is_resource($this->connection)) ? mysqli_close($this->connection) : false;
	}
	
	public function query( $query )
	{
        $sql_timerStart        = microtime(TRUE);
        $this->sqlResult       = mysqli_query($this->connection, $query);
        $this->sqlLastInserted = mysqli_insert_id($this->connection);
        $this->sqlAffectedRows = mysqli_affected_rows($this->connection);
        $sql_timerEnd          = microtime(TRUE);
    
		if($this->sqlResult === false)
		{
			return $this->logDatabseErrors($query);
		}
    
		return $this->sqlResult;
	}
	
	public function getRows()
	{
		$data_fetch = array();
		while($result_row = mysqli_fetch_assoc($this->sqlResult))
		{
			$data_fetch[] = $result_row;
		}
    
		return $data_fetch;
	}
	
	public function getRowNext()
	{
		return mysqli_fetch_assoc($this->sqlResult);
	}
	
	public function getConnection()
	{
		if(empty($this->connection))
		{
			return false;
		}
    
		return $this->connection;
	}
	
	public function getAffectedRows()
	{
        $sqlAffectedRows = $this->sqlAffectedRows;
		return $sqlAffectedRows;
	}
	
	public function getLastInsertId()
	{
        $sqlLastInserted = $this->sqlLastInserted;
		return $sqlLastInserted;
	}
	
	public function getError()
  {
		return array(
			"error_no"      => (is_null($this->connection) || false == $this->connection) ? mysqli_connect_errno() : mysqli_errno($this->connection),
			"error_message" => (is_null($this->connection) || false == $this->connection) ? mysqli_connect_error() : mysqli_error($this->connection)
		);
	}
	
	public function sanitizeQueryResult($query)
	{
		return mysqli_real_escape_string($this->connection, $query);
	}
}
