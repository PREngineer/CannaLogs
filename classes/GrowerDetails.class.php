<?php

class GrowerDetails extends Page
{
  
  //------------------------- Attributes -------------------------
  private $db = null;

  public $content = "";
  public $title = "CannaLogs - Grower Details";
  public $keywords = "CannaLogs, grower details";
  
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
   * getMyProjects - Returns the grower's Projects.
   *
   * @return array
   */
  private function getMyProjects( $id )
  {
    return $this->db->query_DB("SELECT *
                                FROM Projects
                                WHERE growerid = '$id'
                              ");
  }

  /**
   * getProjectStatus - Returns the grower's Projects status.
   *
   * @return array
   */
  private function getProjectStatus( $id )
  {
    return ( $this->db->query_DB("SELECT COUNT(CASE WHEN projectstatus = 'In Progress' THEN 1 END) InProgress,
                                         COUNT(CASE WHEN projectstatus = 'Succeeded' THEN 1 END) Succeeded,
                                         COUNT(CASE WHEN projectstatus = 'Failed' THEN 1 END) Failed,
                                         COUNT(CASE WHEN projectstatus = 'Cancelled' THEN 1 END) Cancelled,
                                         COUNT(id) Total
                                FROM Projects
                                WHERE growerid = '$id'
                              ") )[0];
  }

  /**
   * getGrowerDetails - Returns the grower's details.
   *
   * @return array
   */
  private function getGrowerDetails( $id )
  {
    return ( $this->db->query_DB("SELECT fname, mname, lname, username, role
                                FROM Users
                                WHERE id = '$id'
                              ") )[0];
    
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
    $data   = $this->getMyProjects( $_GET['id'] );
    $grower = $this->getGrowerDetails( $_GET['id'] );
    $projectstats = $this->getProjectStatus( $_GET['id'] );
    
    // Set the page header
    $this->content .= '
      <ol class="breadcrumb">
        <li><a href="index.php?display=Growers">Growers</a></li>
        <li><a href="#">' . $grower['username'] . '</a></li>
      </ol>
      <h1 id="page-title" tabindex="-1" role="heading" aria-level="1"> Grower Profile:&nbsp;&nbsp;&nbsp;&nbsp;
      <span class="glyphicon glyphicon-hand-right text-info" style="font-size: 24px;"></span>
      <span class="text-info">' . $grower['username'] . '</span>
      <span class="glyphicon glyphicon-hand-left text-info" style="font-size: 24px;"></span></h1>
      <hr>
    ';

    $this->content .= '
      <table class="table">
        <tr>
          <td style="width: 33%">
            <b>Full Name: </b>' . 
            $grower['fname'] . ' ' . $grower['mname'] . ' ' . $grower['lname'] . '
          </td>
          <td style="width: 33%">
          </td>
          <td style="width: 33%">
            <b>Platform Role: </b>';
            if( $grower['role'] == 0 )
            {
              $this->content .= 'Administrator';
            }
            else if( $grower['role'] == 1 )
            {
              $this->content .= 'Contributor';
            }
            $this->content .= '
          </td>
        </tr>
        <tr>
          <td colspan="3" class="text-center text-muted">
            <h3>Project Statistics</h3>
          </td>
        </tr>
        <tr>
          <td>
            <b>In Progress Projects:</b> <span class="glyphicon glyphicon-hand-right text-info"></span> ' . $projectstats['InProgress'] . ' (' . round( ( $projectstats['InProgress']/$projectstats['Total'] ) * 100 ) . '%)
          </td>
          <td>
          </td>
          <td>
            <b>Successful Projects:</b> <span class="glyphicon glyphicon-thumbs-up text-success"></span> ' . $projectstats['Succeeded'] . ' (' . round( ( $projectstats['Succeeded']/$projectstats['Total'] ) * 100 ) . '%)
          </td>
        </tr>
        <tr>
          <td>
            <b>Failed Projects:</b> <span class="glyphicon glyphicon-thumbs-down text-danger"></span> ' . $projectstats['Failed'] . ' (' . round( ( $projectstats['Failed']/$projectstats['Total'] ) * 100 ) . '%)
          </td>
          <td>
          </td>
          <td>
          <b>Cancelled Projects:</b> <span class="glyphicon glyphicon-remove text-danger"></span> ' . $projectstats['Cancelled'] . ' (' . round( ( $projectstats['Cancelled']/$projectstats['Total'] ) * 100 ) . '%)
          </td>
        </tr>
      </table>

      <h3 class="text-center text-muted">' . $grower['username'] . '\'s Projects</h3>
    ';

    // Process the data into blocks
    if( sizeof( $data ) >= 0 )
    {
      $this->content .= '
      <table class="table sortable">

        <thead>

          <tr>';

        if( $_SESSION['userID'] == $_GET['id'] )
        {
          $this->content .= '
            <th>
              Options
            </th>';
        }

        $this->content .= '
            <th style="cursor: pointer">
              Project Name
            </th>

            <th style="cursor: pointer">
              Project Status
            </th>
      
            <th style="cursor: pointer">
              Strain(s)
            </th>
      
            <th style="cursor: pointer">
              Location
            </th>

            <th style="cursor: pointer">
              Medium
            </th>

            <th style="cursor: pointer">
              Purpose
            </th>

            <th style="cursor: pointer">
              Start Date
            </th>

            <th style="cursor: pointer">
              Harvest Date
            </th>
      
          </tr>

        </thead>
      
        <tbody>';

        foreach( $data as $entry )
        {
          $this->content .= '
          <tr>
          ';

          if( $_SESSION['userID'] == $_GET['id'] )
          {
            $this->content .= '
            <td>
              <a href="?display=EditProject&id=' . $entry['id'] . '"><i class="glyphicon glyphicon-edit" title="Edit Project" style="color:orange"></i></a>&nbsp;&nbsp;
              <a href="?display=DeleteProject&id=' . $entry['id'] . '"><i class="glyphicon glyphicon-trash" title="Delete Project" style="color:red"></i></a>&nbsp;&nbsp;
              <a href="index.php?display=CreateGrowLog&id=' . $entry['id'] . '"><i class="glyphicon glyphicon-book" title="Add Feed/Observation Log"></i></a>
            </td>';
          }

          $this->content .= '
            <td>
              <a href="?display=ProjectDetails&id=' . $entry['id'] . '">' . $entry['projectname'] . '</a>
            </td>

            <td>
              ' . $entry['projectstatus'] . '
            </td>

            <td>
            ' . str_replace( ",", "<br>", $entry['plantstrains'] ) . '
            </td>
            
            <td>
              ' . $entry['location'] . '
            </td>

            <td>
              ' . $entry['medium'] . '
            </td>
            
            <td>
              ' . $entry['purpose'] . '
            </td>
            
            <td>
              ' . $entry['startdate'] . '
            </td>
            
            <td>
              ' . $entry['harvestingdate'] . '
            </td>
            
          </tr>
          ';
        }

        $this->content .= '
        </tbody>
      </table>';
    }
    else
    {
      $this->content .= '
      <div class="container">
        <h2>There are no Projects to show.</h2>
      </div>
      ';
    }

    parent::Display();
  }

}

?>