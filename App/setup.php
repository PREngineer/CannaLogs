<!DOCTYPE html>
<html lang="en">

  <!-- ******************* Head Section ******************* -->
  <head>
    <!-- Application Name -->
    <title>CannaLogs - Database Setup</title>

    <!-- Encoding and Mobile First -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap core CSS -->
    <link href="theme/css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="theme/css/bootstrap.min.css" rel="stylesheet">
    <link href="theme/css/bootstrap-datepicker3.standalone.min.css" rel="stylesheet">
    <link href="theme/css/bootstrap-datepicker3.min.css" rel="stylesheet">

    <!-- Importing jQuery and other dependencies -->
    <script src="theme/js/jquery-3.2.1.min.js"></script>
    <script src="theme/js/bootstrap-datepicker.min.js"></script>
    <script src="theme/js/BootstrapValidator.min.js"></script>

    <!-- Bootstrap JavaScript -->
    <script src="theme/js/bootstrap.js"></script>
  </head>

  <body>

    <!-- ******************* START FORM ******************* -->
    <div class="container" id="Content" name="Content">

      <h1><img src="images/logo.png" width="150" height="150" alt="CannaLogs Logo"> - Database Setup</h1>

      <form class="container" method="POST" id="setupDBForm">
        <hr>

        <p>
          Please provide the following details to set up the database for the CannaLogs platform.
        </p>

        <div class="alert alert-warning alert-dismissible" role="alert">
          <button type = "button" class="close" data-dismiss = "alert">x</button>
          <b>Important!</b><br><br>
          You must provide a database <b>administrator</b> account.<br><br>
          It will need to <b>create a database and tables</b> and it will set itself as the account to be used
          to work on this Database in the future.
        </div>

        <br>

        <div class="form-group">
          <h4>Admin User Details</h4>
        </div>
        <br>

        <div class="form-group">
          <label for="fname">
            First Name: <label class="text-danger">*</label>
          </label>
          <div class="input-group">
            <span class="input-group-addon">
              <i class="glyphicon glyphicon-user"></i>
            </span>
            <input name="fname" type="text" class="form-control" placeholder="John" aria-describedby="fnameHelp" required>
          </div>
      	   <small id="fnameHelp" class="form-text text-muted">The default platform administrator's first name.</small>
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
      	   <small id="mnameHelp" class="form-text text-muted">The default platform administrator's middle name or initial.</small>
        </div>

        <div class="form-group">
          <label for="lname">
            Last Name(s): <label class="text-danger">*</label>
          </label>
          <div class="input-group">
            <span class="input-group-addon">
              <i class="glyphicon glyphicon-user"></i>
            </span>
            <input name="lname" type="text" class="form-control" placeholder="Doe" aria-describedby="lnameHelp" required>
          </div>
      	   <small id="lnameHelp" class="form-text text-muted">The default platform administrator's last name(s).</small>
        </div>

        <div class="form-group">
          <label for="email">
            E-mail: <label class="text-danger">*</label>
          </label>
          <div class="input-group">
            <span class="input-group-addon">
              <i class="glyphicon glyphicon-user"></i>
            </span>
            <input name="email" type="email" class="form-control" placeholder="something@domain.tld" aria-describedby="emailHelp" required>
          </div>
      	   <small id="emailHelp" class="form-text text-muted">The default platform administrator's e-mail.</small>
        </div>

        <div class="form-group">
          <label for="appusername">
            App Username: <label class="text-danger">*</label>
          </label>
          <div class="input-group">
            <span class="input-group-addon">
              <i class="glyphicon glyphicon-tag"></i>
            </span>
            <input name="appusername" type="text" class="form-control" placeholder="administrator" value="administrator" aria-describedby="appusernameHelp" required>
          </div>
      	   <small id="appusernameHelp" class="form-text text-muted">The default platform administrator's username.</small>
        </div>

        <div class="form-group">
          <label for="apppassword">
            App Password: <label class="text-danger">*</label>
          </label>
          <div class="input-group">
            <span class="input-group-addon">
              <i class="glyphicon glyphicon-lock"></i>
            </span>
            <input name="apppassword" type="password" class="form-control" placeholder="password" aria-describedby="apppasswordHelp" required>
          </div>
      	   <small id="apppasswordHelp" class="form-text text-muted">The default platform administrator's password.</small>
        </div>

        <br>
        <div class="form-group">
          <h4>Database Connection Details</h4>
        </div>
        <br>

        <div class="form-group">
          <label for="dbtype">
            DB Type: <label class="text-danger">*</label>
          </label>
          <div class="input-group">
            <span class="input-group-addon">
              <input name="dbtype" type="radio" id="SQLiteDB" value="SQLite">
            </span>
              <span class="form-control">SQLite</span>
          </div>
          <div class="input-group">
            <span class="input-group-addon">
              <input name="dbtype" type="radio" id="MySQLDB" value="MySQL">
            </span>
              <span class="form-control">MySQL</span>
          </div>
      	   <small id="dbtypeHelp" class="form-text text-muted">MySQL = Client/Server DB (Recommended for heavy use)<br>SQLite = File DB (Recommended for light use)</small>
        </div>

        <script>
          $(document).ready(function()
          {
            $('#MySQLDB').on('change', function()
            {
              if ( document.getElementById('MySQLDB').checked == true)
              {
                $("#DBHost").html('<label for="host">DB Host: <label class="text-danger">*</label></label><div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-tasks"></i></span><input name="dbhost" type="text" class="form-control" placeholder="10.0.0.82" aria-describedby="hostHelp" required></div><small id="hostHelp" class="form-text text-muted">e.g. 192.168.1.50 or db.domain.com</small>');
                $("#DBPort").html('<label for="port">DB Port: <label class="text-danger">*</label></label><div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-magnet"></i></span><input name="dbport" type="text" class="form-control" placeholder="administrator" value="3306" aria-describedby="portHelp" required></div><small id="portHelp" class="form-text text-muted">MySQL port is usually 3306.</small>');
                $("#DBUsername").html('<label for="username">DB Username: <label class="text-danger">*</label></label><div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-tag"></i></span><input name="dbusername" type="text" class="form-control" placeholder="administrator" value="root" aria-describedby="usernameHelp" required></div><small id="usernameHelp" class="form-text text-muted">The administrator username.</small>');
                $("#DBPassword").html('<label for="password">DB Password: <label class="text-danger">*</label></label><div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span><input name="dbpassword" type="password" class="form-control" placeholder="password" aria-describedby="passwordHelp"></div><small id="passwordHelp" class="form-text text-muted">The administrator password.</small>');
              }
            });

            $('#SQLiteDB').on('change', function()
            {
              if ( document.getElementById('SQLiteDB').checked == true)
              {
                $("#DBHost").html('');
                $("#DBPort").html('');
                $("#DBUsername").html('');
                $("#DBPassword").html('');
              }
            });
          });
        </script>
        
        <div class="form-group" id="DBHost"></div>

        <div class="form-group" id="DBPort"></div>

        <input type="hidden" name="dbname" value="CannaLogs">
        
        <div class="form-group" id="DBUsername"></div>

        <div class="form-group" id="DBPassword"></div>

        <div class="form-group">
          <input class="btn btn-primary" type="submit" value="Setup Database">
        </div>

        <hr>

      </form>

      <!-- Close the alerts after 15 seconds -->
      <!-- <script>
        window.setTimeout(function()
        {
            $(".alert").fadeTo(500, 0).slideUp(500, function()
            {
                $(this).remove();
            });
        }, 15000);
      </script> -->

      <?php

      require 'classes/DatabaseSetup.php';

      // If the POST has information,
      // Check if the information provided was correct.
      if( !empty($_POST) )
      {
        // If using SQLite
        if( $_POST['dbtype'] == 'SQLite' && file_exists( "/config/CannaLogs.db" ) )
        {
          // We are good if file was created
          $dbsetup = True;
        }
        // If using MySQL
        else
        {
          // Create the DB
          $dbsetup = new DatabaseSetup( $_POST );
        }

        // If the information is incorrect
        if( !$dbsetup )
        {
          echo '<br><br>
                <div class="alert alert-danger alert-dismissible" role="alert">
                <button type = "button" class="close" data-dismiss = "alert">x</button>
                  Could not connect to the Database.
                  <br><br>';
                  echo 'Error(s): ' . $check;
          echo '<br><br>
                  Please check that the information provided is correct.
                </div>';
        }
        // If the information is correct
        else
        {
          echo '<div class="alert alert-success alert-dismissible" role="alert">
            <button type = "button" class="close" data-dismiss = "alert">x</button>
                  --> Successfully ';
                if( $_POST['dbtype'] == 'MySQL' )
                {
                  echo 'connected to MySQL server';
                }
                else
                {
                  echo 'created SQLite file';
                }
                  
                  echo '!
                </div>';

          // Create Users Table
          if( $_POST['dbtype'] == 'SQLite' )
          {
            $dbsetup->setup_UsersTable();
            $result = True;
          }
          else
          {
            $result = $dbsetup->setup_UsersTable();
          }

          if( $result === True )
          {
            echo '<div class="alert alert-success alert-dismissible" role="alert">
            <button type = "button" class="close" data-dismiss = "alert">x</button>
                    --> Successfully created table "Users".
                  </div>';
          }
          else
          {
            echo '<div class="alert alert-danger alert-dismissible" role="alert">
              <button type = "button" class="close" data-dismiss = "alert">x</button>
              Error(s) occurred while creating table \'Users\' !<br><br>' .
              $result .
              '</div>';
          }

          // Create admin user
          if( $_POST['dbtype'] == 'SQLite' )
          {
            $dbsetup->create_adminUser();
            $result = True;
          }
          else
          {
            $result = $dbsetup->create_adminUser();
          }

          if( $result === True )
          {
            echo '<div class="alert alert-success alert-dismissible" role="alert">
            <button type = "button" class="close" data-dismiss = "alert">x</button>
                    --> Successfully created admin user.
                  </div>';
          }
          else
          {
            echo '<div class="alert alert-danger alert-dismissible" role="alert">
              <button type = "button" class="close" data-dismiss = "alert">x</button>
              Error(s) occurred while creating admin user!<br><br>' .
              $result .
              '</div>';
          }

          // Create Announcements Table
          if( $_POST['dbtype'] == 'SQLite' )
          {
            $dbsetup->setup_AnnouncementsTable();
            $result = True;
          }
          else
          {
            $result = $dbsetup->setup_AnnouncementsTable();
          }

          if( $result === True )
          {
            echo '<div class="alert alert-success alert-dismissible" role="alert">
            <button type = "button" class="close" data-dismiss = "alert">x</button>
                    --> Successfully created table "Announcements".
                  </div>';
          }
          else
          {
            echo '<div class="alert alert-danger alert-dismissible" role="alert">
            <button type = "button" class="close" data-dismiss = "alert">x</button>
              Error(s) occurred while creating table \'Announcements\' !<br><br>' .
              $result .
              '</div>';
          }

          // Create Projects Table
          if( $_POST['dbtype'] == 'SQLite' )
          {
            $dbsetup->setup_ProjectsTable();
            $result = True;
          }
          else
          {
            $result = $dbsetup->setup_ProjectsTable();
          }

          if( $result === True )
          {
            echo '<div class="alert alert-success alert-dismissible" role="alert">
            <button type = "button" class="close" data-dismiss = "alert">x</button>
                    --> Successfully created table "Projects".
                  </div>';
          }
          else
          {
            echo '<div class="alert alert-danger alert-dismissible" role="alert">
            <button type = "button" class="close" data-dismiss = "alert">x</button>
              Error(s) occurred while creating table \'Projects\' !<br><br>' .
              $result .
              '</div>';
          }

          // Create FeedLogs Table
          if( $_POST['dbtype'] == 'SQLite' )
          {
            $dbsetup->setup_FeedLogsTable();
            $result = True;
          }
          else
          {
            $result = $dbsetup->setup_FeedLogsTable();
          }

          if( $result === True )
          {
            echo '<div class="alert alert-success alert-dismissible" role="alert">
            <button type = "button" class="close" data-dismiss = "alert">x</button>
                    --> Successfully created table "FeedLogs".
                  </div>';
          }
          else
          {
            echo '<div class="alert alert-danger alert-dismissible" role="alert">
            <button type = "button" class="close" data-dismiss = "alert">x</button>
              Error(s) occurred while creating table \'FeedLogs\' !<br><br>' .
              $result .
              '</div>';
          }

          // Create ObservationLogs Table
          if( $_POST['dbtype'] == 'SQLite' )
          {
            $dbsetup->setup_ObservationLogsTable();
            $result = True;
          }
          else
          {
            $result = $dbsetup->setup_ObservationLogsTable();
          }

          if( $result === True )
          {
            echo '<div class="alert alert-success alert-dismissible" role="alert">
            <button type = "button" class="close" data-dismiss = "alert">x</button>
                    --> Successfully created table "ObservationLogs".
                  </div>';
          }
          else
          {
            echo '<div class="alert alert-danger alert-dismissible" role="alert">
            <button type = "button" class="close" data-dismiss = "alert">x</button>
              Error(s) occurred while creating table \'ObservationLogs\' !<br><br>' .
              $result .
              '</div>';
          }

          // Create ObservationLogs Table
          if( $_POST['dbtype'] == 'SQLite' )
          {
            $dbsetup->setup_HarvestReviewsTable();
            $result = True;
          }
          else
          {
            $result = $dbsetup->setup_HarvestReviewsTable();
          }

          if( $result === True )
          {
            echo '<div class="alert alert-success alert-dismissible" role="alert">
            <button type = "button" class="close" data-dismiss = "alert">x</button>
                    --> Successfully created table "Harvest Reviews".
                  </div>';
          }
          else
          {
            echo '<div class="alert alert-danger alert-dismissible" role="alert">
            <button type = "button" class="close" data-dismiss = "alert">x</button>
              Error(s) occurred while creating table \'Harvest Reviews\' !<br><br>' .
              $result .
              '</div>';
          }
        }
      }

      echo '<hr>
        <div class="form-group">
          <p>
            If you see errors, fill the form again and click Setup Database again.
          </p>
          <p>
            If you don\'t see any errors,
          </p>
          <a class="btn btn-primary" href="index.php">Click here to start using the application!</a>
        </div>
      ';

      ?>

    </div>


    <!-- ******************* END FORM ******************* -->

  </body>

</html>
