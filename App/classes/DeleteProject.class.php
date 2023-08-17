<?php

protectContributor();

class DeleteProject extends Page
{
  
  //------------------------- Attributes -------------------------
  private $db = null;

  public $content = '';
  public $title = "CannaLogs - Delete Project";
  public $keywords = "CannaLogs, delete project";
  
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
      //header( 'Location: index.php?display=ProjectDetails&id=' . $id );
      exit;
    }
    else
    {
      return true;
    }
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
    $this->db->query_DB("DELETE FROM Projects
                         WHERE id = '$id'");
                         
    $this->content .= '
    <div class="container alert alert-success alert-dismissible text-center" role="alert"">
      <button type = "button" class="close" data-dismiss="alert">x</button>
        Successfully deleted project!
    </div>
    ';

    // Redirect to list of Announcements
    // header( 'Location: index.php?display=Projects' );
  }

  /**
   * deleteFeedLogs - Deletes the entries from the database.
   *
   * @param  int $id
   *
   * @return void
   */
  private function deleteFeedLogs( $id )
  {
    // Make change in the database
    $this->db->query_DB("DELETE FROM FeedLogs
                         WHERE projectid = '$id'");
                         
    $this->content .= '
    <div class="container alert alert-success alert-dismissible text-center" role="alert"">
      <button type = "button" class="close" data-dismiss="alert">x</button>
        Successfully deleted project feed logs!
    </div>
    ';

    // Redirect to list of Announcements
    // header( 'Location: index.php?display=Projects' );
  }

  /**
   * deleteHarvestReviews - Deletes the entries from the database.
   *
   * @param  int $id
   *
   * @return void
   */
  private function deleteHarvestReviews( $id )
  {
    // Make change in the database
    $this->db->query_DB("DELETE FROM HarvestReviews
                         WHERE projectid = '$id'");
                         
    $this->content .= '
    <div class="container alert alert-success alert-dismissible text-center" role="alert"">
      <button type = "button" class="close" data-dismiss="alert">x</button>
        Successfully deleted project reviews!
    </div>
    ';

    // Redirect to list of Announcements
    // header( 'Location: index.php?display=Projects' );
  }

  /**
   * deleteObservationLogs - Deletes the entries from the database.
   *
   * @param  int $id
   *
   * @return void
   */
  private function deleteObservationLogs( $id )
  {
    // Make change in the database
    $this->db->query_DB("DELETE FROM ObservationLogs
                         WHERE projectid = '$id'");
                         
    $this->content .= '
    <div class="container alert alert-success alert-dismissible text-center" role="alert"">
      <button type = "button" class="close" data-dismiss="alert">x</button>
        Successfully deleted project reviews!
    </div>
    ';

    // Redirect to list of Announcements
    header( 'Location: index.php?display=Projects' );
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
      // Delete Project data
      $this->delete( $_GET['id'] );
      // Delete feed logs
      $this->deleteFeedLogs( $_GET['id'] );
      // Delete harvest reviews
      $this->deleteHarvestReviews( $_GET['id'] );
      // Delete observation logs
      $this->deleteObservationLogs( $_GET['id'] );
    }
    
    // Set the page header
    $this->content .= '
      <ol class="breadcrumb">
        <li><a href="index.php?display=Projects">Projects</a></li>
        <li><a href="#">Delete Project</a></li>
      </ol>
      
      <h1 class="container" id="page-title" tabindex="-1" role="heading" aria-level="1">Delete Project</h1>
      <hr>
      You will be redirected back to the projects list in 5 seconds.
    ';

    parent::Display();
  }

}

?>