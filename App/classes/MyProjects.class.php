<?php

class MyProjects extends Page
{
  
  //------------------------- Attributes -------------------------
  private $db = null;

  public $content = "";
  public $title = "CannaLogs - My Projects";
  public $keywords = "CannaLogs, my projects";
  
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
   * getAll - Returns all Projects.
   *
   * @return array
   */
  private function getAll()
  {
    return $this->db->query_DB("SELECT *
                                FROM Projects
                                WHERE growerid = '" . $_SESSION['userID'] . "'
                              ");
  }

  /**
   * getGrowerName - Returns the grower's Full Name.
   *
   * @return array
   */
  private function getGrowerName( $id )
  {
    $data = ( $this->db->query_DB("SELECT username
                                FROM Users
                                WHERE id = '$id'
                              ") )[0];
    return $data['username'];
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
    // If not an admin or contributor, not allowed to view
    if( !isset($_SESSION['userRole']) )
    {
      // Redirect to list of Announcements
      header( 'Location: index.php?display=Projects' );
      return false;
    }

    // Get the data
    $data = $this->getAll();

    // Set the page header
    $this->content .= '
    <h1 id="page-title" tabindex="-1" role="heading" aria-level="1">My Projects</h1>
    <a href="index.php?display=CreateProject" style="cursor:pointer;"><i class="glyphicon glyphicon-plus" title="New Project"></i> New Project</a>
    <hr>';
    
    // Process the data into blocks
    if( sizeof( $data ) >= 0 )
    {
      $this->content .= '
      <table class="table sortable">

        <thead>

          <tr>
            <th style="cursor: pointer">
              Options
            </th>

            <th style="cursor: pointer">
              Project Name
            </th>

            <th style="cursor: pointer">
              Grower
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
          <tr id="ProjectNo' . $entry['id'] . '">
            <td>
              <a href="?display=EditProject&id=' . $entry['id'] . '"><i class="glyphicon glyphicon-edit" title="Edit Project" style="color:orange"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
              <a href="?display=DeleteProject&id=' . $entry['id'] . '"><i class="glyphicon glyphicon-trash" title="Delete Project" style="color:red"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
              <a href="index.php?display=CreateGrowLog&id=' . $entry['id'] . '"><i class="glyphicon glyphicon-book" title="Add Feed/Observation Log"></i></a>
            </td>
            
            <td>
              <a href="?display=ProjectDetails&id=' . $entry['id'] . '">' . $entry['projectname'] . '</a>
            </td>

            <td>
              <a href="?display=GrowerDetails&id=' . $entry['growerid'] . '">' . $this->getGrowerName( $entry['growerid'] ) . '</a>
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
        <h2>There are no Projects to show.</h2>
      </div>
      ';
    }

    parent::Display();
  }

}

?>