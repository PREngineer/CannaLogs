<?php

protectAdmin();

class CreateAnnouncement extends Page
{
  
  //------------------------- Attributes -------------------------
  private $db = null;

  public $content = '';
  public $title = "CannaLogs - Create Announcement";
  public $keywords = "CannaLogs, create announcement";
  
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
   * handlePOST - Takes control of the action once the form is posted.
   *
   * @param  mixed $posted
   *
   * @return void
   */
  private function handlePOST( $posted )
  {
    
    $success = $this->create( $posted );
    
    // Redirect to list of Announcements
    header( 'Location: index.php' );
  }

  /**
   * create - Stores the entry in the database.
   *
   * @param  String $posted
   *
   * @return True|String
   */
  private function create( $posted )
  {
    $title   = $this->db->sanitize( $posted['title'] );
    $content = $posted['editor'];
    $date    = ( new DateTime() )->format("Y-m-d H:i:s");
    $poster  = $_SESSION['userID'];
    
    // Make change in the database
     $check = $this->db->query_DB("INSERT INTO Announcements
                                   (poster, datetime, title, content)
                                   VALUES ('$poster', '$date', '$title', '$content')");
    return True;
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
      <li><a href="index.php">Announcements</a></li>
      <li><a href="#">Create Announcement</a></li>
    </ol>
    <h1 class="container" id="page-title" tabindex="-1" role="heading" aria-level="1">Create Announcement</h1>
    <hr>
    ';

    $text = new CreateAnnouncementBlock();
    $this->content .= $text->Display();

    parent::Display();
  }

}

?>