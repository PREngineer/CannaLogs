<?php

class Login extends Page
{
  
  //------------------------- Attributes -------------------------
  private $db = null;

  public $content = '';
  public $title = "CannaLogs - Login";
  public $keywords = "CannaLogs, login";
  
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
    
    $success = $this->login( $posted );
    
    if( $success === True )
    {
      $this->content .= '
      <div class="container alert alert-success alert-dismissible text-center" role="alert"">
        <button type = "button" class="close" data-dismiss="alert">x</button>
          Success!
      </div>
      ';

      $this->setupCookie( $posted );

      if( $_SESSION['userRole'] == '0' )
      {
        $this->content .= '
        <script>
          window.location = "index.php?display=AdminMenu";
        </script>
        ';
      }
      if( $_SESSION['userRole'] == '1' )
      {
        $this->content .= '
        <script>
          window.location = "index.php?display=MyProjects";
        </script>
        ';
      }
    }
    else
    {
      $this->content .= '
      <div class="container alert alert-danger alert-dismissible text-center" role="alert"">
        <button type="button" class="close" data-dismiss="alert">x</button>
        Login Failure!
        <hr>
        ' . $success . '
      </div>';
    }
  }

  /**
   * login - Handles the login validation when using in App authentication.
   *
   * @param  mixed $posted
   *
   * @return void
   */
  private function login( $posted )
  {
    // Encrypt password with MD5->SHA1->SHA256
    $password = hash( 'sha256', SHA1( MD5( $posted['password'] ) ) );

    // Check if the username & password combination exists
    $check = $this->db->query_DB("SELECT COUNT(username) as Count
                                  FROM Users
                                  WHERE username = '" . $posted['username'] . "'
                                  AND password   = '" . $password           . "'");
    
    if( $check[0]['Count'] == 1 )
    {
      return True;
    }
    else
    {
      return 'The combination provided is incorrect.';
    }
  }

  /**
   * setupCookie - Create the cookie for this session.
   *
   * @param  mixed $data
   *
   * @return void
   */
  private function setupCookie( $data )
  {
    // Get the user's details
    $check = $this->db->query_DB("SELECT *
                                  FROM Users
                                  WHERE username = '" . $data['username'] . "'")[0];

    // Initialize the session
    if( !isset( $_SESSION ) )
    {
      session_start();
    }
    
    $_SESSION['userID']     = $check['id'];
    $_SESSION['userName']   = $check['username'];
    $_SESSION['userRole']   = $check['role'];
    $_SESSION['fname']      = $check['fname'];
    $_SESSION['mname']      = $check['mname'];
    $_SESSION['lname']      = $check['lname'];

    // Extend cookie life time
    // A month in seconds = 30 days * 24 hours * 60 mins * 60 secs
    $cookieLifetime = 30 * 24 * 60 * 60;
    setcookie("CannaLogs", session_id(), time() + $cookieLifetime);

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
    // Handle data and give feedback
    if( isset( $_POST['username'] ) )
    {
      $this->handlePOST( $_POST );
    }

    // Set the page header
    $this->content .= '
      <h1 class="container" id="page-title" tabindex="-1" role="heading" aria-level="1">Login</h1>
      <hr>
    ';

    $this->content .= '
    <!-- Form STARTS here -->
    <form class="container" method="POST" id="loginPage">

      <p><strong>All fields marked with an asterisk ( <span class="text-danger">*</span> ) are required. </strong></p>

      <div class="form-group">
        <label for="username"> <span class="text-danger">*</span> Enterprise ID</label>
        <div class="input-group">
          <span class="input-group-addon">
            <i class="glyphicon glyphicon-user"></i>
          </span>
          <input name="username" type="text" class="form-control" id="username" placeholder="john.p.doe" aria-describedby="usernameHelp" required>
        </div>
        <small id="usernameHelp" class="sr-only form-text text-muted">Use your enterprise ID only, don\'t include "@company.com"</small>
      </div>

      <div class="form-group">
        <label for="Password"> <span class="text-danger">*</span> Password</label>
        <div class="input-group">
          <span class="input-group-addon">
            <i class="glyphicon glyphicon-lock"></i>
          </span>
          <input name="password" type="password" class="form-control" id="password" placeholder="password" required>
        </div>
      </div>

      <!--Login Button-->
      <div>
        <input class="btn btn-primary" type="submit" value="Submit">
      </div>

    </form>

    <div class="container">
      <p>Don\'t have an account? Register <a href="index.php?display=Register">here</a>!</p>
    </div>

    <!-- ******************* END FORM ******************* -->

    <script type="text/javascript">
      $(document).ready(function()
      {
        $(\'#loginPage\').bootstrapValidator({
            // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
            feedbackIcons:
            {
                valid: \'glyphicon glyphicon-ok\',
                invalid: \'glyphicon glyphicon-remove\',
                validating: \'glyphicon glyphicon-refresh\'
            },
            fields:
            {
                username:
                {
                    validators:
                    {
                        notEmpty:
                        {
                            message: \'ERROR: Please enter your Enterprise ID.\'
                        }
                    }
                },
                password:
                {
                    validators:
                    {
                        notEmpty:
                        {
                            message: \'ERROR: Please enter your password.\'
                        }
                    }
                },
            }
          })

          // POST if everything is OK
          .on(\'success.form.bv\', function(e)
          {
                // Prevent form submission
                e.preventDefault();

                // Get the form instance
                var $form = $(e.target);

                // Get the BootstrapValidator instance
                var bv = $form.data(\'bootstrapValidator\');

                // Use Ajax to submit form data
                $.post($form.attr(\'display\'), $form.serialize(), function(result)
                {
                    console.log(result);
                }, \'json\');
          });
      });
    </script>

    ';

    parent::Display();
  }

}

?>