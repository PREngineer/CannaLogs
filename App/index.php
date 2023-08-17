<?php

/**
 * This file checks if the user has a session and protects pages from 
 * unauthorized use.
 */

require_once 'init.php';

/**
 * This file will load the appropriate class depending on the request type.
 */

require_once 'autoloader.php';

echo '<br><br><br>';

/****************
    If app has not been configured
****************/
// echo '
//     <script>
//       window.location = "setup.php";
//     </script>
//   ';

/****************
    Top Pages
****************/

// Handle Base Load
if( !isset( $_GET['display'] ) || $_GET['display'] === 'Announcements' )
{
    $page = new Announcements();
    $page->Display();
}
// Handle Login
else if( isset( $_GET['display'] ) && $_GET['display'] === 'Login' )
{
    $page = new Login();
    $page->Display();
}
// Handle Logout
else if( isset( $_GET['display'] ) && $_GET['display'] === 'Logout' )
{
  unset( $_SESSION );
  session_destroy();

  echo '
    <script>
      window.location = "index.php";
    </script>
  ';
}
// Handle Projects
else if( isset( $_GET['display'] ) && $_GET['display'] === 'Projects' )
{
    $page = new Projects();
    $page->Display();
}
// Handle Reports
else if( isset( $_GET['display'] ) && $_GET['display'] === 'Reports' )
{
    $page = new Reports();
    $page->Display();
}

/****************
    Admin Pages
****************/

// Handle Admin Menu
else if( $_GET['display'] === 'AdminMenu' )
{
    $page = new AdminMenu();
    $page->Display();
}
// Handle Create Announcement
else if( $_GET['display'] === 'CreateAnnouncement' )
{
    $page = new CreateAnnouncement();
    $page->Display();
}
// Handle Edit Announcement
else if( $_GET['display'] === 'EditAnnouncement' )
{
    $page = new EditAnnouncement();
    $page->Display();
}
// Handle Delete Announcement
else if( $_GET['display'] === 'DeleteAnnouncement' )
{
    $page = new DeleteAnnouncement();
    $page->Display();
}
// Handle Admin Users
else if( $_GET['display'] === 'AdminUsers' )
{
    $page = new AdminUsers();
    $page->Display();
}
// Handle Create User
else if( $_GET['display'] === 'CreateUser' )
{
    $page = new CreateUser();
    $page->Display();
}
// Handle Edit User
else if( $_GET['display'] === 'EditUser' )
{
    $page = new EditUser();
    $page->Display();
}
// Handle Delete User
else if( $_GET['display'] === 'DeleteUser' )
{
    $page = new DeleteUser();
    $page->Display();
}

/****************
    Admin & Contributor Pages
****************/

// Handle Create Project
else if( $_GET['display'] === 'CreateProject' )
{
    $page = new CreateProject();
    $page->Display();
}
// Handle Edit Project
else if( $_GET['display'] === 'EditProject' )
{
    $page = new EditProject();
    $page->Display();
}
// Handle Delete Project
else if( $_GET['display'] === 'DeleteProject' )
{
    $page = new DeleteProject();
    $page->Display();
}
// Handle Cancel Project
else if( $_GET['display'] === 'CancelProject' )
{
    $page = new CancelProject();
    $page->Display();
}
// Handle Fail Project
else if( $_GET['display'] === 'FailProject' )
{
    $page = new FailProject();
    $page->Display();
}
// Handle Succeed Project
else if( $_GET['display'] === 'SucceedProject' )
{
    $page = new SucceedProject();
    $page->Display();
}
// Handle Create Grow Log
else if( $_GET['display'] === 'CreateGrowLog' )
{
    $page = new CreateGrowLog();
    $page->Display();
}
// Handle Edit Grow Log
else if( $_GET['display'] === 'EditGrowLog' )
{
    $page = new EditGrowLog();
    $page->Display();
}
// Handle Create Project Review
else if( $_GET['display'] === 'CreateProjectReview' )
{
    $page = new CreateProjectReview();
    $page->Display();
}
// Handle Create Lessons Learned
else if( $_GET['display'] === 'CreateLessonsLearned' )
{
    $page = new CreateLessonsLearned();
    $page->Display();
}
// Handle My Projects
else if( $_GET['display'] === 'MyProjects' )
{
    $page = new MyProjects();
    $page->Display();
}

/****************
    Public Pages
****************/

// Handle Project Details
else if( $_GET['display'] === 'ProjectDetails' )
{
    $page = new ProjectDetails();
    $page->Display();
}
// Handle Grower's Profile
else if( $_GET['display'] === 'GrowerDetails' )
{
    $page = new GrowerDetails();
    $page->Display();
}
// Handle Growers
else if( $_GET['display'] === 'Growers' )
{
    $page = new Growers();
    $page->Display();
}
// Handle Register
else if( $_GET['display'] === 'Register' )
{
    $page = new Register();
    $page->Display();
}

echo '<br><br>';

?>
