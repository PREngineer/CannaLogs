<?php

/*
How to use it:
    $text = new EditAnnouncementBlock();
    $text->Display();
 */

class EditAnnouncementBlock extends Page
{
  
  //------------------------- Attributes -------------------------
  public $content = '';
  public $title   = '';
  
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
   * getData - Retrieves the data from the database.
   *
   * @param  String $id
   *
   * @return String
   */
  private function getData( $id )
  {
    // Make change in the database
    $data = $this->db->query_DB("SELECT title, content
                                 FROM Announcements
                                 WHERE id = '$id'");
    
    return $data[0];
  }

  /**
   * Display - Displays the text editor widget
   *
   * @param  None
   *
   * @return void
   */
  public function Display()
  {
    // Get the database data
    $data    = $this->getData( $_GET['id'] );
    $title   = $data['title'];
    $content = $data['content'];
        
    // Define the content
    $this->content .= '
    <form method="POST">
      <div class="input-group">
        <span class="input-group-addon"">Announcement Title</span>
        <input type="text" class="form-control" name="title" value="'; 
    
    // If posted, let's use that instead.
    if( isset( $_POST['title'] ) )
    {
      $this->content .= $_POST['title'];
    }
    else
    {
      $this->content .= $title;
    }

      $this->content .= '" required>
      </div>
      <br>
      <textarea name="editor" id="editor">';
      
      // If posted, let's use that instead.
      $this->content .= $content;
      
      $this->content .= '</textarea>
      <script>
              CKEDITOR.replace( "editor" );
      </script>

      <p class="text-warning">To add an image, just drag it into the text area and it will automatically save it to the data that will be stored. 
      Preferably, try to keep images small in size as they will be converted to data and stored in the database.</p>
      <div class="text-right">
        <input class="btn btn-primary" type="submit" value="SUBMIT ENTRY">
      </div>

    </form>
    ';

    return $this->content;
  }

}

?>