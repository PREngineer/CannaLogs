<?php

/*
How to use it:
    $text = new CreateGrowLogBlock();
    $text->Display();
 */

class CreateGrowLogBlock extends Page
{
  
  //------------------------- Attributes -------------------------
  public $content = '';
  public $title   = '';
  
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
   * getProjectDetails - Returns the project details.
   *
   * @return array
   */
  private function getProjectDetails( $id )
  {
    return ($this->db->query_DB("SELECT *
                                FROM Projects
                                WHERE id = '" . $_GET['id'] . "'
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
    $project = $this->getProjectDetails( $_GET['id'] );
    
    // Don't allow sneaky people to try to edit other people's project
    if( $_SESSION['userRole'] != 0 && $_SESSION['userID'] != $project['growerid'])
    {
      header( 'Location: index.php?display=ProjectDetails&id=' . $_GET['id'] );
    }
    
    // Define the content
    $this->content .= '
    <h1 class="container" id="page-title" tabindex="-1" role="heading" aria-level="1"> ' . $project['projectname'] . ' - Create Feed/Observation Log</h1>
    <hr>
    
    <form method="POST">

      <!-- Some data from that project that is needed -->
      <input type="hidden" name="startdate" value="' . $project['startdate'] . '">
    
      <div class="row">

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" name="addfeed" id="addfeed" onChange="showFeed(this)">
              </span>
              <span class="form-control">Add Feed Log</span>
            </div>
            <small class="text-muted">Add Feed Data</small>
          </div>
        </div>';

        if( $project['germinationdate'] == '' )
        {
          $this->content .= '
          <div class="col-md-3">
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon">
                  <input type="checkbox" name="startgermination" id="startgermination">
                </span>
                <span class="form-control">Start Germination / Clone</span>
              </div>
              <small class="text-muted">Switch Project To Next Stage</small>
            </div>
          </div>';
        }
        else if( $project['vegetationdate'] == '' )
        {
          $this->content .= '
          <div class="col-md-2">
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon">
                  <input type="checkbox" name="startvegetation" id="startvegetation">
                </span>
                <span class="form-control">Start Vegetation</span>
              </div>
              <small class="text-muted">Switch Project To Next Stage</small>
            </div>
          </div>';
        }
        else if( $project['floweringdate'] == '' )
        {
          $this->content .= '
          <div class="col-md-2">
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon">
                  <input type="checkbox" name="startflowering" id="startflowering">
                </span>
                <span class="form-control">Start Flower</span>
              </div>
              <small class="text-muted">Switch Project To Next Stage</small>
            </div>
          </div>';
        }
        else if( $project['flushingdate'] == '' )
        {
          $this->content .= '
          <div class="col-md-2">
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon">
                  <input type="checkbox" name="startflushing" id="startflushing">
                </span>
                <span class="form-control">Start Flush</span>
              </div>
              <small class="text-muted">Switch Project To Next Stage</small>
            </div>
          </div>';
        }
        else if( $project['harvestingdate'] == '' )
        {
          $this->content .= '
          <div class="col-md-2">
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon">
                  <input type="checkbox" name="startharvesting" id="startharvesting">
                </span>
                <span class="form-control">Start Harvest</span>
              </div>
              <small class="text-muted">Switch Project To Next Stage</small>
            </div>
          </div>';
        }

        $this->content .= '
        
      </div>

      <div class="panel panel-default">
        <h4 id="feedtitle" style="display: none">Log Feed Data</h4>
        <div id="feedinputsdiv"></div>
        <div class="form-group" id="nutrientslistdiv" style="display: none">
          <div class="input-group">
            <table class="table" id="nutrientslisttable">
              <thead>
                <tr>
                  <th>
                  Nutrient / Additive Name
                  </th>
                  <th>
                  Nutrient / Additive Amount
                  </th>
                </tr>
              </thead>

              <tbody>
              </tbody>
            </table>
            <span style="color: blue; cursor: pointer;" onClick="addNutrientsListRow()"><span class="glyphicon glyphicon-plus"></span> Add Row</span>&nbsp;&nbsp;
            <span style="color: red; cursor: pointer;" onClick="deleteNutrientsListRow()"><span class="glyphicon glyphicon-minus"></span> Remove Last Row</span>
          </div>
          <small id="plantdetailsHelp" class="form-text text-muted">Add a row per nutrient.</small>
        </div>
      </div>
      
      <script>
        // Function to check the grow medium values
        function showFeed( checkbox )
        {
          if ( checkbox.checked == true)
          {
            $("#feedinputsdiv").html(\'<div class="row"><div class="col-md-2"><div class="form-group"><div class="input-group"><span class="input-group-addon"><b>PH:</b></span><input class="form-control" type="text" name="phfed" placeholder="5.80" required></div><small class="text-muted">Water Acidity</small></div></div><div class="col-md-2"><div class="form-group"><div class="input-group"><span class="input-group-addon"><b>PPM:</b></span><input class="form-control" type="text" name="ppmfed" placeholder="1200" required></div><small class="text-muted">Amount Of Nutrients</small></div></div><div class="col-md-2"><div class="form-group"><div class="input-group"><span class="input-group-addon"><b>Water:</b></span><input class="form-control" type="text" name="waterfed" placeholder="1 gal" required></div><small class="text-muted">Amount Of Water</small></div></div></div>\');
            $("#nutrientslistdiv").show();
            $("#feedtitle").show();
            addNutrientsListRow();
          }
          else
          {
            deleteAllNutrientsListRows();
            $("#nutrientslistdiv").hide();
            $("#feedtitle").hide();
            $("#feedinputsdiv").html(\'\');
          }
        }
        function addNutrientsListRow()
        {
          // Get the Table to modify
          var table = document.getElementById("nutrientslisttable");

          // Insert a new row
          var row = table.insertRow();

          // Insert new cells
          var cell = row.insertCell();
          cell.innerHTML = "<input name=\'nutrientnames[]\' type=\'text\' class=\'form-control\' placeholder=\'MaxiGrow\' required>";
          cell = row.insertCell();
          cell.innerHTML = "<input name=\'nutrientamounts[]\' type=\'text\' class=\'form-control\' placeholder=\'3 tbspn\' required>";
          cell = row.insertCell();
        }
        function deleteAllNutrientsListRows()
        {
          // Get the Table to modify
          var table = document.getElementById("nutrientslisttable");

          // Remove all rows but the headers one
          for( let i = table.rows.length-1; i > 0; i--)
          {
            table.deleteRow( i );
          }
        }
        function deleteNutrientsListRow()
        {
          // Get the Table to modify
          var table = document.getElementById("nutrientslisttable");

          // Remove last row
          if( table.rows.length-1 > 0)
          {
            table.deleteRow( table.rows.length-1 );
          }
        }
      </script>

      <div class="row">

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="glyphicon glyphicon-calendar text-info"></i>
              </span>
              <input name="logDate" class="form-control" type="text" id="logDate" placeholder="YYYY-MM-DD" value="' . date('Y-m-d') . '" aria-describedby="logDateHelp" required>
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
              <input name="mintemp" class="form-control" type="text" id="mintemp" placeholder="72F/21C" aria-describedby="mintempHelp" required>
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
              <input name="maxtemp" class="form-control" type="text" id="maxtemp" placeholder="72F/21C" aria-describedby="maxtempHelp" required>
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
              <input name="humidity" class="form-control" type="text" id="humidity" placeholder="60%" aria-describedby="humidityHelp" required>
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
              <input name="lightcycle" class="form-control" type="text" id="lightcycle" placeholder="18/6" aria-describedby="lightcycleHelp" required>
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
              <option value="No">No</option>
              <option value="Weak">Weak</option>
              <option value="Normal">Normal</option>
              <option value="Strong">Strong</option>
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
                <input type="checkbox" name="topped">
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
                <input type="checkbox" name="fimmed">
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
                <input type="checkbox" name="lollipopped">
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
              <option value="Dead">Dead</option>
              <option value="Sick">Sick</option>
              <option value="Neutral">Neutral</option>
              <option value="Good">Good</option>
              <option value="Excellent">Excellent</option>
            </select>
            </div>
            <small class="text-muted">Health Visual Appearance</small>
          </div>
        </div>

      </div>

      <textarea name="editor" id="editor" required></textarea>
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