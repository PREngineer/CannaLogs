<?php

protectAdmin();

class EditAnnouncement extends Page
{
  
  //------------------------- Attributes -------------------------
  private $db = null;

  public $content = '';
  public $title = "CannaLogs - Edit Announcement";
  public $keywords = "CannaLogs, edit announcement";
  
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
    
    $success = $this->update( $posted );
    
    if( $success === True )
    {
      // Redirect to list of Announcements
      header( 'Location: index.php' );
    }
    else
    {
      $this->content .= '
      <div class="container alert alert-danger alert-dismissible text-center" role="alert"">
        <button type="button" class="close" data-dismiss="alert">x</button>
        Failed to update announcement!
        <hr>
        ' . $success . '
      </div>';
    }
  }

  /**
   * update - Stores the changes in the database.
   *
   * @param  String $posted
   *
   * @return True|String
   */
  private function update( $posted )
  {
    $id      = $_GET['id'];
    $title   = $this->db->sanitize( $posted['title'] );
    $content = $posted['editor'];

    // Make change in the database
    $check = $this->db->query_DB("UPDATE Announcements
                                  SET content = '$content', title = '$title'
                                  WHERE id = '$id'");
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
      <li><a href="#">Edit Announcement</a></li>
    </ol>
    <h1 class="container" id="page-title" tabindex="-1" role="heading" aria-level="1">Edit Announcement</h1>
    <hr>
    ';

    $text = new EditAnnouncementBlock();
    $this->content .= $text->Display();

    parent::Display();
  }

}

?>