<?php

class Growers extends Page
{
  
  //------------------------- Attributes -------------------------
  private $db       = null;
  public $content  = '';
  public $title    = "CannaLogs - Growers";
  public $keywords = "CannaLogs, growers";
  
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
   * getProjectStatus - Returns the grower's Projects status.
   *
   * @return array
   */
  private function getData()
  {
    return $this->db->query_DB("SELECT P.growerid, U.username,
                                COUNT(CASE WHEN P.projectstatus = 'In Progress' THEN 1 END) InProgress,
                                COUNT(CASE WHEN P.projectstatus = 'Success' THEN 1 END) Success,
                                COUNT(CASE WHEN P.projectstatus = 'Failed' THEN 1 END) Failed,
                                COUNT(CASE WHEN P.projectstatus = 'Cancelled' THEN 1 END) Cancelled,
                                COUNT(P.id) Total
                                FROM Projects P, Users U
                                WHERE P.growerid = U.id
                                GROUP BY P.growerid");
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
    $data = $this->getData();

    // Set the page header
    $this->content .= '
      <h1 id="page-title" tabindex="-1" role="heading" aria-level="1">Active Growers</h1>
      <hr>
    ';
    
    // Process the data into blocks
    if( sizeof( $data ) >= 0 )
    {
      $this->content .= '
      <table class="table sortable">
        <thead>
          <tr>
      
            <th style="cursor: pointer">
              Username
            </th>
      
            <th style="cursor: pointer">
              Total Projects
            </th>

            <th style="cursor: pointer">
              Successful Projects
            </th>

            <th style="cursor: pointer">
              Failed Projects
            </th>

            <th style="cursor: pointer">
              Cancelled Projects
            </th>

            <th style="cursor: pointer">
              In Progress Projects
            </th>
      
          </tr>
        </thead>
      
        <tbody>';

      foreach( $data as $entry )
      {
        $this->content .= '
        <tr>
          <td>
            <a href="?display=GrowerDetails&id=' . $entry['growerid'] . '">' . $entry['username'] . '</a>
          </td>
          <td class="text-warning">
            ' . $entry['Total'] . '
          </td>
          <td>
            ' . $entry['Success'] . ' <span class="glyphicon glyphicon-thumbs-up text-success"></span> 
          </td>
          <td>
            ' . $entry['Failed'] . ' <span class="glyphicon glyphicon-thumbs-down text-danger"></span> 
          </td>
          <td>
            ' . $entry['Cancelled'] . ' <span class="glyphicon glyphicon-remove text-danger"></span> 
          </td>
          <td>
            ' . $entry['InProgress'] . ' <span class="glyphicon glyphicon-hand-right text-info"></span> 
          </td>
        </tr>';
      }

      $this->content .= '
        </tbody>
      </table>';
    }
    else
    {
      $this->content .= '
      <div class="container">
        <h2>There are no Users to show.</h2>
      </div>
      ';
    }

    parent::Display();
  }

}

?>