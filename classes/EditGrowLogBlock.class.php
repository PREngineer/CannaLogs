<?php

/*
How to use it:
    $text = new EditGrowLogBlock();
    $text->Display();
 */

class EditGrowLogBlock extends Page
{
  
  //------------------------- Attributes -------------------------
  public $content = '';
  public $title   = '';
  private $id = '';
  
  //------------------------- Operations -------------------------
  
  /**
   * __construct
   *
   * @return void
   */
  public function __construct( $id )
  {
    $this->db = new Database();
    $this->id = $id;
        
    parent::__construct();
  }

  /**
   * getProjectID - Returns the project ID from the observation log ID.
   *
   * @return array
   */
  private function getProjectID( $id )
  {
    return ($this->db->query_DB("SELECT projectid
                                FROM ObservationLogs
                                WHERE id = '" . $id . "'
                              ") )[0];
  }
  
  /**
   * getProjectDetails - Returns the project details.
   *
   * @return array
   */
  private function getProjectDetails( $id )
  {
    return ($this->db->query_DB("SELECT *
                                FROM Projects
                                WHERE id = '$id'
                              ") )[0];
  }

  /**
   * getLogDetails - Returns the log details.
   *
   * @return array
   */
  private function getLogDetails( $id )
  {
    return ($this->db->query_DB("SELECT *
                                FROM ObservationLogs
                                WHERE id = '$id'
                              ") )[0];
  }

  /**
   * Display - Displays the text editor widget
   *
   * @param  None
   *
   * @return void
   */
  public function Display()
  {
    $project = $this->getProjectDetails( $this->getProjectID( $this->id )['projectid'] );
    $log = $this->getLogDetails( $this->id );
    
    // Don't allow sneaky people to try to edit other people's project
    if( $_SESSION['userRole'] != 0 && $_SESSION['userID'] != $project['growerid'])
    {
      header( 'Location: index.php?display=ProjectDetails&id=' . $_GET['id'] );
    }
    
    // Define the content
    $this->content .= '
    <h1 class="container" id="page-title" tabindex="-1" role="heading" aria-level="1"> ' . $project['projectname'] . ' - Edit Feed/Observation Log</h1>
    <hr>
    
    <form method="POST">

      <!-- To identify changes, we store the current values in the POST -->
      <input type="hidden" name="startdate" value="'      . $project['startdate'] . '">
      <input type="hidden" name="olddate" value="'        . $log['date'] . '">
      <input type="hidden" name="oldmintemp" value="'     . $log['mintemp'] . '">
      <input type="hidden" name="oldmaxtemp" value="'     . $log['maxtemp'] . '">
      <input type="hidden" name="oldhumidity" value="'    . $log['humidity'] . '">
      <input type="hidden" name="oldlightcycle" value="'  . $log['lightcycle'] . '">
      <input type="hidden" name="oldsmell" value="'       . $log['smell'] . '">
      <input type="hidden" name="oldtopped" value="'      . $log['topped'] . '">
      <input type="hidden" name="oldfimmed" value="'      . $log['fimmed'] . '">
      <input type="hidden" name="oldlollipopped" value="' . $log['lollipopped'] . '">
      <input type="hidden" name="oldappearance" value="'  . $log['appearance'] . '">
      
      <input type="hidden" name="projectid" value="' . $this->getProjectID( $_GET['id'] )['projectid'] . '">
    
      <div class="row">

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="glyphicon glyphicon-calendar text-info"></i>
              </span>
              <input name="logDate" class="form-control" type="text" id="logDate" placeholder="YYYY-MM-DD" value="' . $log['date'] . '" aria-describedby="logDateHelp" required>
            </div>
            <small class="text-muted">Log Date</small>
          </div>
        </div>

        <script type="text/javascript">
          $(\'#logDate\').datepicker(
          {
            format: "yyyy-mm-dd",
            toggleActive: true,
            maxViewMode: 3,
            autoclose: true,
            daysOfWeekHighlighted: "1,2,3,4,5",
            todayHighlight: true
            }).on(\'changeDate\', function (e)
            {
              $(this).focus();
          });
        </script>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="glyphicon glyphicon-dashboard text-info"></i>
              </span>
              <input name="mintemp" class="form-control" type="text" id="mintemp" placeholder="72F/21C" value="' . $log['mintemp'] . '" aria-describedby="mintempHelp" required>
            </div>
            <small class="text-muted">Minimum Temperature</small>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="glyphicon glyphicon-dashboard text-danger"></i>
              </span>
              <input name="maxtemp" class="form-control" type="text" id="maxtemp" placeholder="72F/21C" value="' . $log['maxtemp'] . '" aria-describedby="maxtempHelp" required>
            </div>
            <small class="text-muted">Maximum Temperature</small>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="glyphicon glyphicon-tint"></i>
              </span>
              <input name="humidity" class="form-control" type="text" id="humidity" placeholder="60%" value="' . $log['humidity'] . '" aria-describedby="humidityHelp" required>
            </div>
            <small class="text-muted">Relative Humidity</small>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="glyphicon glyphicon-adjust text-warning"></i>
              </span>
              <input name="lightcycle" class="form-control" type="text" id="lightcycle" placeholder="18/6" value="' . $log['lightcycle'] . '" aria-describedby="lightcycleHelp" required>
            </div>
            <small class="text-muted">Light Cycle (On/Off)</small>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="glyphicon glyphicon-random text-info"></i>
              </span>
              <select name="smell" class="form-control" required>
              <option></option>
              <option value="No"';

    if( $log['smell'] == 'No' )
    {
      $this->content .= ' selected';
    }

    $this->content .= '
              >No</option>
              <option value="Weak"';

              if( $log['smell'] == 'Weak' )
              {
                $this->content .= ' selected';
              }
          
              $this->content .= '
                        >Weak</option>
              <option value="Normal"';

              if( $log['smell'] == 'Normal' )
              {
                $this->content .= ' selected';
              }
          
              $this->content .= '
                        >Normal</option>
              <option value="Strong"';

              if( $log['smell'] == 'Strong' )
              {
                $this->content .= ' selected';
              }
          
              $this->content .= '
                        >Strong</option>
            </select>
            </div>
            <small class="text-muted">Smell</small>
          </div>
        </div>
      
      </div>

      <div class="row">

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" name="topped"';
    if( $log['topped'] == 'Yes' )
    {
      $this->content .= ' checked';
    }

    $this->content .= '>
              </span>
              <span class="form-control">Topped</span>
            </div>
            <small class="text-muted">Stem(s) Cut</small>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" name="fimmed"';
                if( $log['fimmed'] == 'Yes' )
                {
                  $this->content .= ' checked';
                }
            
                $this->content .= '>
              </span>
              <span class="form-control">Fimmed</span>
            </div>
            <small class="text-muted">Tip Of Stem(s) Cut ~80%</small>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" name="lollipopped"';
                if( $log['lollipopped'] == 'Yes' )
                {
                  $this->content .= ' checked';
                }
            
                $this->content .= '>
              </span>
              <span class="form-control">Lollipopped</span>
            </div>
            <small class="text-muted">Bottom 1/3 Stem(s) Cut</small>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="glyphicon glyphicon-plus text-danger"></i>
              </span>
              <select name="healthappearance" class="form-control" required>
              <option></option>
              <option value="Dead"';

              if( $log['appearance'] == 'Dead' )
              {
                $this->content .= ' selected';
              }
          
              $this->content .= '
                        >Dead</option>
              <option value="Sick"';

              if( $log['appearance'] == 'Sick' )
              {
                $this->content .= ' selected';
              }
          
              $this->content .= '
                        >Sick</option>
              <option value="Neutral"';

              if( $log['appearance'] == 'Neutral' )
              {
                $this->content .= ' selected';
              }
          
              $this->content .= '
                        >Neutral</option>
              <option value="Good"';

              if( $log['appearance'] == 'Good' )
              {
                $this->content .= ' selected';
              }
          
              $this->content .= '
                        >Good</option>
              <option value="Excellent"';

              if( $log['appearance'] == 'Excellent' )
              {
                $this->content .= ' selected';
              }
          
              $this->content .= '
                        >Excellent</option>
            </select>
            </div>
            <small class="text-muted">Health Visual Appearance</small>
          </div>
        </div>

      </div>

      <textarea name="editor" id="editor" required>' . $log['notes'] . '</textarea>
      <script>
        CKEDITOR.replace( "editor" );
      </script>
      <p class="text-warning">
        <a href="Upload.php" target="_blank">Upload</a> - To add an image, click here. Then, use the add image button and put the URL to add it to your log.<br>
        <a href="photos/" target="_blank">Find Image</a> - If you have already uploaded an image but didn\'t copy the URL, you can find your image and copy its URL.
      </p>
      <p class="text-warning">
        To add a YouTube video:<br>
        1. Copy the Embed code for the video (Right-click the video > Copy embed code)<br>
        2. Click the \'Source\' button in the editor<br>
        3. Add the Embed code<br>
        4. Submit the entry.
      </p>
      <div class="text-right">
        <input class="btn btn-primary" type="submit" value="SUBMIT ENTRY">
      </div>

    </form>
    ';

    return $this->content;
  }

}

?>