<?php

protectAdmin();

class AdminUsers extends Page
{
  
  //------------------------- Attributes -------------------------
  private $db       = null;
  public $content  = '';
  public $title    = "CannaLogs - Admin Users";
  public $keywords = "CannaLogs, admin users";
  
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
   * getAll - Returns all users.
   *
   * @return array
   */
  private function getAll()
  {
    return $this->db->query_DB("SELECT *
                                FROM Users
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

    // Set the page header
    $this->content .= '
    <ol class="breadcrumb">
      <li><a href="index.php?display=AdminMenu">Admin Menu</a></li>
      <li><a href="#">Users</a></li>
    </ol>
    <h1 id="page-title" tabindex="-1" role="heading" aria-level="1">Users</h1>
    <a href="index.php?display=CreateUser" style="cursor:pointer;"><i class="glyphicon glyphicon-plus" title="New User"></i> New User</a>
    <hr>';
    
    // Process the data into blocks
    if( sizeof( $data ) >= 0 )
    {
      $this->content .= '
      <table class="table">
        <thead>
          <tr>
            <th>
              Options
            </th>
      
            <th>
              Username
            </th>
      
            <th>
              Role
            </th>

            <th>
              First Name
            </th>

            <th>
              Middle Name
            </th>

            <th>
              Last Name(s)
            </th>
      
          </tr>
        </thead>
      
        <tbody>';

      foreach( $data as $entry )
      {
        $this->content .= '
        <tr>
          <td>
            <a href="?display=EditUser&id=' . $entry['id'] . '"><i class="glyphicon glyphicon-edit" title="Edit User" style="color:orange; padding-left:2em"></i></a>
            <a href="?display=DeleteUser&id=' . $entry['id'] . '"><i class="glyphicon glyphicon-trash" title="Delete User" style="color:red; padding-left:2em"></i></a>
          </td>
          <td>
            ' . $entry['username'] . '
          </td>
          <td class="';

        if( $entry['role'] == 0 )
        {
          $this->content .= 'text-danger">Administrator';
        }
        else if( $entry['role'] == 1 )
        {
          $this->content .= 'text-warning">Contributor';
        }

          $this->content .= '
          </td>
          <td>
            ' . $entry['fname'] . '
          </td>
          <td>
            ' . $entry['mname'] . '
          </td>
          <td>
            ' . $entry['lname'] . '
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