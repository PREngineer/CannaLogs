<?php

protectAdmin();

class DeleteUser extends Page
{
  
  //------------------------- Attributes -------------------------
  private $db = null;

  public $content = '';
  public $title = "CannaLogs - Delete User";
  public $keywords = "CannaLogs, delete user";
  
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
    $this->db->query_DB("DELETE FROM Users
                         WHERE id = '$id'");

    $this->content .= '
    <div class="container alert alert-success alert-dismissible text-center" role="alert"">
      <button type = "button" class="close" data-dismiss="alert">x</button>
        Successfully deleted user!
    </div>
    ';

    // Redirect to list of Announcements
    header( 'Location: index.php?display=AdminUsers' );
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
        <li><a href="index.php?display=AdminUsers">Users</a></li>
        <li><a href="#">Delete User</a></li>
      </ol>
      
      <h1 class="container" id="page-title" tabindex="-1" role="heading" aria-level="1">Delete User</h1>
      <hr>
      You will be redirected back to the users list in 5 seconds.
    ';

    parent::Display();
  }

}

?>