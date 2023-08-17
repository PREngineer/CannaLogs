<?php

protectAdmin();

class DeleteAnnouncement extends Page
{
  
  //------------------------- Attributes -------------------------
  private $db = null;

  public $content = '';
  public $title = "CannaLogs - Delete Announcement";
  public $keywords = "CannaLogs, delete announcement";
  
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
   * delete - Deletes the entry from the database.
   *
   * @param  int $id
   *
   * @return void
   */
  private function delete( $id )
  {
    // Make change in the database
    $this->db->query_DB("DELETE FROM Announcements
                         WHERE id = '$id'");
                         
    $this->content .= '
    <div class="container alert alert-success alert-dismissible text-center" role="alert"">
      <button type = "button" class="close" data-dismiss="alert">x</button>
        Successfully deleted announcement!
    </div>
    ';

    // Redirect to list of Announcements
    header( 'Location: index.php' );
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
    $this->delete( $_GET['id'] );
    
    // Set the page header
    $this->content .= '
      <ol class="breadcrumb">
        <li><a href="index.php">Announcements</a></li>
        <li><a href="#">Delete Announcement</a></li>
      </ol>
      
      <h1 class="container" id="page-title" tabindex="-1" role="heading" aria-level="1">Delete Announcement</h1>
      <hr>
      You will be redirected back to the announcements list in 5 seconds.
    ';

    parent::Display();
  }

}

?>