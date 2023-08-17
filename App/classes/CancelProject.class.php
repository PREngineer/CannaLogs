<?php

protectContributor();

class CancelProject extends Page
{
  
  //------------------------- Attributes -------------------------
  private $db = null;

  public $content = '';
  public $title = "CannaLogs - Cancel Project";
  public $keywords = "CannaLogs, cancel project";
  
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
   * checkAllowed - Makes sure that the user is allowed to perform this change on this specific project.
   *
   * @param  int $id
   *
   * @return void
   */
  private function checkAllowed( $id )
  {
    // If not an admin or the project's owner, not allowed
    $growerid = ( $this->db->query_DB("SELECT growerid
                                       FROM Projects
                                       WHERE id = '$id'") )[0];
    
    // If not an admin or the project's owner, not allowed
    if( ( ( $_SESSION['userRole'] != 0 ) && ( $growerid['growerid'] != $_SESSION['userID'] ) ) || 
        !isset( $_SESSION['userRole'] ) )
    {
      // Redirect to list of Announcements
      header( 'Location: index.php?display=ProjectDetails&id=' . $id );
      exit;
    }
    else
    {
      return true;
    }
  }
  
  /**
   * cancel - Set the project status to Cancelled.
   *
   * @param  int $id
   *
   * @return void
   */
  private function cancel( $id )
  {
    // Make change in the database
    $this->db->query_DB("UPDATE Projects
                         SET projectstatus = 'Cancelled'
                         WHERE id = '$id'");
                         
    $this->content .= '
    <div class="container alert alert-success alert-dismissible text-center" role="alert"">
      <button type = "button" class="close" data-dismiss="alert">x</button>
        Successfully cancelled project!
    </div>
    ';

    // Redirect to Project Details
    header( 'Location: index.php?display=ProjectDetails&id=' . $id );
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
    if( $this->checkAllowed( $_GET['id'] ) )
    {
      // Handle data
      $this->cancel( $_GET['id'] );
    }
    
    // Set the page header
    $this->content .= '
      <ol class="breadcrumb">
        <li><a href="index.php?display=Projects">Projects</a></li>
        <li><a href="#">Cancel Project</a></li>
      </ol>
      
      <h1 class="container" id="page-title" tabindex="-1" role="heading" aria-level="1">Cancel Project</h1>
      <hr>
      You will be redirected back to the project details in 5 seconds.
    ';

    parent::Display();
  }

}

?>