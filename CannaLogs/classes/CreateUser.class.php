<?php

protectAdmin();

class CreateUser extends Page
{
  
  //------------------------- Attributes -------------------------
  private $db      = null;
  public $content  = '';
  public $title    = "CannaLogs - Create User";
  public $keywords = "CannaLogs, create user";
  
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
   * handlePOST - Takes control of the action once the form is posted.
   *
   * @param  mixed $posted
   *
   * @return void
   */
  private function handlePOST( $posted )
  {
    
    $success = $this->create( $posted );
    
    // Redirect to list of Users
    header( 'Location: index.php?display=AdminUsers' );
  }

  /**
   * create - Stores the entry in the database.
   *
   * @param  String $posted
   *
   * @return True|String
   */
  private function create( $posted )
  {
    $user  = $this->db->sanitize( $posted['username'] );
    $email = $this->db->sanitize( $posted['email'] );
    $pass  = hash( 'sha256', SHA1( MD5( $posted['password'] ) ) );
    $fname = $this->db->sanitize( $posted['fname'] );
    $mname = $this->db->sanitize( $posted['mname'] );
    $lname = $this->db->sanitize( $posted['lname'] );
    $role  = $posted['role'];
    
    // Make change in the database
     $check = $this->db->query_DB("INSERT INTO Users
                                   (username, email, password, fname, mname, lname, role)
                                   VALUES ('$user', '$email', '$pass', '$fname', '$mname', '$lname', '$role')"
                                 );
    return True;
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
    // Handle data
    if( isset( $_POST['username'] ) )
    {
      $this->handlePOST( $_POST );
    }
    
    // Set the page header
    $this->content .= '
    <ol class="breadcrumb">
      <li><a href="index.php?display=AdminMenu">Admin Menu</a></li>
      <li><a href="index.php?display=AdminUsers">Users</a></li>
      <li><a href="#">Create User</a></li>
    </ol>
    <h1 id="page-title" tabindex="-1" role="heading" aria-level="1">Create User</h1>
    
    <form class="container" method="POST">

      <p><strong> Note: All fields marked with an asterisk ( <span class="text-danger">*</span> ) are required. </strong></p>

      <div class="form-group">
        <label for="username">
        <span class="text-danger">*</span> Username:
        </label>
        <div class="input-group">
          <span class="input-group-addon">
            <i class="glyphicon glyphicon-tag"></i>
          </span>
          <input name="username" type="text" class="form-control" placeholder="user.name" aria-describedby="usernameHelp" required>
        </div>
          <small id="usernameHelp" class="form-text text-muted">The new user\'s username.</small>
      </div>

      <div class="form-group">
        <label for="email">
        <span class="text-danger">*</span> E-mail:
        </label>
        <div class="input-group">
          <span class="input-group-addon">
            <i class="glyphicon glyphicon-tag"></i>
          </span>
          <input name="email" type="email" class="form-control" placeholder="user@mail.tld" aria-describedby="emailHelp" required>
        </div>
          <small id="emailHelp" class="form-text text-muted">The new user\'s email.</small>
      </div>

      <div class="form-group">
        <label for="password">
        <span class="text-danger">*</span> Password:
        </label>
        <div class="input-group">
          <span class="input-group-addon">
            <i class="glyphicon glyphicon-lock"></i>
          </span>
          <input name="password" type="password" class="form-control" placeholder="password" aria-describedby="passwordHelp" required>
        </div>
          <small id="passwordHelp" class="form-text text-muted">The new user\'s password.</small>
      </div>

      <div class="form-group">
        <label for="fname">
        <span class="text-danger">*</span> First Name:
        </label>
        <div class="input-group">
          <span class="input-group-addon">
            <i class="glyphicon glyphicon-user"></i>
          </span>
          <input name="fname" type="text" class="form-control" placeholder="John" aria-describedby="fnameHelp" required>
        </div>
          <small id="fnameHelp" class="form-text text-muted">The new user\'s first name.</small>
      </div>

      <div class="form-group">
        <label for="mname">
          Middle Name:
        </label>
        <div class="input-group">
          <span class="input-group-addon">
            <i class="glyphicon glyphicon-user"></i>
          </span>
          <input name="mname" type="text" class="form-control" placeholder="Xavier" aria-describedby="mnameHelp">
        </div>
          <small id="mnameHelp" class="form-text text-muted">The new user\'s middle name or initial.</small>
      </div>

      <div class="form-group">
        <label for="lname">
        <span class="text-danger">*</span> Last Name(s):
        </label>
        <div class="input-group">
          <span class="input-group-addon">
            <i class="glyphicon glyphicon-user"></i>
          </span>
          <input name="lname" type="text" class="form-control" placeholder="Doe" aria-describedby="lnameHelp" required>
        </div>
          <small id="lnameHelp" class="form-text text-muted">The new user\'s last name(s).</small>
      </div>

      <div class="form-group">
        <label for="level"><span class="text-danger">*</span> Role</label>
        <div class="input-group">
          <span class="input-group-addon">
            <i class="glyphicon glyphicon-th-list"></i>
          </span>
        <select name="role" class="form-control" id="role" required>
          <option></option>
          <option value="0">Administrator</option>
          <option value="1">Contributor</option>
      </select>
      </div>
      
      <br>

      <div class="text-right">
        <input class="btn btn-primary" type="submit" value="SUBMIT ENTRY">
      </div>
    </form>
    ';

    parent::Display();
  }

}

?>