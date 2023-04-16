<?php

protectAdmin();

class AdminMenu extends Page
{
  
  //------------------------- Attributes -------------------------
  private $db = null;

  public $content = '';
  public $title = "CannaLogs - Admin Menu";
  public $keywords = "CannaLogs, admin menu";
  
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
   * Display - Displays the full page
   *
   * @param  mixed $filter
   *
   * @return void
   */
  public function Display()
  {
    // Set the page header
    $this->content .= '
    <h1 id="page-title" tabindex="-1" role="heading" aria-level="1">Admin Menu</h1>
      <hr>
    ';

    $this->content .= '
      <div class="panel panel-default">
        <!-- Default panel contents -->
        <div class="panel-heading"><p>Welcome ' . $_SESSION['fname'] . ' ' . $_SESSION['mname'] . ' ' . $_SESSION['lname'] . '!</p></div>
        <div class="panel-body">
          <p>
            Being an Administrator gives you plenty of control and power over the information
            that is received and managed by this web application for your organization.
          </p>
          <p>
            Please read about the different options available to you if this is your first time.
          </p>
        </div>
      </div>

      <!-- Table -->
      <table class="table">

        <thead>
          <tr>
          <th>Option</th>
          <th>Description</th>
          <tr>
        </thead>

        <tr>
          <td><a href="index.php" style="cursor:pointer;">Announcements</a></td>
          <td>
            Use this option to manage the announcements of your Organization:
            <ul>
              <li>Create</li>
              <li>Delete</li>
              <li>Edit
            </ul>
          </td>
        </tr>

        <tr>
          <td><a href="index.php?display=MyProjects" style="cursor:pointer;">My Projects</a></td>
          <td>
            Use this option to manage your own projects:
            <ul>
              <li>Create</li>
              <li>Delete</li>
              <li>Edit</li>
              <li>Mark Failed</li>
              <li>Mark Cancelled</li>
              <li>Mark Success</li>
              <li>Add Harvest Review</li>
              <li>Add Lessons Learned</li>
              <li>Add Feed/Observation Logs</li>
            </ul>
          </td>
        </tr>
        
        <tr>
          <td><a href="index.php?display=AdminUsers" style="cursor:pointer;">Users</a></td>
          <td>
            Use this option to manage the users of your Organization:
            <ul>
              <li>Add</li>
              <li>Remove</li>
              <li>Edit
            </ul>
          </td>
        </tr>

        <tr>
          <td><a href="setup.php" style="cursor:pointer;">Reset System</a></td>
          <td>
            Use this option to completely erase the database and start from scratch.  The system will have an admin user:
            <ul>
              <li><b>Username</b>: administrator</li>
              <li><b>Password</b>: password</li>
            </ul>
          </td>
        </tr>

      </table>
    ';

    parent::Display();
  }

}

?>