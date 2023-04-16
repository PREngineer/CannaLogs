<?php

/*
How to use it:
    $text = new CreateAnnouncementBlock();
    $text->Display();
 */

class CreateAnnouncementBlock extends Page
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
   * Display - Displays the text editor widget
   *
   * @param  None
   *
   * @return void
   */
  public function Display()
  {
    // Define the content
    $this->content .= '
    <form method="POST">
      <div class="input-group">
        <span class="input-group-addon">Announcement Title</span>
        <input type="text" class="form-control" name="title" required>
      </div>
      <br>
      <textarea name="editor" id="editor" required></textarea>
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