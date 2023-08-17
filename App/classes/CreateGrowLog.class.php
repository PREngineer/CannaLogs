<?php

protectContributor();

class CreateGrowLog extends Page
{
  
  //------------------------- Attributes -------------------------
  private $db = null;

  public $content = '';
  public $title = "CannaLogs - Create Grow Log";
  public $keywords = "CannaLogs, create grow log";
  
  //------------------------- Operations -------------------------
  
  /**
   * __construct
   *
   * @return void
   */
  public function __construct()
  {
    $this->db = new Database();
        
    parent::__construct();
  }

  /**
   * addTechniqueDate - Updates the project's technique date.
   *
   * @param  String $posted
   *
   * @return True|String
   */
  private function addTechniqueDate( $column, $date )
  {
    $projectid = $_GET['id'];
    
    // Get the current dates
    $dates = ( $this->db->query_DB("SELECT $column
                                    FROM Projects
                                    WHERE id = '$projectid'") )[0]["$column"];
    
    // Add the date to the existing dates
    if( $dates == '' )
    {
      $dates = $date;
    }
    else
    {
      $dates = "$dates,$date";
    }

    // Make change in the database
     $check = $this->db->query_DB("UPDATE Projects
                                   SET $column = '$dates'
                                   WHERE id = '$projectid'");
    return True;
  }
  
  /**
   * changeProjectStage - Updates the project's stage date.
   *
   * @param  String $posted
   *
   * @return True|String
   */
  private function changeProjectStage( $posted )
  {
    $projectid        = $_GET['id'];
    $date             = $this->db->sanitize( $posted['logDate'] );
    
    if( isset( $posted['startgermination'] ) && $posted['startgermination'] == 'on' )
    {
      $column = 'germinationdate';
    }
    if( isset( $posted['startvegetation'] ) && $posted['startvegetation'] == 'on' )
    {
      $column = 'vegetationdate';
    }
    if( isset( $posted['startflowering'] ) && $posted['startflowering'] == 'on' )
    {
      $column = 'floweringdate';
    }
    if( isset( $posted['startflushing'] ) && $posted['startflushing'] == 'on' )
    {
      $column = 'flushingdate';
    }
    if( isset( $posted['startharvesting'] ) && $posted['startharvesting'] == 'on' )
    {
      $column = 'harvestingdate';
    }

    // Make change in the database
     $check = $this->db->query_DB("UPDATE Projects
                                   SET $column = '$date'
                                   WHERE id = '$projectid'");
    return True;
  }
  
  /**
   * createFeedLog - Stores the entry in the database.
   *
   * @param  String $posted
   *
   * @return True|String
   */
  private function createFeedLog( $posted )
  {
    $projectid        = $_GET['id'];
    $date             = $this->db->sanitize( $posted['logDate'] );
    $daysfromstart    = $this->daysBetween( $posted['startdate'], $posted['logDate'] );
    $ph               = $this->db->sanitize( $posted['phfed'] );
    $ppm              = $this->db->sanitize( $posted['ppmfed'] );
    $water            = $this->db->sanitize( $posted['waterfed'] );
    $nutrientnames    = $this->db->sanitize( implode( ",", $posted['nutrientnames'] ) );
    $nutrientamounts  = $this->db->sanitize( implode( ",", $posted['nutrientamounts'] ) );
    
    // Make change in the database
     $check = $this->db->query_DB("INSERT INTO FeedLogs
                                   (projectid, date, daysfromstart, ph, ppm, water, nutrientnames, nutrientamounts)
                                   VALUES ('$projectid', '$date', '$daysfromstart', '$ph', '$ppm', '$water', '$nutrientnames', '$nutrientamounts')");
    return True;
  }

  /**
   * createObservationLog - Stores the entry in the database.
   *
   * @param  String $posted
   *
   * @return True|String
   */
  private function createObservationLog( $posted )
  {
    $projectid     = $_GET['id'];
    $date          = $this->db->sanitize( $posted['logDate'] );
    $daysfromstart = $this->daysBetween( $posted['startdate'], $posted['logDate'] );
    $mintemp       = $this->db->sanitize( $posted['mintemp'] );
    $maxtemp       = $this->db->sanitize( $posted['maxtemp'] );
    $humidity      = $this->db->sanitize( $posted['humidity'] );
    $lightcycle    = $this->db->sanitize( $posted['lightcycle'] );
    $smell         = $posted['smell'];
    if( isset( $posted['addfeed'] ) && $posted['addfeed'] == 'on'  )
    {
      $fed         = 'Yes';
    }
    else
    {
      $fed         = 'No';
    }
    if( isset( $posted['topped'] ) && $posted['topped'] == 'on' )
    {
      $topped      = 'Yes';
    }
    else
    {
      $topped = 'No';
    }
    if( isset( $posted['fimmed'] ) && $posted['fimmed'] == 'on' )
    {
      $fimmed      = 'Yes';
    }
    else
    {
      $fimmed      = 'No';
    }
    if( isset( $posted['lollipopped'] ) && $posted['lollipopped'] == 'on' )
    {
      $lollipopped = 'Yes';
    }
    else
    {
      $lollipopped = 'No';
    }
    $appearance    = $posted['healthappearance'];
    $notes         = $posted['editor'];
    
    // Make change in the database
     $check = $this->db->query_DB("INSERT INTO ObservationLogs
                                   (projectid, date, daysfromstart, mintemp, maxtemp, humidity, lightcycle, smell, topped, fimmed, lollipopped, appearance, notes, fed)
                                   VALUES ('$projectid', '$date', '$daysfromstart', '$mintemp', '$maxtemp', '$humidity', '$lightcycle', '$smell', '$topped', 
                                   '$fimmed', '$lollipopped', '$appearance', '$notes', '$fed')");
    return True;
  }

  /**
   * daysBetween - Calculates how many days have passed between 2 dates
   * 
   * @return int
   */
  private function daysBetween( $begin, $end )
  {
    return ceil ( abs ( ( strtotime($end) - strtotime($begin) ) / 86400 ) );
  }

  /**
   * getProjectName - Returns the project name.
   *
   * @return array
   */
  private function getProjectName( $id )
  {
    return ($this->db->query_DB("SELECT projectname
                                FROM Projects
                                WHERE id = '" . $_GET['id'] . "'
                              ") )[0];
  }
  
  /**
   * handlePOST - Takes control of the action once the form is posted.
   *
   * @param  mixed $posted
   *
   * @return void
   */
  private function handlePOST( $posted )
  {
    // Check that the grower is the one trying to add the entry
    $growerid = ( $this->db->query_DB("SELECT growerid
                                       FROM Projects
                                       WHERE id = '" . $_GET['id'] . "'") )[0];
                                       
    // If not an admin or the project's owner, not allowed
    if( ( ( $_SESSION['userRole'] != 0 ) && ( $growerid['growerid'] != $_SESSION['userID'] ) ) || 
        !isset( $_SESSION['userRole'] ) )
    {
      // Redirect to list of Announcements
      header( 'Location: index.php?display=ProjectDetails&id=' . $id );
      exit;
    }
    
    $this->createObservationLog( $posted );
    
    // Only if the option was checked
    if( isset( $posted['addfeed'] ) && $posted['addfeed'] == 'on' )
    {
      $this->createFeedLog( $posted );
    }

    // If Project Stage is changed
    if( isset( $posted['startgermination'] ) || isset( $posted['startvegetation'] ) || isset( $posted['startflowering'] ) || 
        isset( $posted['startflushing'] ) || isset( $posted['startharvesting'] ) )
    {
      $this->changeProjectStage( $posted );
    }

    // If techniques have been applied
    if( isset( $posted['topped'] ) && $posted['topped'] == 'on' )
    {
      $this->addTechniqueDate( 'toppingdates', $posted['logDate'] );
    }
    if( isset( $posted['fimmed'] ) && $posted['fimmed'] == 'on' )
    {
      $this->addTechniqueDate( 'fimmingdates', $posted['logDate'] );
    }
    if( isset( $posted['lollipopped'] ) && $posted['lollipopped'] == 'on' )
    {
      $this->addTechniqueDate( 'lollipoppingdates', $posted['logDate'] );
    }
    
    // Redirect to Project
    header( 'Location: index.php?display=ProjectDetails&id=' . $_GET['id'] );
  }

  /**
   * Display - Displays the full page
   *
   * @param  mixed $filter
   *
   * @return void
   */
  public function Display()
  {
    // Handle data
    if( isset( $_POST['editor'] ) )
    {
      $this->handlePOST( $_POST );
    }

    // Set the page header
    $this->content .= '
    <ol class="breadcrumb">
      <li><a href="index.php?display=Projects">Projects</a></li>
      <li><a href="index.php?display=ProjectDetails&id=' . $_GET['id'] . '">' . $this->getProjectName( $_GET['id'] )['projectname'] . '</a></li>
      <li><a href="#">Create Feed/Observation Log</a></li>
    </ol>
    ';

    $text = new CreateGrowLogBlock();
    $this->content .= $text->Display();

    parent::Display();
  }

}

?>