<?php

/*
How to use it:
    $text = new Wysiwyg();
    $text->Display();
 */

class Wysiwyg extends Page
{
  
  //------------------------- Attributes -------------------------
  public $content = '';
  
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
    // Set the page header
    $this->content .= '
    <form method="POST">

      <textarea name="editor" id="editor" required>';
      
      if( isset($_POST['editor']) )
      {
        $this->$content .= $_POST['editor'];
      }
      
      $this->content .= '</textarea>
      <script>
              CKEDITOR.replace( \'editor\' );
      </script>

      <p class="text-warning">To add an image, just drag it into the text area and it will automatically save it to the data that will be stored. 
      Preferably, try to keep images small in size as they will be converted to data and stored in the database.</p>
      <input class="btn btn-primary" type="submit" value="SUBMIT ENTRY">

    </form>
    ';

    return $this->content;
  }

}

?>