<?php

class PageNavBar
{
  //------------------------- Attributes -------------------------
  public $content = null;
    
  //------------------------- Operations -------------------------
  
  /**
   * __construct
   *
   * @return void
   */
  public function __construct()
  {
    
  }
  
  /**
   * Display - Returns the HTML of the NavBar
   *
   * @return string NavBar
   */
  public function Display()
  {
    $this->content .= '
    <div class="container">
      <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container-fluid">
          <!-- Brand and toggle (hamburger) get grouped for better mobile display -->
          <div class="navbar-header">
            <!-- Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapsibleNavbar" aria-expanded="false">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>

            <!-- Brand icon -->
            <a href="index.php" class="navbar-brand">
              <img src="../images/TLogo.png" width="30" height="30" alt="CannaLogs Logo">
            </a>
          </div>

          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="nav navbar-nav">
              <li id="announcementsLink">
                <a href="index.php?display=Announcements">
                <span class="glyphicon glyphicon-exclamation-sign"></span> Announcements
                </a>
              </li>
              <li id="projectsLink">
                <a href="index.php?display=Projects">
                <span class="glyphicon glyphicon-tags"></span> Projects
                </a>
              </li>
              <li id="growersLink">
                <a href="index.php?display=Growers">
                <span class="glyphicon glyphicon-user"></span> Growers
                </a>
              </li>
              <li id="reportsLink">
                <a href="index.php?display=Reports">
                <span class="glyphicon glyphicon-stats"></span> Reports
                </a>
              </li>
            </ul>

            <ul class="nav navbar-nav navbar-right">';

    if( isset( $_SESSION['userRole'] ) && ( $_SESSION['userRole'] == 0 ) )
    {
      $this->content .= '
              <li id="adminLink" class="dropdown">
                <a href="index.php?display=AdminMenu">
                <span class="glyphicon glyphicon-leaf" style="color: red"></span> Administrators
                </a>
              </li>
      ';
    }

    if( isset( $_SESSION['userRole'] ) && ( $_SESSION['userRole'] == 1 ) )
    {
      $this->content .= '
              <li id="myprojectsLink" class="dropdown">
                <a href="index.php?display=MyProjects">
                <span class="glyphicon glyphicon-leaf" style="color: orange"></span> My Projects
                </a>
              </li>
      ';
    }
    
    if( !isset($_SESSION['userRole']) )
    {
      $this->content .= '
              <li id="loginLink">
                <a href="index.php?display=Login" style="cursor: pointer;">
                <span class="glyphicon glyphicon-log-in"></span> Login
                </a>
              </li>
      ';
    }
    else
    {
      $this->content .= '
              <li id="logoutLink">
                <a href="index.php?display=Logout" style="cursor: pointer;">
                <span class="glyphicon glyphicon-log-out"></span> Logout</a>
              </li>
      ';
    }

    $this->content .= '
            </ul>
          </div>
          <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
      </nav>
    </div>


    

    <!-- Handle NavBar Highlights -->
    <script>';

    if( ( isset( $_GET['display'] ) && $_GET['display'] === 'Announcements' ) || 
        !isset( $_GET['display'] ) )
    {
      $this->content .= '
      document.getElementById("announcementsLink").classList.add("active");
      ';
    }
    else
    {
      $this->content .= '
      document.getElementById("announcementsLink").classList.remove("active");
      ';
    }

    if( ( isset( $_GET['display'] ) && $_GET['display'] === 'Growers' ) || 
        ( isset( $_GET['display'] ) && $_GET['display'] === 'GrowerDetails' ) )
    {
      $this->content .= '
      document.getElementById("growersLink").classList.add("active");
      ';
    }
    else
    {
      $this->content .= '
      document.getElementById("growersLink").classList.remove("active");
      ';
    }

    if( ( isset( $_GET['display'] ) && $_GET['display'] === 'Projects' ) || 
        ( isset( $_GET['display'] ) && $_GET['display'] === 'ProjectDetails' ) || 
        ( isset( $_GET['display'] ) && $_GET['display'] === 'EditProject' ) || 
        ( isset( $_GET['display'] ) && $_GET['display'] === 'CreateGrowLog' ) || 
        ( isset( $_GET['display'] ) && $_GET['display'] === 'CreateLessonsLearned' ) || 
        ( isset( $_GET['display'] ) && $_GET['display'] === 'CreateProjectReview' ) )
    {
      $this->content .= '
      document.getElementById("projectsLink").classList.add("active");
      ';
    }
    else
    {
      $this->content .= '
      document.getElementById("projectsLink").classList.remove("active");
      ';
    }

    if( ( isset( $_GET['display'] ) && $_GET['display'] === 'Reports' ) )
    {
      $this->content .= '
      document.getElementById("reportsLink").classList.add("active");
      ';
    }
    else
    {
      $this->content .= '
      document.getElementById("reportsLink").classList.remove("active");
      ';
    }

    if( isset( $_GET['display'] ) && $_GET['display'] === 'Login' )
    {
      $this->content .= '
      document.getElementById("loginLink").classList.add("active");
      ';
    }

    if( ( isset( $_GET['display'] ) && $_GET['display'] === 'AdminMenu' ) && 
        $_SESSION['userRole'] == '0' )
    {
      $this->content .= '
      document.getElementById("adminLink").classList.add("active");
      ';
    }
    else if( ( isset( $_GET['display'] ) && $_GET['display'] !== 'AdminMenu' ) && 
              $_SESSION['userRole'] == '0' )
    {
      $this->content .= '
      document.getElementById("adminLink").classList.remove("active");
      ';
    }

    if( ( isset( $_GET['display'] ) && $_GET['display'] === 'MyProjects' && 
          $_SESSION['userRole'] == '1' ) )
    {
      $this->content .= '
      document.getElementById("myprojectsLink").classList.add("active");
      ';
    }
    else if( ( isset( $_GET['display'] ) && $_GET['display'] !== 'MyProjects' && 
              $_SESSION['userRole'] == '1' ) )
    {
      $this->content .= '
      document.getElementById("myprojectsLink").classList.remove("active");
      ';
    }

    $this->content .= '
    </script>
    
    
    ';

    return $this->content;
  }

}

?>