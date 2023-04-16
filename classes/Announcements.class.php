<?php

class Announcements extends Page
{
  
  //------------------------- Attributes -------------------------
  private $db      = null;
  public $content  = '';
  public $title    = "CannaLogs - Announcements";
  public $keywords = "CannaLogs, announcements";
  
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
   * getAll - Returns all of the active announcements.
   *
   * @return array
   */
  private function getAll()
  {
    return $this->db->query_DB("SELECT A.id, A.title, A.content, A.datetime, U.username, U.fname, U.mname, U.lname
                                FROM Announcements A
                                INNER JOIN Users U
                                ON A.poster = U.id
                                ORDER BY datetime DESC
                              ");
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
    // Get the data
    $data = $this->getAll();
    
    if( ( $_SESSION['userRole'] !== NULL ) && ( $_SESSION['userRole'] == 0 ) )
    {
      $this->content .= '
      <ol class="breadcrumb">
        <li><a href="index.php?display=AdminMenu">Admin Menu</a></li>
        <li><a href="#">Announcements</a></li>
      </ol>
      ';
    }
    // Set the page header
    $this->content .= '
      <h1 id="page-title" tabindex="-1" role="heading" aria-level="1">Announcements</h1>
    ';

    if( ( $_SESSION['userRole'] !== NULL ) && ( $_SESSION['userRole'] == 0 ) )
    {
      $this->content .= '
        <a href="index.php?display=CreateAnnouncement" style="cursor:pointer;"><i class="glyphicon glyphicon-plus" title="New Announcement"></i> New Announcement</a>
        <hr>
      ';
    }

    // Process the data into blocks
    if( sizeof( $data ) >= 0 )
    {
      foreach( $data as $entry )
      {
        $block = new AnnouncementsBlock( $entry );
        $this->content .= $block->Display();
      }
    }
    else
    {
      $this->content .= '
      <div class="container">
        <h2>There are no Announcements to show.</h2>
      </div>
      ';
    }

    parent::Display();
  }

}

?>