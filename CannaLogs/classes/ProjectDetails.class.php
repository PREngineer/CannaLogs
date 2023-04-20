<?php

class ProjectDetails extends Page
{
  
  //------------------------- Attributes -------------------------
  private $db       = null;
  public $content  = '';
  public $title    = "CannaLogs - Project Details";
  public $keywords = "CannaLogs, project details";
  
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
   * daysBetween - Calculates how many days have passed between 2 dates
   * 
   * @return int
   */
  private function daysBetween( $begin, $end )
  {
    return ceil ( abs ( ( strtotime($end) - strtotime($begin) ) / 86400 ) );
  }
  
  /**
   * getFeedLogs - Returns the Feed Logs for this project.
   *
   * @return array
   */
  private function getFeedLogs( $id )
  {
    return $this->db->query_DB("SELECT *
                                FROM FeedLogs
                                WHERE projectid = '$id'
                                ORDER BY date ASC
                              ");
  }
  
  /**
   * getGrowLogs - Returns the Grow Logs for this project.
   *
   * @return array
   */
  private function getGrowLogs( $id )
  {
    return $this->db->query_DB("SELECT *
                                FROM ObservationLogs
                                WHERE projectid = '$id'
                                ORDER BY date ASC
                              ");
  }
  
  /**
   * getGrowerDetails - Returns the grower's details.
   *
   * @return array
   */
  private function getGrowerDetails( $id )
  {
    return ($this->db->query_DB("SELECT id, username, fname, mname, lname
                                FROM Users
                                WHERE id = '$id'
                              ") )[0];
  }

  /**
   * getHarvestReviews - Returns the project's harvest reviews.
   *
   * @return array
   */
  private function getHarvestReviews( $id )
  {
    return $this->db->query_DB("SELECT *
                                FROM HarvestReviews
                                WHERE projectid = '$id'
                              ");
  }
  
  /**
   * getProjectDetails - Returns the project details.
   *
   * @return array
   */
  private function getProjectDetails()
  {
    return ($this->db->query_DB("SELECT *
                                FROM Projects
                                WHERE id = '" . $_GET['id'] . "'
                              ") )[0];
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
    // Get the data
    $data     = $this->getProjectDetails();
    
    $grower   = $this->getGrowerDetails( $data['growerid'] );

    $growlogs = $this->getGrowLogs( $_GET['id'] );

    $feedlogs = $this->getFeedLogs( $_GET['id'] );

    $reviews  = $this->getHarvestReviews( $_GET['id'] );

    $this->content .= '
    <ol class="breadcrumb">
      <li><a href="index.php?display=Projects">Projects</a></li>
      <li><a href="#">' . $data['projectname'] . '</a></li>
    </ol>
    ';
    // Set the page header
    $this->content .= '
      <h1 id="page-title" tabindex="-1" role="heading" aria-level="1">Project Details</h1>
    ';

    $this->content .= '
    <div id="" class="col-lg-11 container thumbnail">
    ';
    
    if( ( $_SESSION['userRole'] !== NULL ) && ( ( $_SESSION['userRole'] == 0 ) || ( $_SESSION['userID'] == $data['growerid'] ) ) )
    {
      $this->content .= '<a href="index.php?display=CreateGrowLog&id=' . $data['id'] . '">
        <span class="glyphicon glyphicon-book" title="Add Feed/Observation Log"></span> Add Feed/Observation Log
      </a>&nbsp;
      <a href="index.php?display=EditProject&id=' . $data['id'] . '">
        <span class="glyphicon glyphicon-pencil text-success text" title="Edit Project"></span> Edit Project
      </a>&nbsp;
      <a href="index.php?display=DeleteProject&id=' . $data['id'] . '">
        <span class="glyphicon glyphicon-trash text-danger" title="Delete Project"></span> Delete Project
      </a>&nbsp;';
      if( $data['projectstatus'] == 'In Progress' )
      {
        $this->content .= '&nbsp;
        <a href="index.php?display=CancelProject&id=' . $data['id'] . '">
          <span class="glyphicon glyphicon-remove text-danger" title="Cancel Project"></span> Cancel Project
        </a>
        &nbsp;
        <a href="index.php?display=FailProject&id=' . $data['id'] . '">
          <span class="glyphicon glyphicon-thumbs-down text-danger" title="Mark Failed"></span> Mark Failed
        </a>&nbsp;
        <a href="index.php?display=SucceedProject&id=' . $data['id'] . '">
          <span class="glyphicon glyphicon-thumbs-up text-success" title="Mark Success"></span> Mark Successful
        </a>
        ';
      }
       
      if( $data['projectstatus'] == 'Success' )
      {
        if( $data['lessonslearned'] == '' )
        {
          $this->content .= '&nbsp;
          <a href="index.php?display=CreateLessonsLearned&id=' . $data['id'] . '">
            <span class="glyphicon glyphicon-copy text-info" title="Add Lessons Learned"></span> Add Lessons Learned
          </a>';
        }
        $this->content .= '&nbsp;
        <a href="index.php?display=CreateProjectReview&id=' . $data['id'] . '">
          <span class="glyphicon glyphicon-heart" style="color: red" title="Add Harvest Review"></span> Add Harvest Review
        </a>';
      }
    }
    
    $this->content .= '
      <table role="presentation" class="table">
        <tr>
          <td colspan="3" class="text-center panel-heading bg-success">
            <h2><b>' . $data['projectname'] . '</b></h2>
            <b>Project Status: </b>' . $data['projectstatus'] . ' | <b>Current Stage:</b> ';
          if( $data['germinationdate'] == '' )
          {
            $this->content .= '<span class="glyphicon glyphicon-off text-danger" style="color: green" title="Germination / Cloning"></span> Just Started';
          }
          else if( $data['vegetationdate'] == '' )
          {
            $this->content .= '<span class="glyphicon glyphicon-leaf text-danger" style="color: green" title="Germination / Cloning"></span> Germination / Clone';
          }
          else if( $data['floweringdate'] == '' )
          {
            $this->content .= '<span class="glyphicon glyphicon-grain text-danger" style="color: green" title="Germination / Cloning"></span> Vegetation';
          }
          else if( $data['flushingdate'] == '' )
          {
            $this->content .= '<span class="glyphicon glyphicon-tree-deciduous text-danger" style="color: green" title="Germination / Cloning"></span> Flower';
          }
          else if( $data['harvestingdate'] == '' )
          {
            $this->content .= '<span class="glyphicon glyphicon-tint text-danger" style="color: green" title="Germination / Cloning"></span> Flush';
          }
          else
          {
            $this->content .= '<span class="glyphicon glyphicon-scissors text-danger" style="color: green" title="Germination / Cloning"></span> Harvest';
          }
          $this->content .= '</td>
        </tr>
        
        <tr>
          <td colspan="3" class="text-center text-muted">
            <h3>General Details</h3>
          </td>
        </tr>

        <tr>
          <td style="width: 33%" class="text-left">
            <b>Purpose:</b> ' . $data['purpose'] . ' 
          </td>
          <td style="width: 33%" class="text-left">
            <b>Location:</b> ' . $data['location'] . '
          </td>
          <td style="width: 33%" class="text-left">
            <b>Grower:</b> <a href="index.php?display=GrowerDetails&id=' . $grower['id'] . '">' . $grower['username'] . '</a> 
          </td>
        </tr>

        <tr>
          <td colspan="3" class="text-center text-muted">
            <h4>Timeline</h4>
          </td>
        </tr>';
        
        // Calculations for the timeline graph
        // Total days from start
        if( $data['harvestingdate'] != '' )
        {
          $totalDays = $this->daysBetween( $data['startdate'], $data['harvestingdate'] );
        }
        else
        {
          $totalDays = $this->daysBetween( $data['startdate'], date('Y-m-d') );
        }
        // Days in Start
        if( $data['germinationdate'] != '' )
        {
          $startDays = $this->daysBetween( $data['startdate'], $data['germinationdate'] );
        }
        else
        {
          $startDays = $this->daysBetween( $data['startdate'], date('Y-m-d') );
        }
        // Days in Germination
        if( $data['germinationdate'] != '' && $data['vegetationdate'] != '' )
        {
          $germinationDays = $this->daysBetween( $data['germinationdate'], $data['vegetationdate'] );
        }
        else if( $data['germinationdate'] != '' && $data['vegetationdate'] == '' )
        {
          $germinationDays = $this->daysBetween( $data['germinationdate'], date('Y-m-d') );
        }
        else
        {
          $germinationDays = '0';
        }
        // Days in Vegetation
        if( $data['vegetationdate'] != '' && $data['floweringdate'] != '' )
        {
          $vegetationDays = $this->daysBetween( $data['vegetationdate'], $data['floweringdate'] );
        }
        else if( $data['vegetationdate'] != '' && $data['floweringdate'] == '' )
        {
          $vegetationDays = $this->daysBetween( $data['vegetationdate'], date('Y-m-d') );
        }
        else
        {
          $vegetationDays = '0';
        }
        // Days in Flower
        if( $data['floweringdate'] != '' && $data['flushingdate'] != '' )
        {
          $floweringDays = $this->daysBetween( $data['floweringdate'], $data['flushingdate'] );
        }
        else if( $data['floweringdate'] != '' && $data['flushingdate'] == '' )
        {
          $floweringDays = $this->daysBetween( $data['floweringdate'], date('Y-m-d') );
        }
        else
        {
          $floweringDays = '0';
        }
        // Days in Flush
        if( $data['flushingdate'] != '' && $data['harvestingdate'] != '' )
        {
          $flushingDays = $this->daysBetween( $data['flushingdate'], $data['harvestingdate'] );
        }
        else if( $data['flushingdate'] != '' && $data['harvestingdate'] == '' )
        {
          $flushingDays = $this->daysBetween( $data['flushingdate'], date('Y-m-d') );
        }
        else
        {
          $flushingDays = '0';
        }

        // Array of calculations to pass to the Timeline Object
        $calculations = array( 'startDays' => $startDays, 'germinationDays' => $germinationDays, 'vegetationDays' => $vegetationDays, 'floweringDays' => $floweringDays, 
                               'flushingDays' => $flushingDays, 'totalDays' => $totalDays );

        $this->content .= '
        <tr>
          <td colspan="3">';
            $timeline = new ProjectTimelineGraph( $calculations );
            
        $this->content .= $timeline->Display( $data ) . '
          </td>
        </tr>

        <tr>
          <td>
            <b>Started:</b> ' . $data['startdate'] . ' (' . $startDays . ' days)
            </td>  
          <td>
            <b>Germinated:</b> ' . $data['germinationdate'];
            if( $germinationDays != '' )
            { $this->content .= ' (' . $germinationDays . ' days)'; }
          
            $this->content .= '
          </td>
          <td>
            <b>Vegetated:</b> ' . $data['vegetationdate'];
            if( $vegetationDays != '' )
            { $this->content .= ' (' . $vegetationDays . ' days)'; }
          
            $this->content .= '
            </td>
        </tr>

        <tr>
          <td>
            <b>Flowered:</b> ' . $data['floweringdate'];
            if( $floweringDays != '' )
            { $this->content .= ' (' . $floweringDays . ' days)'; }
          
            $this->content .= '
          </td>
          <td>
            <b>Flushed:</b> ' . $data['flushingdate'];
            if( $flushingDays != '' )
            { $this->content .= ' (' . $flushingDays . ' days)'; }
          
            $this->content .= '
          </td>
          <td>
            <b>Harvested:</b> ' . $data['harvestingdate'] . '
          </td>
        </tr>

        <tr>
          <td colspan="3" class="text-center text-muted">
            <h3>Techniques Applied</h3>
          </td>
        </tr>

        <tr>
          <td>
            <b>Low Stress Training: </b> ';
            if( $data['usinglst'] == 'on')
            {
              $this->content .= 'Yes';
            }
            else
            {
              $this->content .= 'No';
            }

            $this->content .= '
          </td>
          <td>
            <b>Monster Cropping: </b>  ';
            if( $data['usingmonstercropping'] == 'on')
            {
              $this->content .= 'Yes';
            }
            else
            {
              $this->content .= 'No';
            }

            $this->content .= '
          </td>
          <td>
            <b>Screen Of Green: </b>  ';
            if( $data['usingscreenofgreen'] == 'on')
            {
              $this->content .= 'Yes';
            }
            else
            {
              $this->content .= 'No';
            }

            $this->content .= '
          </td>
        </tr>

        <tr>
          <td>
            <b>Sea Of Green: </b>  ';
            if( $data['usingseaofgreen'] == 'on')
            {
              $this->content .= 'Yes';
            }
            else
            {
              $this->content .= 'No';
            }

            $this->content .= '
          </td>
          <td>
            <b>Topping: </b> <br>';
            if( $data['toppingdates'] != '')
            {
              $dates = explode(",", $data['toppingdates']);
              for( $i = 0; $i < sizeof( $dates ); $i++ )
              {
                $this->content .= '<br>' . $dates[$i] . ' ( Day ' . $this->daysBetween( $data['startdate'], $dates[$i] ) . ' )';
              }
            }
            else
            {
              $this->content .= 'No';
            }

            $this->content .= '
          </td>
          <td>
            <b>Fimming: </b> <br>';
            if( $data['fimmingdates'] != '')
            {
              $dates = explode(",", $data['fimmingdates']);
              for( $i = 0; $i < sizeof( $dates ); $i++ )
              {
                $this->content .= '<br>' . $dates[$i] . ' ( Day ' . $this->daysBetween( $data['startdate'], $dates[$i] ) . ' )';
              }
            }
            else
            {
              $this->content .= 'No';
            }

            $this->content .= '
          </td>
        </tr>

        <tr>
          <td>
            <b>Lollipopping: </b> <br>';
            if( $data['lollipoppingdates'] != '')
            {
              $dates = explode(",", $data['lollipoppingdates']);
              for( $i = 0; $i < sizeof( $dates ); $i++ )
              {
                $this->content .= '<br>' . $dates[$i] . ' ( Day ' . $this->daysBetween( $data['startdate'], $dates[$i] ) . ' )';
              }
            }
            else
            {
              $this->content .= 'No';
            }

            $this->content .= '
          </td>
          <td>
            
          </td>
          <td>
            
          </td>
        </tr>
        
        <tr>
          <td colspan="3" class="text-center text-muted">
            <h3>Plant Details</h3>
          </td>
        </tr>
        
        <tr>';

          $tags    = explode(",", $data['planttags'] );
          $strains = explode(",", $data['plantstrains'] );
          $sex     = explode(",", $data['plantsex'] );
          $variety = explode(",", $data['plantvariety'] );
          $type    = explode(",", $data['planttype'] );
          $breeder = explode(",", $data['plantbreeders'] );
          $price   = explode(",", $data['plantprices'] );
          for( $i = 0; $i < sizeof( $tags ); $i++ )
          {
            if( $i % 3 == 0 )
            {
              $this->content .= '
              </tr>
              <tr>';
            }
            $this->content .= '
              <td>
                <b>TAG:</b> '      . $tags[$i]     . '
                <br><b>Strain:</b> '   . $strains[$i]  . '
                <br><b>Sex:</b> '      . $sex[$i]      . '
                <br><b>Variety:</b> '  . $variety[$i]  . '
                <br><b>Type:</b> '     . $type[$i]     . '
                <br><b>Breeder:</b> '  . $breeder[$i]  . '
                <br><b>Price:</b> '    . $price[$i]    . '
              </td>
            ';
          }

          $this->content .= '
        </tr>

        <tr>
          <td colspan="3" class="text-center text-muted">
            <h3>Grow Medium Details</h3>
          </td>
        </tr>

        <tr>
          <td class="text-left">
            <b>Starter Medium:</b> ' . $data['startermedium'] . ' 
          </td>
          <td class="text-left">
            <b>Medium:</b> ' . $data['medium'] . '
          </td>
          <td class="text-left"> ';
            
            if( $data['medium'] == 'Hydroponic' )
            {
              $this->content .= '<b>Hydroponic Method:</b> ' . $data['hydromethod'];
            }
            if( $data['medium'] == 'Blend' )
            {
              $components = explode( ",", $data['mediumcomponents'] );
              $percentage = explode( ",", $data['mediumcomponentspercentage'] );
              $this->content .= '<b>Blend Components:</b><br>';
              for( $i = 0; $i < sizeof( $components ); $i++ )
              {
                $this->content .= '<br>' . $components[$i] . ' - ' . $percentage[$i] . '%';
              }
            }

          $this->content .= '
          </td>
        </tr>

        <tr>
          <td class="text-left">
            <b>Germination/Cloning Container Size:</b> ' . $data['containersizeseedling'] . ' 
          </td>
          <td class="text-left">
            <b>Vegetation Container Size:</b> ' . $data['containersizevegetation'] . '
          </td>
          <td class="text-left">
            <b>Flowering Container Size:</b> ' . $data['containersizeflowering'] . '
          </td>
        </tr>

        <tr>
          <td colspan="3" class="text-left"> ';
            
            $brand = explode( ",", $data['nutrientbrands'] );
            $names = explode( ",", $data['nutrientnames'] );
            $this->content .= '<b>Nutrients / Additives Used:</b><br>';
            for( $i = 0; $i < sizeof( $brand ); $i++ )
            {
              $this->content .= '<br>' . $brand[$i] . ' - ' . $names[$i];
            }

          $this->content .= '
          </td>
        </tr>

        <tr>
          <td colspan="3" class="text-center text-muted">
            <h3>Grow Equipment Details</h3>
          </td>
        </tr>

        <tr>
          <td class="text-left">
            <b>Using Tent:</b> ' . $data['usingtent'];
            if( $data['usingtent'] == 'Yes' )
            {
              $this->content .= '<br><b>Tent Size: </b>' . $data['tentsize'];
            }
            $this->content .= '
          </td>
          <td class="text-left">
            <b>Light Type:</b> ' . $data['lighttype'] . '
            <br><b>Wattage:</b> ' . $data['lightwattage'] . '
          </td>
          <td class="text-left">
            <b>Using Ventilation Fans:</b> ' . $data['usingventilationfans'];
            if( $data['usingventilationfans'] == 'Yes' )
            {
              $this->content .= '<br><b>Amount: </b>' . $data['ventilationfansamount'] . 
              '<br><b>Type: </b>' . $data['ventilationfanstype'];
            }
            $this->content .= '
          </td>
        </tr>

        <tr>
          <td class="text-left">
            <b>Using Extraction Fan:</b> ' . $data['usingextractionfan'];
            if( $data['usingextractionfan'] == 'Yes' )
            {
              $this->content .= '<br><b>CFM: </b>' . $data['extractionfancfm'];
            }
            $this->content .= '
          </td>
          <td class="text-left">
          <b>Using Intake Fan:</b> ' . $data['usingintakefan'];
          if( $data['usingintakefan'] == 'Yes' )
          {
            $this->content .= '<br><b>CFM: </b>' . $data['intakefancfm'];
          }
          $this->content .= '
          </td>
          <td class="text-left">
            <b>Using Carbon Filter:</b> ' . $data['usingcarbonfilter'] . '
          </td>
        </tr>

        <tr>
          <td class="text-left">
            <b>Using De-Humidifier:</b> ' . $data['usingdehumidifier'] . '
          </td>
          <td class="text-left">
          <b>Using Humidifier:</b> ' . $data['usinghumidifier'] . '
          </td>
          <td class="text-left">
            <b>Using Space Heater:</b> ' . $data['usingheater'] . '
          </td>
        </tr>

        <tr>
          <td class="text-left">
            <b>Using Air Conditioner:</b> ' . $data['usingac'] . '
          </td>
          <td class="text-left">
          <b>Using Thermo-Hygrometer:</b> ' . $data['usingthermohygrometer'] . '
          </td>
          <td class="text-left">
            <b>Using PPM-PH Meter(s):</b> ' . $data['usingppmphmeters'] . '
          </td>
        </tr>

        <tr>
          <td colspan="3" class="text-center text-muted">
            <h3>Additional Gear Details</h3>
          </td>
        </tr>

        <tr>
          <td class="text-left">
            <b>Using Power Strip:</b> ' . $data['usingpowerstrip'] . '
          </td>
          <td class="text-left">
          <b>Using Timer(s):</b> ' . $data['usingtimers'] . '
          </td>
          <td class="text-left">
            <b>Using PH Balancers:</b> ' . $data['usingphbalancers'] . '
          </td>
        </tr>

        <tr>
          <td class="text-left">
            <b>Using Gloves:</b> ' . $data['usinggloves'] . '
          </td>
          <td class="text-left">
          <b>Using Sunglasses:</b> ' . $data['usingsunglasses'] . '
          </td>
          <td class="text-left">
            <b>Using Spray Bottles:</b> ' . $data['usingspraybottles'] . '
          </td>
        </tr>

        <tr>
          <td class="text-left">
            <b>Using Ties/Strings:</b> ' . $data['usingtiesstring'] . '
          </td>
          <td class="text-left">
          <b>Using Tape:</b> ' . $data['usingtape'] . '
          </td>
          <td class="text-left">
            <b>Using Scissors:</b> ' . $data['usingscissors'] . '
          </td>
        </tr>

        <tr>
          <td class="text-left">
            <b>Using Magnifier:</b> ' . $data['usingmagnifier'] . '
          </td>
          <td class="text-left">
          <b>Using Mason Jar(s):</b> ' . $data['usingmasonjars'] . '
          </td>
          <td class="text-left">
            <b>Using Drying Rack:</b> ' . $data['usingdryingrack'] . '
          </td>
        </tr>
      </table>

      <table role="presentation" class="table">
        <tr>
          <td colspan="7" class="text-center text-muted">
            <h3>Feed Logs</h3>
          </td>
        </tr>
      </table>';
      
      $feeddata = 0;
      $feeddates = 0;
      for( $i = 0; $i < sizeof( $feedlogs ); $i++ )
      {
        if( $i < ( sizeof( $feedlogs )-1 ) )
        {
          $feeddata .= ($feedlogs[$i])['ppm'] . ',';
          $feeddates .= ($feedlogs[$i])['daysfromstart'] . ',';
        }
        else
        {
          $feeddata .= ($feedlogs[$i])['ppm'];
          $feeddates .= ($feedlogs[$i])['daysfromstart'];
        }

      }

      $this->content .= '
      <table role="presentation" class="table">
        <tr>
          <a href="widgets/FeedLogsGraph.php?data=' . $feeddata . '&dates=' . $feeddates . '" target="_blank"><img src="widgets/FeedLogsGraph.php?data=' . $feeddata . '&dates=' . $feeddates . '" width="450" height="250" /></a>
        </tr>

        <tr>
          <th>Date</th>
          <th>Day #</th>
          <th>PH</th>
          <th>PPM</th>
          <th>Water Amount</th>
          <th>Nutrient Name(s)</th>
          <th>Nutrient Amount(s)</th>
        </tr>';

        foreach( $feedlogs as $one )
        {
          $this->content .= '
          <tr>
          <td>' . $one['date'] . '</td>
          <td>' . $one['daysfromstart'] . '</td>
          <td>' . $one['ph'] . '</td>
          <td>' . $one['ppm'] . '</td>
          <td>' . $one['water'] . '</td>
          <td>' . str_replace(",", "<br>", $one['nutrientnames']) . '</td>
          <td>' . str_replace(",", "<br>", $one['nutrientamounts']) . '</td>
          </tr>';
        }
        $this->content .= '
      </table>
      
      <table role="presentation" class="table">
        <tr>
          <td colspan="3" class="text-center text-muted">
            <h3>Observation Logs</h3>
          </td>
        </tr>
      </table>';

      foreach( $growlogs as $one )
      {
        $this->content .= '
        <div id="ObservationLog' . $one['id'] . '" class="thumbnail">';

        if( ( $_SESSION['userRole'] !== NULL ) && ( ( $_SESSION['userRole'] == 0 ) || ( $_SESSION['userID'] == $data['growerid'] ) ) )
        {
          $this->content .= '<a href="index.php?display=EditGrowLog&id=' . $one['id'] . '">
            <span class="glyphicon glyphicon-book" title="Edit Log"></span> Edit Log
          </a>';
        }

        $this->content .= '
          <table role="presentation" class="table bg-success">
            <tr>
              <td class="text-left" width="33%">
                <b>Date:</b> ' . $one['date'] . ' (Day ' . $one['daysfromstart'] . ')
              </td>
              <td class="text-center" width="33%">
                <b>Smell:</b> ' . $one['smell'] . '
              </td>
              <td class="text-right" width="33%">
                <b>Health Appearance:</b> ' . $one['appearance'] . '
              </td>
            </tr>

            <tr>
              <td class="text-left">
                <b>Minimum Temperature:</b> ' . $one['mintemp'] . '
              </td>
              <td class="text-center">
                <b>Maximum Temperature:</b> ' . $one['maxtemp'] . '
              </td>
              <td class="text-right">
                <b>Relative Humidity:</b> ' . $one['humidity'] . '
              </td>
            </tr>

            <tr>
              <td class="text-left">
                <b>Light Cycle:</b> ' . $one['lightcycle'] . '
              </td>
              <td class="text-center">
                <b>Fed:</b> ' . $one['fed'] . '
              </td>
              <td class="text-right">
                <b>Topped:</b> ' . $one['topped'] . ' | 
                <b>Fimmed:</b> ' . $one['fimmed'] . ' | 
                <b>Lollipopped:</b> ' . $one['lollipopped'] . '
              </td>
            </tr>
            
            <tr>
              <td colspan="3">
                <b>Notes:</b><br><br>
                ' . $one['notes'] . '
              </td>
            </tr>
          </table>
        </div>
        ';
      }

      $this->content .= '
      <table role="presentation" class="table">
        <tr>
          <td colspan="3" class="text-center text-muted">
            <h3>Lessons Learned</h3>
          </td>
        </tr>

        <tr class="bg-success">
          <td colspan="3">' . 
            $data['lessonslearned'] . '
          </td>
        </tr>
      </table>

      <table role="presentation" class="table">
        <tr>
          <td colspan="3" class="text-center text-muted">
            <h3>Harvest Review</h3>
          </td>
        </tr>
      </table>';

      foreach( $reviews as $one )
      {
        $this->content .= '
        <div id="HarvestReview' . $one['id'] . '" class="thumbnail">
          <table role="presentation" class="table bg-success">
            <tr>
              <td class="text-left" width="33%">
                <b>Date:</b> ' . $one['date'] . '
              </td>
              <td class="text-center" width="33%">
                <b>Overall Rating:</b> ';
              for( $i = 0; $i < $one['overallrating']; $i++ )
              {
                $this->content .= '<span class="glyphicon glyphicon-star" style="color: orange"></span>';
              }
              $this->content .= '
              </td>
              <td class="text-right" width="33%">
                <b>Strain:</b> ' . $one['strain'] . '
              </td>
            </tr>

            <tr>
              <td class="text-left">
                <b>Total Yield:</b> ' . $one['totalyield'] . '
              </td>
              <td class="text-center">
                <b>Delivery Medium:</b> ' . $one['deliverymedium'] . '
              </td>
              <td class="text-right">
                <b>Delivery Method:</b> ' . $one['deliverymethod'] . '
              </td>
            </tr>

            <tr>
              <td class="text-left">
                <b>Feelings Triggered:</b><br><br>' . str_replace(",", "<br>", $one['feelings'] ) . '
              </td>
              <td class="text-center">
                <b>Relieves:</b><br><br>' . str_replace( ",", "<br>", $one['relieves'] ) . '
              </td>
              <td class="text-right">
                <b>Side Effects:</b><br><br>' . str_replace( ",", "<br>", $one['sideeffects'] ) . '
              </td>
            </tr>

            <tr>
              <td class="text-left">
                <b>Terpenes:</b><br><br>' . str_replace(",", "<br>", $one['terpenes'] ) . '
              </td>
              <td class="text-center">
                <b>Taste Profile:</b>
              </td>
              <td class="text-right">
                <a href="widgets/TasteProfileGraph.php?floral=' . $one['floraltasteprofile'] . 
                '&fruity=' . $one['fruitytasteprofile'] . '&citrusy=' . $one['citrusytasteprofile'] . 
                '&woody=' . $one['woodytasteprofile'] . '&earthy=' . $one['earthytasteprofile'] . 
                '&spicy=' . $one['spicytasteprofile'] . '&sweet=' . $one['sweettasteprofile'] . 
                '&sour=' . $one['sourtasteprofile'] . '">
                <img src="widgets/TasteProfileGraph.php?floral=' . $one['floraltasteprofile'] . 
                        '&fruity=' . $one['fruitytasteprofile'] . '&citrusy=' . $one['citrusytasteprofile'] . 
                        '&woody=' . $one['woodytasteprofile'] . '&earthy=' . $one['earthytasteprofile'] . 
                        '&spicy=' . $one['spicytasteprofile'] . '&sweet=' . $one['sweettasteprofile'] . 
                        '&sour=' . $one['sourtasteprofile'] . '" width="250" height="250" /></a>
              </td>
            </tr>
            
            <tr>
              <td colspan="3">
                <b>Notes:</b><br><br>
                ' . $one['notes'] . '
              </td>
            </tr>
          </table>
        </div>
        ';
      }

      $this->content .= '
    </div>
    ';
    
    parent::Display();
  }

}

?>