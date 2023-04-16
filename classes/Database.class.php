<?php

class Database
{

  //------------------------- Attributes -------------------------

  private $PDO    = null;

  private $dbtype = null;
  private $dbname = null;
  private $dbuser = null;
  private $dbpass = null;
  private $dbhost = null;
  private $dbport = null;

  //------------------------- Operations -------------------------

  /**
   * __construct
   *
   * @param  array $data
   *
   * @return void
   */
  public function __construct()
  {
    // Read the settings file
    require 'settings.php';

    $this->dbtype = $DBTYPE;
    $this->dbname = $DBNAME;
    $this->dbuser = $DBUSER;
    $this->dbpass = $DBPASS;
    $this->dbhost = $DBHOST;
    $this->dbport = $DBPORT;

    // If using SQLite
    if( $this->dbtype == 'SQLite' )
    {
      // Create new DB file
      $this->PDO   = new PDO("sqlite:CannaLogs.db");
    }
    // If using MySQL, create the DB and set up the connection
    else
    {
      // Set up the PDO connection to the created DB
      $dsn = 'mysql:host=' . $this->dbhost . ';port=' . $this->dbport . ';dbname=' . $this->dbname . ';charset=utf8';
      $this->PDO = new PDO( $dsn, $this->dbuser, $this->dbpass );
      $this->PDO->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    }
  }

  /**
   * connect - Establishes a connection to the MySQL database.
   *
   * @return bool|string Success|Error
   */
  public function connect()
  {
    // Set up only if not already connected
    $dsn = 'mysql:host=' . $this->dbhost . ';port=' . $this->dbport . ';dbname=' . $this->dbname . ';charset=utf8';

    try
    {
      $this->PDO = new PDO( $dsn, $this->dbuser, $this->dbpass );
      $this->PDO->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    }
    catch( PDOException $error )
    {
      return $error->getMessage();
    }

    return True;
  }

  /**
   * queryDB - Executes a query against the database.
   *
   * @param  string $query
   *
   * @return bool|string Success|Error
   */
  public function query_DB( $query )
  {
    // If using SQLite
    if( $this->dbtype == 'SQLite' )
    {
      // Query SQLite
      $ret = $this->query_SQLite( $query );
      if( is_array( $ret ) )
      {
        return $ret;
      }
      // Else, return the errors
      else
      {
        return True;
      }
    }
    // If using MySQL
    else
    {
      // Query MySQL
      $ret = $this->query_MySQL( $query );

      // If it is successful, return True
      if( is_array( $ret ) )
      {
        return $ret;
      }
      // Else, return the errors
      else
      {
        return $ret;
      }
    }
  }

  /**
   * query_SQLite - Executes a query against the database.
   *
   * @param  string $query
   *
   * @return bool|string Success|Error
   */
  public function query_SQLite( $query )
  {
    // If we can't open the DB
    if( !$this->PDO )
    {
      Die("Failed to connect to the DB.");
    }
    // If we can open the DB
    else
    {
      // Execute the query
      $stmt = $this->PDO->query( $query );

      // If it fails
      if( !$stmt )
      {
        die( print_r( $this->PDO->errorInfo(), true ) );
      }

      // Otherwise, return the result
      return $stmt->fetchAll();
    }
  }

  /**
   * query_MySQL - Executes a query against the database.
   *
   * @param  string $query
   *
   * @return bool|string Success|Error
   */
  public function query_MySQL( $query )
  {
    try
    {
      // Successfully connect
      if( $this->connect() )
      {
        $stmt = $this->PDO->prepare( $query );
        $stmt->execute();
        // Otherwise, return the result
        $res = $stmt->fetchAll();
        $stmt = null;

        return $res;
      }
    }
    catch( PDOException $error )
    {
      echo"<br>Did not execute the query!<br>Error: " . $error->getMessage() . "<br>";
      return $error->getMessage();
    }
  }

  /**
   * This function escapes special characters that are a problem due to SQL injection
   */
  public function sanitize( $string )
  {
    $string = str_replace('\\', '\\\\', $string);
    $string = str_replace("'", "\'", $string);
    $string = str_replace('"', '\"', $string);
    $string = str_replace("\0", '\0', $string);
    $string = str_replace(chr(8), '\b', $string);
    $string = str_replace("\n", '\n', $string);
    $string = str_replace("\r", '\r', $string);
    $string = str_replace("\t", '\t', $string);
    $string = str_replace(chr(26), '\Z', $string);
    // $string = str_replace("%", "\%", $string);
    $string = str_replace("_", "\_", $string);
    return $string;
  }

}

?>
