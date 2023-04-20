<?php

class AnnouncementsBlock
{
  //------------------------- Attributes -------------------------
  
  public $ID        = null;
  public $Title     = null;
  public $Contents  = null;
  public $Poster    = null;
  public $DateTime  = null;

  public $content   = null;
  
  //------------------------- Operations -------------------------
  
  public function __construct( $data )
  {
    $this->ID       = $data['id'];
    $this->Title    = $data['title'];
    $this->Contents = $data['content'];
    $this->Poster   = $data['username'];
    $this->DateTime = $data['datetime'];
  }

  /**
   * Display - Returns the HTML of the Announcement Blocks
   *
   * @return string
   */
  public function Display()
  {
    $this->content = '
            <div id="' . $this->ID . '" class="col-lg-11 container thumbnail">
    ';
    
    if( ( $_SESSION['userRole'] !== NULL ) && ( $_SESSION['userRole'] == 0 ) )
    {
      $this->content .= '<a href="index.php?display=EditAnnouncement&id=' . $this->ID . '"><span class="glyphicon glyphicon-pencil text-success" title="Edit Announcement"></span> Edit</a>
      &nbsp;
      <a href="index.php?display=DeleteAnnouncement&id=' . $this->ID . '"><span class="glyphicon glyphicon-trash text-danger" title="Delete Announcement"></span> Delete</a>';
    }
    
    $this->content .= '
              <table role="presentation" class="table">
                <tr>
                  <td style="width: 50%" class="text-muted text-left">
                    Posted: ' . $this->DateTime . '
                  </td>
                  <td class="text-muted text-right">
                    By: ' . $this->Poster . '
                  </td>
                </tr>

                <tr>
                  <td colspan="2" class="text-center panel-heading bg-success">
                    <h3><b>' . $this->Title . '</b></h3>
                  </td>
                </tr>
                <tr>
                  <td colspan="2">' . $this->Contents . '</td>
                </tr>
              </table>
            </div>
           ';
    
    return $this->content;
  }

}

?>