<?php

class DatabaseSetup
{

  //------------------------- Attributes -------------------------

  private $fname   = null;
  private $mname   = null;
  private $lname   = null;
  private $email   = null;
  private $appuser = null;
  private $apppass = null;

  private $dbtype  = null;
  private $dbname  = null;
  private $dbuser  = null;
  private $dbpass  = null;
  private $dbhost  = null;
  private $dbport  = null;

  private $PDO     = null;

  //------------------------- Operations -------------------------

  /**
   * __construct
   *
   * @param  array $data
   *
   * @return void
   */
  public function __construct( $data )
  {
    $this->fname    = $data['fname'];
    $this->mname    = $data['mname'];
    $this->lname    = $data['lname'];
    $this->email    = $data['email'];
    $this->appuser  = $data['appusername'];
    $this->apppass  = hash( 'sha256', SHA1( MD5( $data['apppassword'] ) ) );

    $this->dbtype  = $data['dbtype'];
    $this->dbname  = $data['dbname'];
    if( isset( $data['dbhost'] ) )
    { $this->dbhost  = $data['dbhost']; }
    if( isset( $data['dbport'] ) )
    { $this->dbport  = $data['dbport']; }
    if( isset( $data['dbusername'] ) )
    { $this->dbuser  = $data['dbusername']; }
    if( isset( $data['dbpassword'] ) )
    { $this->dbpass  = $data['dbpassword']; }

    // Delete previous DB file if re-running
    if( file_exists( "CannaLogs.db" ) )
    {
      unlink( "CannaLogs.db" );
    }

    // If using SQLite
    if( $this->dbtype == 'SQLite' )
    {
      // Create new DB file
      $this->PDO   = new PDO("sqlite:CannaLogs.db");

      // Save settings to file
      $file = 'settings.php';

      $content = '
      <?php
        // Database related settings
        $DBHOST = null;
        $DBPORT = null;
        $DBNAME = null;
        $DBUSER = null;
        $DBPASS = null;
        $DBTYPE = "SQLite";
      ?>';

      file_put_contents( $file, $content );
    }
    // If using MySQL, create the DB and set up the connection
    else
    {
      // Set up temporary PDO connection to create the DB
      $dsn = 'mysql:host=' . $this->dbhost . ';port=' . $this->dbport . ';charset=utf8';
      $PDO =  new PDO( $dsn, $this->dbuser, $this->dbpass );
      $PDO->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

      // Create the MySQL Database
      if( $this->createMySQLDB( $PDO ) )
      {
        // Set up the PDO connection to the created DB
        $dsn = 'mysql:host=' . $this->dbhost . ';port=' . $this->dbport . ';dbname=' . $this->dbname . ';charset=utf8';
        $this->PDO = new PDO( $dsn, $this->dbuser, $this->dbpass );
        $this->PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Save settings to file
        $file = 'settings.php';

        $content = '
        <?php
          // Database related settings
          $DBHOST = \'' . $this->dbhost . '\';
          $DBPORT = \'' . $this->dbport . '\';
          $DBNAME = \'' . $this->dbname . '\';
          $DBUSER = \'' . $this->dbuser . '\';
          $DBPASS = \'' . $this->dbpass . '\';
          $DBTYPE = \'' . $this->dbtype . '\';
        ?>';

        file_put_contents( $file, $content );
      }
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
   * createMySQLDB - Creates the DB in MySQL.
   *
   * @return bool|string Success|Error
   */
  public function createMySQLDB( $conn )
  {
    try
    {
      $stmt = $conn->prepare("CREATE DATABASE " . $this->dbname . "
                              DEFAULT CHARACTER SET = 'utf8'
                              DEFAULT COLLATE = 'utf8_general_ci'"
                            );

      $res = $stmt->execute();
      $stmt = null;
      $conn = null;
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
      if( $this->query_SQLite( $query ) )
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
        return True;
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
   * setup_UsersTable - Creates the Users Table.
   *
   * @return bool|string Success|Error
   */
  public function setup_UsersTable()
  {
    // Using SQLite
    if( $this->dbtype == 'SQLite' )
    {
      $res = $this->query_DB('CREATE TABLE IF NOT EXISTS Users (
                            "id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                            "fname" VARCHAR NOT NULL,
                            "mname" VARCHAR,
                            "lname" VARCHAR NOT NULL,
                            "username" VARCHAR NOT NULL,
                            "email" VARCHAR NOT NULL,
                            "password" VARCHAR NOT NULL,
                            "role" INTEGER NOT NULL
                            )'
                          );
    }
    // Using MySQL
    else
    {
      $res = $this->query_DB('CREATE TABLE IF NOT EXISTS Users 
                              ( id INT NOT NULL AUTO_INCREMENT, 
                                fname TEXT NOT NULL, 
                                mname TEXT NULL, 
                                lname TEXT NOT NULL, 
                                username TEXT NOT NULL, 
                                password TEXT NOT NULL, 
                                email TEXT NOT NULL, 
                                role INT NOT NULL, 
                                PRIMARY KEY (`id`) )'
                            );
    }
    
    return $res;
  }
  
  /**
   * create_adminUser - Creates the default Admin User.
   *
   * @return bool|string Success|Error
   */
  public function create_adminUser()
  {
    // Using SQLite
    if( $this->dbtype == 'SQLite' )
    {
      $res = $this->query_DB("INSERT INTO 'Users'
                              ('fname', 'mname', 'lname','username', 'email', 'password', 'role')
                              VALUES ('$this->fname', '$this->mname', '$this->lname','$this->appuser', '$this->email', '$this->apppass', '0')"
                            );
    }
    // Using MySQL
    else
    {
      $res = $this->query_DB("INSERT INTO Users
                              (fname, mname, lname, username, email, password, role)
                              VALUES ('$this->fname', '$this->mname', '$this->lname','$this->appuser', '$this->email', '$this->apppass', '0')"
                            );
    }
    
    return $res;
  }

  /**
   * setup_AnnouncementsTable - Creates the Announcements Table.
   *
   * @return bool|string Success|Error
   */
  public function setup_AnnouncementsTable()
  {
    // Using SQLite
    if( $this->dbtype == 'SQLite' )
    {
      $res = $this->query_DB('CREATE TABLE IF NOT EXISTS "Announcements" (
                              "id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                              "poster" VARCHAR NOT NULL,
                              "datetime" DATETIME NOT NULL,
                              "title" VARCHAR NOT NULL,
                              "content" VARCHAR NOT NULL
                              )'
                            );
    }
    // Using MySQL
    else
    {
      $res = $this->query_DB("CREATE TABLE IF NOT EXISTS Announcements (
                              id INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
                              poster TEXT NOT NULL,
                              datetime DATETIME NOT NULL,
                              title TEXT NOT NULL,
                              content TEXT NOT NULL
                              )"
                            );
    }
    
    return $res;
  }

  /**
   * setup_FeedLogsTable - Creates the FeedLogs Table.
   *
   * @return bool|string Success|Error
   */
  public function setup_FeedLogsTable()
  {
    // Using SQLite
    if( $this->dbtype == 'SQLite' )
    {
      $res = $this->query_DB('CREATE TABLE IF NOT EXISTS "FeedLogs" (
                              "id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                              "projectid" INTEGER NOT NULL,
                              "date" DATE NOT NULL,
                              "daysfromstart" INTEGER NOT NULL,
                              "ph" DOUBLE NOT NULL,
                              "ppm" INT NOT NULL,
                              "water" VARCHAR,
                              "nutrientnames" VARCHAR NOT NULL,
                              "nutrientamounts" VARCHAR NOT NULL
                              )'
                            );
    }
    // Using MySQL
    else
    {
      $res = $this->query_DB('CREATE TABLE IF NOT EXISTS FeedLogs (
                              id INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
                              projectid INTEGER NOT NULL,
                              date DATE NOT NULL,
                              daysfromstart INTEGER NOT NULL,
                              ph DOUBLE NOT NULL,
                              ppm INT NOT NULL,
                              water TEXT,
                              nutrientnames TEXT NOT NULL,
                              nutrientamounts TEXT NOT NULL
                              )'
                            );
    }
    
    return $res;
  }

  /**
   * setup_ObservationLogsTable - Creates the ObservationLogs Table.
   *
   * @return bool|string Success|Error
   */
  public function setup_ObservationLogsTable()
  {
    // Using SQLite
    if( $this->dbtype == 'SQLite' )
    {
      $res = $this->query_DB('CREATE TABLE IF NOT EXISTS "ObservationLogs" (
                              "id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                              "projectid" INTEGER NOT NULL,
                              "date" DATE NOT NULL,
                              "daysfromstart" INTEGER NOT NULL,
                              "mintemp" VARCHAR NOT NULL,
                              "maxtemp" VARCHAR NOT NULL,
                              "humidity" VARCHAR NOT NULL,
                              "lightcycle" VARCHAR NOT NULL,
                              "smell" VARCHAR NOT NULL,
                              "topped" VARCHAR NOT NULL,
                              "fimmed" VARCHAR NOT NULL,
                              "lollipopped" VARCHAR NOT NULL,
                              "appearance" VARCHAR NOT NULL,
                              "notes" VARCHAR NOT NULL,
                              "fed" VARCHAR NOT NULL
                              )'
                            );
    }
    // Using MySQL
    else
    {
      $res = $this->query_DB('CREATE TABLE IF NOT EXISTS ObservationLogs (
                              id INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
                              projectid INTEGER NOT NULL,
                              date DATE NOT NULL,
                              daysfromstart INTEGER NOT NULL,
                              mintemp TEXT NOT NULL,
                              maxtemp TEXT NOT NULL,
                              humidity TEXT NOT NULL,
                              lightcycle TEXT NOT NULL,
                              smell TEXT NOT NULL,
                              topped TEXT NOT NULL,
                              fimmed TEXT NOT NULL,
                              lollipopped TEXT NOT NULL,
                              appearance TEXT NOT NULL,
                              notes LONGTEXT NOT NULL,
                              fed TEXT NOT NULL
                              )'
                            );
    }
    
    return $res;
  }

  /**
   * setup_ProjectsTable - Creates the Projects Table.
   *
   * @return bool|string Success|Error
   */
  public function setup_ProjectsTable()
  {
    // Using SQLite
    if( $this->dbtype == 'SQLite' )
    {
      $res = $this->query_DB('CREATE TABLE IF NOT EXISTS "Projects" (
                              "id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                              "projectname" VARCHAR NOT NULL,
                              "growerid" VARCHAR NOT NULL,
                              "purpose" VARCHAR NOT NULL,
                              "location" VARCHAR NOT NULL,
                              "projectstatus" VARCHAR NOT NULL,
                              "startdate" DATE NOT NULL,
                              "germinationdate" DATE,
                              "vegetationdate" DATE,
                              "floweringdate" DATE,
                              "flushingdate" DATE,
                              "harvestingdate" DATE,
                              "toppingdates" VARCHAR,
                              "fimmingdates" VARCHAR,
                              "lollipoppingdates" VARCHAR,
                              "usinglst" VARCHAR,
                              "usingmonstercropping" VARCHAR,
                              "usingscreenofgreen" VARCHAR,
                              "usingseaofgreen" VARCHAR,
                              "planttags" VARCHAR NOT NULL,
                              "plantstrains" VARCHAR NOT NULL,
                              "plantsex" VARCHAR NOT NULL,
                              "plantvariety" VARCHAR NOT NULL,
                              "planttype" VARCHAR NOT NULL,
                              "plantbreeders" VARCHAR NOT NULL,
                              "plantprices" VARCHAR NOT NULL,
                              "startermedium" VARCHAR NOT NULL,
                              "medium" VARCHAR NOT NULL,
                              "mediumcomponents" VARCHAR,
                              "mediumcomponentspercentage" VARCHAR,
                              "hydromethod" VARCHAR,
                              "nutrientbrands" VARCHAR NOT NULL,
                              "nutrientnames" VARCHAR NOT NULL,
                              "containersizeseedling" VARCHAR NOT NULL,
                              "containersizevegetation" VARCHAR NOT NULL,
                              "containersizeflowering" VARCHAR NOT NULL,
                              "usingtent" VARCHAR NOT NULL,
                              "tentsize" VARCHAR,
                              "lighttype" VARCHAR NOT NULL,
                              "lightwattage" VARCHAR NOT NULL,
                              "usingventilationfans" VARCHAR NOT NULL,
                              "ventilationfansamount" VARCHAR,
                              "ventilationfanstype" VARCHAR,
                              "usingextractionfan" VARCHAR NOT NULL,
                              "extractionfancfm" VARCHAR,
                              "usingintakefan" VARCHAR NOT NULL,
                              "intakefancfm" VARCHAR,
                              "usingcarbonfilter" VARCHAR NOT NULL,
                              "usingdehumidifier" VARCHAR NOT NULL,
                              "usinghumidifier" VARCHAR NOT NULL,
                              "usingheater" VARCHAR NOT NULL,
                              "usingac" VARCHAR NOT NULL,
                              "usingthermohygrometer" VARCHAR NOT NULL,
                              "usingppmphmeters" VARCHAR NOT NULL,
                              "usingpowerstrip" VARCHAR NOT NULL,
                              "usingtimers" VARCHAR NOT NULL,
                              "usingphbalancers" VARCHAR NOT NULL,
                              "usinggloves" VARCHAR NOT NULL,
                              "usingsunglasses" VARCHAR NOT NULL,
                              "usingspraybottles" VARCHAR NOT NULL,
                              "usingtiesstring" VARCHAR NOT NULL,
                              "usingtape" VARCHAR NOT NULL,
                              "usingscissors" VARCHAR NOT NULL,
                              "usingmagnifier" VARCHAR NOT NULL,
                              "usingmasonjars" VARCHAR NOT NULL,
                              "usingdryingrack" VARCHAR NOT NULL,
                              "lessonslearned" VARCHAR
                              )'
                            );
    }
    // Using MySQL
    else
    {
      $res = $this->query_DB('CREATE TABLE IF NOT EXISTS Projects (
                              id INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
                              projectname TEXT NOT NULL,
                              growerid TEXT NOT NULL,
                              purpose TEXT NOT NULL,
                              location TEXT NOT NULL,
                              projectstatus TEXT NOT NULL,
                              startdate DATE NOT NULL,
                              germinationdate DATE,
                              vegetationdate DATE,
                              floweringdate DATE,
                              flushingdate DATE,
                              harvestingdate DATE,
                              toppingdates TEXT,
                              fimmingdates TEXT,
                              lollipoppingdates TEXT,
                              usinglst TEXT,
                              usingmonstercropping TEXT,
                              usingscreenofgreen TEXT,
                              usingseaofgreen TEXT,
                              planttags TEXT NOT NULL,
                              plantstrains TEXT NOT NULL,
                              plantsex TEXT NOT NULL,
                              plantvariety TEXT NOT NULL,
                              planttype TEXT NOT NULL,
                              plantbreeders TEXT NOT NULL,
                              plantprices TEXT NOT NULL,
                              startermedium TEXT NOT NULL,
                              medium TEXT NOT NULL,
                              mediumcomponents TEXT,
                              mediumcomponentspercentage TEXT,
                              hydromethod TEXT,
                              nutrientbrands TEXT NOT NULL,
                              nutrientnames TEXT NOT NULL,
                              containersizeseedling TEXT NOT NULL,
                              containersizevegetation TEXT NOT NULL,
                              containersizeflowering TEXT NOT NULL,
                              usingtent TEXT NOT NULL,
                              tentsize TEXT,
                              lighttype TEXT NOT NULL,
                              lightwattage TEXT NOT NULL,
                              usingventilationfans TEXT NOT NULL,
                              ventilationfansamount TEXT,
                              ventilationfanstype TEXT,
                              usingextractionfan TEXT NOT NULL,
                              extractionfancfm TEXT,
                              usingintakefan TEXT NOT NULL,
                              intakefancfm TEXT,
                              usingcarbonfilter TEXT NOT NULL,
                              usingdehumidifier TEXT NOT NULL,
                              usinghumidifier TEXT NOT NULL,
                              usingheater TEXT NOT NULL,
                              usingac TEXT NOT NULL,
                              usingthermohygrometer TEXT NOT NULL,
                              usingppmphmeters TEXT NOT NULL,
                              usingpowerstrip TEXT NOT NULL,
                              usingtimers TEXT NOT NULL,
                              usingphbalancers TEXT NOT NULL,
                              usinggloves TEXT NOT NULL,
                              usingsunglasses TEXT NOT NULL,
                              usingspraybottles TEXT NOT NULL,
                              usingtiesstring TEXT NOT NULL,
                              usingtape TEXT NOT NULL,
                              usingscissors TEXT NOT NULL,
                              usingmagnifier TEXT NOT NULL,
                              usingmasonjars TEXT NOT NULL,
                              usingdryingrack TEXT NOT NULL,
                              lessonslearned TEXT
                              )'
                            );
    }
    
    return $res;
  }

  /**
   * setup_HarvestReviewsTable - Creates the HarvestReviews Table.
   *
   * @return bool|string Success|Error
   */
  public function setup_HarvestReviewsTable()
  {
    // Using SQLite
    if( $this->dbtype == 'SQLite' )
    {
      $res = $this->query_DB('CREATE TABLE IF NOT EXISTS "HarvestReviews" (
                              "id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                              "projectid" INTEGER NOT NULL,
                              "date" DATE NOT NULL,
                              "overallrating" INTEGER NOT NULL,
                              "strain" VARCHAR NOT NULL,
                              "totalyield" VARCHAR NOT NULL,
                              "deliverymedium" VARCHAR NOT NULL,
                              "deliverymethod" VARCHAR NOT NULL,
                              "feelings" VARCHAR,
                              "relieves" VARCHAR,
                              "sideeffects" VARCHAR,
                              "terpenes" VARCHAR,
                              "floraltasteprofile" INTEGER NOT NULL,
                              "sweettasteprofile" INTEGER NOT NULL,
                              "spicytasteprofile" INTEGER NOT NULL,
                              "earthytasteprofile" INTEGER NOT NULL,
                              "woodytasteprofile" INTEGER NOT NULL,
                              "sourtasteprofile" INTEGER NOT NULL,
                              "citrusytasteprofile" INTEGER NOT NULL,
                              "fruitytasteprofile" INTEGER NOT NULL,
                              "thcpercent" VARCHAR,
                              "cbdpercent" VARCHAR,
                              "cbgpercent" VARCHAR,
                              "cbcpercent" VARCHAR,
                              "cbgvpercent" VARCHAR,
                              "thcvpercent" VARCHAR,
                              "cbdvpercent" VARCHAR,
                              "cbcvpercent" VARCHAR,
                              "notes" VARCHAR NOT NULL
                              )'
                            );
    }
    // Using MySQL
    else
    {
      $res = $this->query_DB('CREATE TABLE IF NOT EXISTS HarvestReviews (
                              id INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
                              projectid INTEGER NOT NULL,
                              date DATE NOT NULL,
                              overallrating INTEGER NOT NULL,
                              strain TEXT NOT NULL,
                              totalyield TEXT NOT NULL,
                              deliverymedium TEXT NOT NULL,
                              deliverymethod TEXT NOT NULL,
                              feelings TEXT,
                              relieves TEXT,
                              sideeffects TEXT,
                              terpenes TEXT,
                              floraltasteprofile INTEGER NOT NULL,
                              sweettasteprofile INTEGER NOT NULL,
                              spicytasteprofile INTEGER NOT NULL,
                              earthytasteprofile INTEGER NOT NULL,
                              woodytasteprofile INTEGER NOT NULL,
                              sourtasteprofile INTEGER NOT NULL,
                              citrusytasteprofile INTEGER NOT NULL,
                              fruitytasteprofile INTEGER NOT NULL,
                              thcpercent TEXT,
                              cbdpercent TEXT,
                              cbgpercent TEXT,
                              cbcpercent TEXT,
                              cbgvpercent TEXT,
                              thcvpercent TEXT,
                              cbdvpercent TEXT,
                              cbcvpercent TEXT,
                              notes TEXT NOT NULL
                              )'
                            );
    }
    
    return $res;
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