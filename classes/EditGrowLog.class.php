<?php

protectContributor();

class EditGrowLog extends Page
{
  
  //------------------------- Attributes -------------------------
  private $db = null;

  public $content = '';
  public $title = "CannaLogs - Edit Grow Log";
  public $keywords = "CannaLogs, edit grow log";
  
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
   * updateObservationLog - Stores the entry in the database.
   *
   * @param  String $posted
   *
   * @return True|String
   */
  private function updateObservationLog( $posted )
  {
    $projectid     = $posted['projectid'];
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
     $check = $this->db->query_DB("UPDATE ObservationLogs
                                   SET projectid = '$projectid', 
                                       date = '$date',
                                       daysfromstart = '$daysfromstart',
                                       mintemp = '$mintemp',
                                       maxtemp = '$maxtemp',
                                       humidity = '$humidity',
                                       lightcycle = '$lightcycle',
                                       smell = '$smell',
                                       topped = '$topped',
                                       fimmed = '$fimmed',
                                       lollipopped = '$lollipopped',
                                       appearance = '$appearance',
                                       notes = '$notes',
                                       fed = '$fed'
                                   WHERE id = '" . $_GET['id'] . "'");
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
   * editTechniqueDate - Updates the project's technique date.
   *
   * @param  String $posted
   *
   * @return True|String
   */
  private function editTechniqueDate( $column, $date )
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
   * getProjectID - Returns the project ID from the observation log ID.
   *
   * @return array
   */
  private function getProjectID( $id )
  {
    return ($this->db->query_DB("SELECT projectid
                                FROM ObservationLogs
                                WHERE id = '$id'
                              ") )[0];
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
                                WHERE id = '$id'
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
    // Check that the grower is the person trying to edit
    $growerid = ( $this->db->query_DB("SELECT growerid
                                       FROM Projects
                                       WHERE id = '" . $_POST['projectid'] . "'") )[0]['growerid'];
    
    // If not an admin or the project's owner, not allowed
    if( ( ( $_SESSION['userRole'] != 0 ) && ( $growerid['growerid'] != $_SESSION['userID'] ) ) || 
        !isset( $_SESSION['userRole'] ) )
    {
      // Redirect to list of Announcements
      header( 'Location: index.php?display=ProjectDetails&id=' . $_POST['projectid'] );
      exit;
    }
    
    $this->updateObservationLog( $posted );
    
    // If Project Stage is changed
    if( isset( $posted['startgermination'] ) || isset( $posted['startvegetation'] ) || isset( $posted['startflowering'] ) || 
        isset( $posted['startflushing'] ) || isset( $posted['startharvesting'] ) )
    {
      // $this->changeProjectStage( $posted );
    }

    // If techniques have been applied
    if( isset( $posted['topped'] ) && $posted['topped'] == 'on' )
    {echo'<br>Adding Topping Date';
      // $this->editTechniqueDate( 'toppingdates', $posted['logDate'] );
    }
    // Remove if taken out
    if( !isset( $posted['topped'] ) && $posted['oldtopped'] == 'Yes' )
    {echo'<br>Removing Topping Date';
      // $this->RemoveTechniqueDate( 'toppingdates', $posted['olddate'] );
    }
    if( isset( $posted['fimmed'] ) && $posted['fimmed'] == 'on' )
    {echo'<br>Adding Fimming Date';
      // $this->editTechniqueDate( 'fimmingdates', $posted['logDate'] );
    }
    // Remove if taken out
    if( !isset( $posted['fimmed'] ) && $posted['oldfimmed'] == 'Yes' )
    {echo'<br>Removing Fimming Date';
      // $this->RemoveTechniqueDate( 'fimmingdates', $posted['olddate'] );
    }
    if( isset( $posted['lollipopped'] ) && $posted['lollipopped'] == 'on' )
    {echo'<br>Adding Lollipopping Date';
      // $this->editTechniqueDate( 'lollipoppingdates', $posted['logDate'] );
    }
    // Remove if taken out
    if( !isset( $posted['lollipopped'] ) && $posted['oldlollipopped'] == 'Yes' )
    {echo'<br>Removing Lollipopping Date';
      // $this->RemoveTechniqueDate( 'lollipoppingdates', $posted['olddate'] );
    }
    
    // Redirect to Project
    header( 'Location: index.php?display=ProjectDetails&id=' . $_POST['projectid'] );
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
      <li><a href="index.php?display=ProjectDetails&id=' . ( $this->getProjectID( $_GET['id'] )['projectid'] ) . '">' . $this->getProjectName(  ( $this->getProjectID( $_GET['id'] )['projectid'] ) )['projectname'] . '</a></li>
      <li><a href="#">Edit Feed/Observation Log</a></li>
    </ol>
    ';

    $text = new EditGrowLogBlock( $_GET['id'] );
    $this->content .= $text->Display();

    parent::Display();
  }

}

?>