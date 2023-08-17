<?php

class CreateLessonsLearned extends Page
{
  
  //------------------------- Attributes -------------------------
  private $db = null;

  public $content = '';
  public $title = "CannaLogs - Create Lessons Learned";
  public $keywords = "CannaLogs, create lessons learned";
  
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
   * create - Add the lessons learned to the database.
   *
   * @return array
   */
  private function create( $posted )
  {
    $notes = $posted['editor'];
    return $this->db->query_DB("UPDATE Projects
                                SET lessonslearned = '$notes'
                                WHERE id = '" . $_GET['id'] . "'
                              ");
  }

  /**
   * getProjectDetails - Returns the project details.
   *
   * @return array
   */
  private function getProjectDetails( $id )
  {
    return ($this->db->query_DB("SELECT *
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
    $this->create( $posted );
    
    // Redirect to list of Announcements
    header( 'Location: index.php?display=ProjectDetails&id=' . $_GET['id'] );
  }

  /**
   * Display - Displays the page.
   *
   * @param  None
   *
   * @return void
   */
  public function Display()
  {
    $project = $this->getProjectDetails( $_GET['id'] );
    
    // If not an admin or the project's owner, not allowed
    if( ( ( $_SESSION['userRole'] != 0 ) && ( $project['growerid'] != $_SESSION['userID'] ) ) || 
        !isset( $_SESSION['userRole'] ) )
    {
      header( 'Location: index.php?display=ProjectDetails&id=' . $_GET['id'] );
    }
    
    // Handle data
    if( isset( $_POST['editor'] ) )
    {
      $this->handlePOST( $_POST );
    }

    // Define the content
    $this->content .= '
    <ol class="breadcrumb">
      <li><a href="index.php?display=Projects">Projects</a></li>
      <li><a href="index.php?display=ProjectDetails&id=' . $_GET['id'] . '">' . $project['projectname'] . '</a></li>
      <li><a href="#">Add Lessons Learned</a></li>
    </ol>
    
    <h1 class="container" id="page-title" tabindex="-1" role="heading" aria-level="1"> Add Lessons Learned</h1>
    <hr>
    
    <form method="POST">
      <!-- The project ID needs to be stored also to identify where this review belongs. -->
      
      <div class="row">
        <div class="col-md-2">
          <h4>Lessons Learned:</h4>
        </div>
      </div>

      <textarea name="editor" id="editor" required></textarea>
      <script>
        CKEDITOR.replace( "editor" );
      </script>

      <p class="text-warning">
        To add an image, just drag it into the text area and it will automatically save it to the data that will be stored. 
        Preferably, try to keep images small in size as they will be converted to data and stored in the database.
      </p>
      <p class="text-warning">
        To add a YouTube video:<br>
        1. Copy the Embed code for the video (Right-click the video > Copy embed code)<br>
        2. Click the \'Source\' button in the editor<br>
        3. Add the Embed code<br>
        4. Submit the entry.
      </p>
      <div class="text-right">
        <input class="btn btn-primary" type="submit" value="SUBMIT ENTRY">
      </div>

    </form>
    ';

    parent::Display();
  }

}

?>