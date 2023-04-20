<?php

// Initialize the session
session_start();

// If the session's user_id variable doesn't exist, create it NULL
if( array_key_exists( 'userID', $_SESSION ) === false )
{
	$_SESSION['userID'] = null;
}

// If the session's user_id variable doesn't exist, create it NULL
if( array_key_exists( 'userRole', $_SESSION ) === false )
{
	$_SESSION['userRole'] = null;
}

/*
  Function that checks if the user SESSION is active
  - Used all over the place
  @Return - Boolean (T or F) if logged in
*/
function logged_in()
{
  return ( $_SESSION['userID'] !== NULL ) ? true : false;
}

/*
  Function that checks if the user Admin session is active
  - Used all over the place
  @Return - Boolean (T or F) if logged in
*/
function protectAdmin()
{
  if( $_SESSION['userRole'] != '0' || !isset( $_SESSION['userRole'] ) )
  {
    header('Location: index.php?display=Projects');
    exit;
  }
}

/*
  Function that checks if the user Admin or Contributor session is active
  - Used all over the place
  @Return - Boolean (T or F) if logged in
*/
function protectContributor()
{
  if( ( $_SESSION['userRole'] != '0' && $_SESSION['userRole'] != '1' ) || !isset( $_SESSION['userRole'] ) )
  {
    header('Location: index.php?display=Projects');
    exit;
  }
}

?>
