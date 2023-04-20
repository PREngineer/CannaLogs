<?php

class Register extends Page
{
  
  //------------------------- Attributes -------------------------
  private $db      = null;
  public $content  = '';
  public $title    = "CannaLogs - Register";
  public $keywords = "CannaLogs, register";
  
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
    header( 'Location: index.php?display=Login' );
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
    $user  = $posted['username'];
    $email = $posted['email'];
    $pass  = hash( 'sha256', SHA1( MD5( $posted['password'] ) ) );
    $fname = $posted['fname'];
    $mname = $posted['mname'];
    $lname = $posted['lname'];
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
      <li><a href="index.php?display=Growers">Growers</a></li>
      <li><a href="#">Register</a></li>
    </ol>
    <h1 id="page-title" tabindex="-1" role="heading" aria-level="1">Register An Account</h1>
    
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

      <input type="hidden" name="role" value="1">
      
      <br>

      <div class="row text-right">
        <div class="col-md-1 text-left">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" required>
              </span>
              <span class="form-control"><i style="cursor: pointer; color: blue" data-toggle="modal" data-target="#TOS">TOS</i></span>
            </div>
          </div>
        </div>
        
        <div class="col-md-8 text-left">
          <div class="form-group">
            <div class="input-group"> 
              <div class="form-control">
          In order to register an account you must agree to our Terms Of Service.<br>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Modal -->
        <div class="modal fade text-left" id="TOS" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="SCROGModalLabel">Terms Of Service</h4>
              </div>
              <div class="modal-body">
                <p>We built this application to help the community to document and learn with their cannabis grow projects. These terms govern your use of the
                CannaLogs platform, or any other services provided by Jorge Pabon.</p>
                <p>We don\'t charge you to use CannaLogs or any related service. We might receive payment from businesses or organizations to show you ads 
                that could be of interest to you. We use your data to help determine which ads to show you and how to improve the services provided. We don\'t sell 
                your <b>personal data</b> to anyone.  In fact we try to minimize the amount of personal data collected in the platform. However, any data that you enter and is
                determined to be publishable may be used by us in order to promote the platform and generate revenue.</p>
                
                <h4>Services Provided</h4>
                <p>We strive to provide you with the following services to the best of our ability:</p>
                <ul>
                  <li>A platform to keep track of your growth projects.</li>
                  <li>A platform to share your knowledge with others.</li>
                  <li>A platform to express yourself and communicate about your cannabis interests.</li>
                  <li>A platform to discover knowledge, content, products, and services that may interest you.</li>
                  <li>Enable global access to our services.</li>
                </ul>
                
                <h4>How Our Services Are Funded</h4>
                <p>This project is provided using personal funds, and is hosted in personal equipment. However, we might generate revenue to cover these expenses via 
                advertisements and donations. A Bitcoin QRCode and a PayPal donation like are located in the footer section of the pages. Given the small amount of data 
                that we collect, the advertisements displayed might not be well tailored to your interest, but we try our best. Donations really help us maintain this 
                project going.</p>
                
                <h4>Your Commitments</h4>
                <p>In exchange for these services you agree to:
                  <ul>
                    <li>Be respectful of us and other users of the platform.</li>
                    <li>In order to protect your data, you will not share your account with anyone.</li>
                    <li>Be of legal age in your state/country to engage in cannabis related actions.</li>
                    <li>Comply with all laws and regulations in your state/country and assume any responsibility for any content posted that goes against the laws and regulations
                    of your state/country.</li>
                    <li>Not post any content that is unlawful, misleading, fraudulent, discriminatory, or infringes on the rights of someone else.</li>
                    <li>Not upload viruses or malicious files or code that could disable, overburden, or impair the proper working or appearance of our platform.</li>
                    <li>Not collect data from our platform or attempt to access data to which you don\'t have access.</li>
                    <li>Accept that we can remove content that you shared in violation of our Terms Of Service.</li>
                    <li>Support the community by reporting any content or conduct that you believe violates your rights or our terms.</li>
                  </u>
                </p>
                
                <h4>Permissions you grant us</h4>
                <p>By using the platform you grant us the rights to:
                  <ul>
                    <li>Use the content that you create and share</li>
                    <p>You grant us permission to host, use, distribute, modify, run, copy, publicly perform or display, translate, create derivative works of, sell, share, 
                    promote, and advertise materials that you post such as, videos, pictures, text, etc.</p>
                    <li>You grant us permission to use your Name if we deem to promote or advertise your content.  For example, to give you credit for your content.</li>
                    <li>You grant us permission to update the software where available.</li>
                  </u>
                </p>

                <h4>Additional Provisions</h4>
                <p>We may need to update our Terms Of Service at any time to accurately reflect our services and practices.</p>
                <p>We can suspend or terminate your account if we determine that you have clearly, seriously or repeatedly breached our Terms Of Service or we are required 
                to do so for legal reasons.</p>

                <h4>Limits On Liability</h4>
                <p>Our platform is provided "as is" and we make no guarantees that they will always will be safe, secure, error-free, or that they will function without 
                disruptions, delays, or imperfections. To the extent permitted by law, we also DISCLAIM ALL WARRANTIES, WHETHER EXPRESS OR IMPLIED, INCLUDING THE IMPLIED 
                WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULA PURPOSE, TITLE, AND NON-INFRINGEMENT.  We do not control or direct what people and others do or say, 
                and we are not responsible for their actions or conduct (whether online or offline) or any content they share (including offensive, inappropriate, obscene, 
                unlawful, and other objectionable content).</p>
                <p>We cannot predict when issues might arise with our platform. Accordingly, our liability shall be limited to the fullest extent permitted by applicable law, 
                and under no circumstance will we be liable to you for any lost profits, revenues, information, or data, or consequential, special, indirect, exemplary, punitive, 
                or incidental damages arising out of or related to these terms or the platform, even if we have been advised of the possibility of such damages. Our aggregate 
                liability arising out of or relating to these terms will not exceed twenty USD.</p>

                <h4>Terms</h4>
                <p>
                  <ul>
                    <li>We, us, our, ours: refers to Jorge Pabon or any business belonging to or partnered with Jorge Pabon.</li>
                  </ul>
                  <br>
                  March 17, 2022
                </p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>

        <input class="btn btn-primary text-right" type="submit" value="SUBMIT ENTRY">
      </div>
    </form>
    ';

    parent::Display();
  }

}

?>