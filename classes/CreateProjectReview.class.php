<?php

class CreateProjectReview extends Page
{
  
  //------------------------- Attributes -------------------------
  private $db = null;

  public $content = '';
  public $title = "CannaLogs - Create Project Review";
  public $keywords = "CannaLogs, create project review";
  
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
   * create - Creates the review in the database.
   *
   * @return array
   */
  private function create( $posted )
  {
    $projectid      = $posted['projectid'];
    $date           = $posted['date'];
    $overallrating  = $posted['overallrating'];
    $strain         = $posted['strain'];
    $totalyield     = $posted['totalyield'];
    $deliverymedium = $posted['deliverymedium'];
    $deliverymethod = $posted['deliverymethod'];
    if( isset($posted['feelings']) )
    {
      $feelings     = implode( ",", $posted['feelings'] );
    }
    if( isset($posted['relieves']) )
    {
      $relieves     = implode( ",", $posted['relieves'] );
    }
    if( isset($posted['sideeffects']) )
    {
      $sideeffects  = implode( ",", $posted['sideeffects'] );
    }
    if( isset($posted['terpenes']) )
    {
      $terpenes     = implode( ",", $posted['terpenes'] );
    }
    $floraltasteprofile   = $posted['floraltasteprofile'];
    $sweettasteprofile    = $posted['sweettasteprofile'];
    $spicytasteprofile    = $posted['spicytasteprofile'];
    $earthytasteprofile   = $posted['earthytasteprofile'];
    $woodytasteprofile    = $posted['woodytasteprofile'];
    $sourtasteprofile     = $posted['sourtasteprofile'];
    $citrusytasteprofile  = $posted['citrusytasteprofile'];
    $fruitytasteprofile   = $posted['fruitytasteprofile'];
    if( isset($posted['thcpercent']) )
    {
      $thcpercent         = $posted['thcpercent'];
    }
    if( isset($posted['cbdpercent']) )
    {
        $cbdpercent       = $posted['cbdpercent'];
    }
    if( isset($posted['cbgpercent']) )
    {
        $cbgpercent       = $posted['cbgpercent'];
    }
    if( isset($posted['cbcpercent']) )
    {
        $cbcpercent       = $posted['cbcpercent'];
    }
    if( isset($posted['cbgvpercent']) )
    {
        $cbgvpercent      = $posted['cbgvpercent'];
    }
    if( isset($posted['thcvpercent']) )
    {
        $thcvpercent      = $posted['thcvpercent'];
    }
    if( isset($posted['cbdvpercent']) )
    {
        $cbdvpercent      = $posted['cbdvpercent'];
    }
    if( isset($posted['cbcvpercent']) )
    {
        $cbcvpercent      = $posted['cbcvpercent'];
    }
    $notes                = $posted['editor'];

    // Define the query
    $query = "INSERT INTO HarvestReviews
              (projectid, date, overallrating, strain, totalyield, deliverymedium, deliverymethod, ";
    
    if( isset( $posted['feelings'] ) )
    {
      $query .= "feelings, ";
    }

    if( isset( $posted['relieves'] ) )
    {
      $query .= "relieves, ";
    }
    
    if( isset( $posted['sideeffects'] ) )
    {
      $query .= "sideeffects, ";
    }
    
    if( isset( $posted['terpenes'] ) )
    {
      $query .= "terpenes, ";
    }
    
    $query .= "floraltasteprofile, sweettasteprofile, spicytasteprofile, earthytasteprofile, woodytasteprofile, sourtasteprofile, citrusytasteprofile,
              fruitytasteprofile, ";
    
    if( isset( $posted['thcpercent'] ) )
    {
      $query .= "thcpercent, ";
    }
    
    if( isset( $posted['cbdpercent'] ) )
    {
      $query .= "cbdpercent, ";
    }
    
    if( isset( $posted['cbgpercent'] ) )
    {
      $query .= "cbgpercent, ";
    }
    
    if( isset( $posted['cbcpercent'] ) )
    {
      $query .= "cbcpercent, ";
    }
    
    if( isset( $posted['cbgvpercent'] ) )
    {
      $query .= "cbgvpercent, ";
    }
    
    if( isset( $posted['thcvpercent'] ) )
    {
      $query .= "thcvpercent, ";
    }
    
    if( isset( $posted['cbdvpercent'] ) )
    {
      $query .= "cbdvpercent, ";
    }
    
    if( isset( $posted['cbcvpercent'] ) )
    {
      $query .= "cbcvpercent, ";
    }
    $query .= "notes)
              VALUES('$projectid', '$date', '$overallrating', '$strain', '$totalyield', '$deliverymedium', '$deliverymethod', ";

    if( isset( $posted['feelings'] ) )
    {
      $query .= "'$feelings', ";
    }

    if( isset( $posted['relieves'] ) )
    {
      $query .= "'$relieves', ";
    }

    if( isset( $posted['sideeffects'] ) )
    {
      $query .= "'$sideeffects', ";
    }

    if( isset( $posted['terpenes'] ) )
    {
      $query .= "'$terpenes', ";
    }

    $query .= "'$floraltasteprofile', '$sweettasteprofile', '$spicytasteprofile', '$earthytasteprofile', '$woodytasteprofile', 
    '$sourtasteprofile', '$citrusytasteprofile','$fruitytasteprofile', ";
    
    if( isset( $posted['thcpercent'] ) )
    {
      $query .= "'$thcpercent', ";
    }

    if( isset( $posted['cbdpercent'] ) )
    {
      $query .= "'$cbdpercent', ";
    }

    if( isset( $posted['cbgpercent'] ) )
    {
      $query .= "'$cbgpercent', ";
    }

    if( isset( $posted['cbcpercent'] ) )
    {
      $query .= "'$cbcpercent', ";
    }

    if( isset( $posted['cbgvpercent'] ) )
    {
      $query .= "'$cbgvpercent', ";
    }

    if( isset( $posted['thcvpercent'] ) )
    {
      $query .= "'$thcvpercent', ";
    }

    if( isset( $posted['cbdvpercent'] ) )
    {
      $query .= "'$cbdvpercent', ";
    }

    if( isset( $posted['cbcvpercent'] ) )
    {
      $query .= "'$cbcvpercent', ";
    }

    $query .= "'$notes')";

    return $this->db->query_DB( $query );
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
   * handlePOST - Takes control of the action once the form is posted.
   *
   * @param  mixed $posted
   *
   * @return void
   */
  private function handlePOST( $posted )
  {
    $this->create( $posted );
    
    // Redirect to list of Announcements
    header( 'Location: index.php?display=ProjectDetails&id=' . $_GET['id'] );
  }

  /**
   * Display - Displays the page.
   *
   * @param  None
   *
   * @return void
   */
  public function Display()
  {print_r($_POST);
    $project = $this->getProjectDetails( $_GET['id'] );
        
    // If not an admin or the project's owner, not allowed
    if( ( ( $_SESSION['userRole'] != 0 ) && ( $project['growerid'] != $_SESSION['userID'] ) ) || 
        !isset( $_SESSION['userRole'] ) )
    {
      // Redirect to list of Announcements
      header( 'Location: index.php?display=ProjectDetails&id=' . $_GET['id'] );
      exit;
    }
    
    // Handle data
    if( isset( $_POST['editor'] ) )
    {
      $this->handlePOST( $_POST );
    }

    // Define the content
    $this->content .= '
    <ol class="breadcrumb">
      <li><a href="index.php?display=Projects">Projects</a></li>
      <li><a href="index.php?display=ProjectDetails&id=' . $_GET['id'] . '">' . $project['projectname'] . '</a></li>
      <li><a href="#">Create Harvest Review</a></li>
    </ol>
    
    <h1 class="container" id="page-title" tabindex="-1" role="heading" aria-level="1"> Add Harvest Review</h1>
    <p class="text-muted">Submit a different review for each strain in your project.</p>
    <p class="text-muted text-danger">It is recommended that you run a few tests before submitting the review to make sure it is as thorough as possible.</p>
    <hr>
    
    <form method="POST">
      <!-- The project ID needs to be stored also to identify where this review belongs. -->
      <input type="hidden" name="projectid" value="' . $_GET['id'] . '">
    
      <div class="row">

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="glyphicon glyphicon-calendar text-info"></i>
              </span>
              <input name="date" class="form-control" type="text" id="date" placeholder="YYYY-MM-DD" value="' . date('Y-m-d') . '" aria-describedby="dateHelp" required>
            </div>
            <small class="text-muted">Review Date</small>
          </div>
        </div>

        <script type="text/javascript">
          $(\'#date\').datepicker(
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
                <i class="glyphicon glyphicon-star-empty text-info"></i>
              </span>
              <select name="overallrating" class="form-control" required>
              <option></option>
              <option value="1">1 Star</option>
              <option value="2">2 Star</option>
              <option value="3">3 Star</option>
              <option value="4">4 Star</option>
              <option value="5">5 Star</option>
            </select>
            </div>
            <small class="text-muted">Overall Rating</small>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="glyphicon glyphicon-tag text-info"></i>
              </span>
              <input name="strain" class="form-control" type="text" id="strain" placeholder="LA Affie" aria-describedby="strainHelp" required>
            </div>
            <small class="text-muted">Strain Name</small>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="glyphicon glyphicon-scale text-info"></i>
              </span>
              <input name="totalyield" class="form-control" type="text" id="totalyield" placeholder="500 g" aria-describedby="totalyieldHelp" required>
            </div>
            <small class="text-muted">Total Yield</small>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="glyphicon glyphicon-star text-info"></i>
              </span>
              <select name="deliverymedium" class="form-control" required>
              <option></option>
              <option value="Concentrate">Concentrate</option>
              <option value="Dried Flower">Dried Flower</option>
              <option value="Edible">Edible</option>
              <option value="Tincture">Tincture</option>
              <option value="Topical">Topical</option>
            </select>
            </div>
            <small class="text-muted">Delivery Medium Tested</small>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="glyphicon glyphicon-star text-info"></i>
              </span>
              <select name="deliverymethod" class="form-control" required>
              <option></option>
              <option value="Applied">Applied</option>
              <option value="Dabbed">Dabbed</option>
              <option value="Eaten">Eaten</option>
              <option value="Smoked">Smoked</option>
              <option value="Vaped">Vaped</option>
            </select>
            </div>
            <small class="text-muted">Delivery Method Tested</small>
          </div>
        </div>
      
      </div>

      <div class="row">
        <div class="col-md-2">
          <h4>Feelings Triggered:</h4>
        </div>
      </div>

      <div class="row">

        <div class="col-sm-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" name="feelings[]" value="Aroused">
              </span>
              <span class="form-control">Aroused</span>
            </div>
          </div>
        </div>

        <div class="col-sm-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" name="feelings[]" value="Creative">
              </span>
              <span class="form-control">Creative</span>
            </div>
          </div>
        </div>

        <div class="col-sm-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" name="feelings[]" value="Energetic">
              </span>
              <span class="form-control">Energetic</span>
            </div>
          </div>
        </div>

        <div class="col-sm-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" name="feelings[]" value="Euphoric">
              </span>
              <span class="form-control">Euphoric</span>
            </div>
          </div>
        </div>

        <div class="col-sm-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" name="feelings[]" value="Focused">
              </span>
              <span class="form-control">Focused</span>
            </div>
          </div>
        </div>

        <div class="col-sm-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" name="feelings[]" value="Giggly">
              </span>
              <span class="form-control">Giggly</span>
            </div>
          </div>
        </div>

        <div class="col-sm-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" name="feelings[]" value="Hungry">
              </span>
              <span class="form-control">Hungry</span>
            </div>
          </div>
        </div>

        <div class="col-sm-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" name="feelings[]" value="Relaxed">
              </span>
              <span class="form-control">Relaxed</span>
            </div>
          </div>
        </div>

        <div class="col-sm-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" name="feelings[]" value="Sleepy">
              </span>
              <span class="form-control">Sleepy</span>
            </div>
          </div>
        </div>

        <div class="col-sm-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" name="feelings[]" value="Talkative">
              </span>
              <span class="form-control">Talkative</span>
            </div>
          </div>
        </div>

        <div class="col-sm-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" name="feelings[]" value="Tingly">
              </span>
              <span class="form-control">Tingly</span>
            </div>
          </div>
        </div>

        <div class="col-sm-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" name="feelings[]" value="Uplifted">
              </span>
              <span class="form-control">Uplifted</span>
            </div>
          </div>
        </div>

      </div>

      <div class="row">
        <div class="col-md-2">
          <h4>Relieves:</h4>
        </div>
      </div>

      <div class="row">

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" name="relieves[]" value="Anxiety">
              </span>
              <span class="form-control">Anxiety</span>
            </div>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" name="relieves[]" value="Cramps">
              </span>
              <span class="form-control">Cramps</span>
            </div>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" name="relieves[]" value="Depression">
              </span>
              <span class="form-control">Depression</span>
            </div>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" name="relieves[]" value="Fatigue">
              </span>
              <span class="form-control">Fatigue</span>
            </div>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" name="relieves[]" value="Glaucoma">
              </span>
              <span class="form-control">Glaucoma</span>
            </div>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" name="relieves[]" value="Headache">
              </span>
              <span class="form-control">Headache</span>
            </div>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" name="relieves[]" value="Inflammation">
              </span>
              <span class="form-control">Inflammation</span>
            </div>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" name="relieves[]" value="Insomnia">
              </span>
              <span class="form-control">Insomnia</span>
            </div>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" name="relieves[]" value="Migraine">
              </span>
              <span class="form-control">Migraine</span>
            </div>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" name="relieves[]" value="Muscle Spasms">
              </span>
              <span class="form-control">Muscle Spasms</span>
            </div>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" name="relieves[]" value="Nausea">
              </span>
              <span class="form-control">Nausea</span>
            </div>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" name="relieves[]" value="Pain">
              </span>
              <span class="form-control">Pain</span>
            </div>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" name="relieves[]" value="PTSD">
              </span>
              <span class="form-control">PTSD</span>
            </div>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" name="relieves[]" value="Stress">
              </span>
              <span class="form-control">Stress</span>
            </div>
          </div>
        </div>

      </div>

      <div class="row">
        <div class="col-md-2">
          <h4>Side Effects:</h4>
        </div>
      </div>

      <div class="row">

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" name="sideeffects[]" value="Anxiety">
              </span>
              <span class="form-control">Anxiety</span>
            </div>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" name="sideeffects[]" value="Dizzy">
              </span>
              <span class="form-control">Dizzy</span>
            </div>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" name="sideeffects[]" value="Dry Eyes">
              </span>
              <span class="form-control">Dry Eyes</span>
            </div>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" name="sideeffects[]" value="Dry Mouth">
              </span>
              <span class="form-control">Dry Mouth</span>
            </div>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" name="sideeffects[]" value="Headache">
              </span>
              <span class="form-control">Headache</span>
            </div>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" name="sideeffects[]" value="Hunger">
              </span>
              <span class="form-control">Hunger</span>
            </div>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" name="sideeffects[]" value="Paranoia">
              </span>
              <span class="form-control">Paranoia</span>
            </div>
          </div>
        </div>

      </div>

      <div class="row">
        <div class="col-md-4">
          <h4>Smell Profile (Terpenes):</h4>
          <small class="text-muted">
            Terpenes Details
            <span class="glyphicon glyphicon-info-sign text-info" style="cursor: pointer" data-toggle="modal" data-target="#TerpenesModal"></span>
          </small>
        </div>
      </div>

      <!-- Modal -->
      <div class="modal fade" id="TerpenesModal" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="SCROGModalLabel">Terpenes</h4>
            </div>
            <div class="modal-body">
              <img src="images/terpenes.jpg" width="500" height="250">
              <h4>What are they?</h4>
              <p>They are the building blocks of essential oils in plants. They endow flowers with their distinct fragrances. They also give fruits and vegetables
              distinct flavors and aromas. Plants make them to repel pests, attract pollinators, and promote the plant\'s well being. They are found in the plant\'s trichomes.
              They also have therapeutic effects.</p>
              <h4>Terpene profiles</h4>
              <p><b>Myrcene</b> - Most abundant.  Earthy scent.  Found in hops, mangoes, and lemongrass. Produces couch-lock effects. Helps with sleep or as a muscle relaxants.</p>
              <p><b>Beta-Caryophyllene</b> - Another primary terpene. Spicy scent. Found in black pepper, cinnamon, cloves, and oregano. Helps as anti-inflammatory, digestion, 
              wound healing.</p>
              <p><b>Limonene</b> - Common too. Lemony scent. Found in lemon and orange rinds. Produces uplifting effects, good for daytime productivity, depression, and anxiety.</p>
              <p><b>Linalool</b> - Found in Lavender and Lilac (purple flowers). Produces relaxation and calm. Ease stress and body aches. Good for muscle spasms, pain, and anxiety.</p>
              <p><b>Pinene</b> - The most common terpene in nature. Found in conifers, rosemary, and parsley. Reduces inflammation, aids memory, is antimicrobial, opens
              repiratory pathways.</p>
              <p><b>Humulene</b> - Found in ginseng, sage, and hops. Good for inflammation and weight control.</p>
              <p><b>Terpinolene</b> - Found in cumin, nutmeg, apples, and tea trees. Helps reducing tumor growth, and helps with cardiovascular disease.</p>
              <p><b>Alpha-Bisabolol</b> - Floral scent. Found in camomile. Has antibacterial and antioxidant properties, reduces skin inflammation.</p>
              <p><b>Eucalyptol</b> - Found in eucalyptus trees. Has antibacterial, antifungal, and insect-repelling properties.</p>
              <p><b>Geraniol</b> - Found in geraniums, citronella, and roses. Has antimicrobial, antiviral, and neuroprotective properties.</p>
              <p><b>Terpineol</b> - Found in Lilacs, pine trees, limes, and eucalyptus.  Has a pleasant floral fragrance. Helps as antioxidant, anti-malarial, and sedative.</p>
              <p><b>Farnesene</b> - Found in ginger and green apple peels. Gives plants a tart, fruity flavor. Has neuroprotective properties and may help with certain cancer
              types.</p>
              <p><b>Borneol</b> - Found in many chinese herbs including valerian root.  Aroma similar to rosemary or mint. Provides pain-relief, anti-inflammatory, and good
              for anxiety.</p>
              <p><b>Ocimene</b> - Found in Orchids, basil, and mint. Has a sweet herbal aroma. Serves as an antioxidant, antimicrobial, and fights cancer.</p>
              <p><b>Nerolidol</b> - Has a woody aroma typical of cleaning products. Potent antifungal, antioxidant, antimicrobial, and anti-inflammatory properties.</p>
              <p><b>Guaiol</b> - Has a pine fragrance. May induce cell apoptosis in lung tumors.</p>
              <p><b>Valencene</b> - Has a sweet citrus smell.  Found in oranges, grapefruits, and tangerines. Serves to repel insects, reduce inflammation, and fights
              skin cancer.</p>
              <p><b>Delta-3 Carene</b> - Found in Cypress trees. The fragrance combines pine, lemon, and musk scents. May help with fibromyalgia, Alzheimer\'s disease, and
              broken bones.</p>
              <p><b>Phytol</b> - Usually found in industrial hemp. Has a scent of jasmine.  Provides pain-relief, reduces stress, and promotes healthy sleep patterns.</p>
              <p><b>Sabinene</b> - Responsible for earthy oak aromas that whiskey makers love. It has spicy and peppery notes. May help with digestion, arthritis, calms
              skin conditions, prevents muscle atrophy.</p>
              <p><b>Phellandrene</b> - Found in eucalyptus.  Has a mint aroma with citrusy overtones. Helps with digestive problems, depression, and neuropathic pain.</p>
              <p><b>Fenchol</b> - Can be found in fennel. Has a woody and citrusy aroma.</p>
              <p><b>Menthol</b> - Helps kill bacteria and reduce inflammation.</p>
              <p><b>Terpinene</b> - Found in lesser amounts in cannabis.  Has an earthy aroma and may have anti-tumor properties.</p>
              <p><b>Isoborneol</b> - Has a sweet and musky scent. Has antiviral properties, especially against herpes type 1. Also, antioxidant, anti-inflammatory, and
              antimicrobial.</p>
              <p><b>Cymene</b> - Found in carrots, oranges, tangerines, and oregano. Has anti-inflammatory and pain relieving properties.</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>

      <div class="row">

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" name="terpenes[]" value="Myrcene">
              </span>
              <span class="form-control">Myrcene</span>
            </div>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" name="terpenes[]" value="Limonene">
              </span>
              <span class="form-control">Limonene</span>
            </div>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" name="terpenes[]" value="Linalool">
              </span>
              <span class="form-control">Linalool</span>
            </div>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" name="terpenes[]" value="Pinene">
              </span>
              <span class="form-control">Pinene</span>
            </div>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" name="terpenes[]" value="Humulene">
              </span>
              <span class="form-control">Humulene</span>
            </div>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" name="terpenes[]" value="Terpinolene">
              </span>
              <span class="form-control">Terpinolene</span>
            </div>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" name="terpenes[]" value="Alpha-Bisabolol">
              </span>
              <span class="form-control">Alpha-Bisabolol</span>
            </div>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" name="terpenes[]" value="Eucalyptol">
              </span>
              <span class="form-control">Eucalyptol</span>
            </div>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" name="terpenes[]" value="Geraniol">
              </span>
              <span class="form-control">Geraniol</span>
            </div>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" name="terpenes[]" value="Terpineol">
              </span>
              <span class="form-control">Terpineol</span>
            </div>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" name="terpenes[]" value="Farnesene">
              </span>
              <span class="form-control">Farnesene</span>
            </div>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" name="terpenes[]" value="Borneol">
              </span>
              <span class="form-control">Borneol</span>
            </div>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" name="terpenes[]" value="Ocimene">
              </span>
              <span class="form-control">Ocimene</span>
            </div>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" name="terpenes[]" value="Nerolidol">
              </span>
              <span class="form-control">Nerolidol</span>
            </div>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" name="terpenes[]" value="Guaiol">
              </span>
              <span class="form-control">Guaiol</span>
            </div>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" name="terpenes[]" value="Valencene">
              </span>
              <span class="form-control">Valencene</span>
            </div>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" name="terpenes[]" value="Delta-3 Carene">
              </span>
              <span class="form-control">Delta-3 Carene</span>
            </div>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" name="terpenes[]" value="Phytol">
              </span>
              <span class="form-control">Phytol</span>
            </div>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" name="terpenes[]" value="Sabinene">
              </span>
              <span class="form-control">Sabinene</span>
            </div>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" name="terpenes[]" value="Phellandrene">
              </span>
              <span class="form-control">Phellandrene</span>
            </div>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" name="terpenes[]" value="Fenchol">
              </span>
              <span class="form-control">Fenchol</span>
            </div>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" name="terpenes[]" value="Menthol">
              </span>
              <span class="form-control">Menthol</span>
            </div>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" name="terpenes[]" value="Terpinene">
              </span>
              <span class="form-control">Terpinene</span>
            </div>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" name="terpenes[]" value="Isoborneol">
              </span>
              <span class="form-control">Isoborneol</span>
            </div>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" name="terpenes[]" value="Cymene">
              </span>
              <span class="form-control">Cymene</span>
            </div>
          </div>
        </div>

        <div class="col-md-3">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox" name="terpenes[]" value="Beta-Caryophyllene">
              </span>
              <span class="form-control">Beta-Caryophyllene</span>
            </div>
          </div>
        </div>

      </div>
      
      <div class="row">
        <div class="col-md-2">
          <h4>Taste Profile:</h4>
        </div>
      </div>

      <div class="row">

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="glyphicon glyphicon-cutlery text-info"></i>
              </span>
              <select name="floraltasteprofile" class="form-control" required>
              <option></option>
              <option value="0">No Taste</option>
              <option value="1">Faint Taste</option>
              <option value="2">Weak Taste</option>
              <option value="3">Normal Taste</option>
              <option value="4">Strong Taste</option>
              <option value="5">Super Strong Taste</option>
            </select>
            </div>
            <small class="text-muted">Floral Taste Profile Level</small>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="glyphicon glyphicon-cutlery text-info"></i>
              </span>
              <select name="sweettasteprofile" class="form-control" required>
              <option></option>
              <option value="0">No Taste</option>
              <option value="1">Faint Taste</option>
              <option value="2">Weak Taste</option>
              <option value="3">Normal Taste</option>
              <option value="4">Strong Taste</option>
              <option value="5">Super Strong Taste</option>
            </select>
            </div>
            <small class="text-muted">Sweet Taste Profile Level</small>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="glyphicon glyphicon-cutlery text-info"></i>
              </span>
              <select name="spicytasteprofile" class="form-control" required>
              <option></option>
              <option value="0">No Taste</option>
              <option value="1">Faint Taste</option>
              <option value="2">Weak Taste</option>
              <option value="3">Normal Taste</option>
              <option value="4">Strong Taste</option>
              <option value="5">Super Strong Taste</option>
            </select>
            </div>
            <small class="text-muted">Spicy Taste Profile Level</small>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="glyphicon glyphicon-cutlery text-info"></i>
              </span>
              <select name="earthytasteprofile" class="form-control" required>
              <option></option>
              <option value="0">No Taste</option>
              <option value="1">Faint Taste</option>
              <option value="2">Weak Taste</option>
              <option value="3">Normal Taste</option>
              <option value="4">Strong Taste</option>
              <option value="5">Super Strong Taste</option>
            </select>
            </div>
            <small class="text-muted">Earthy Taste Profile Level</small>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="glyphicon glyphicon-cutlery text-info"></i>
              </span>
              <select name="woodytasteprofile" class="form-control" required>
              <option></option>
              <option value="0">No Taste</option>
              <option value="1">Faint Taste</option>
              <option value="2">Weak Taste</option>
              <option value="3">Normal Taste</option>
              <option value="4">Strong Taste</option>
              <option value="5">Super Strong Taste</option>
            </select>
            </div>
            <small class="text-muted">Woody Taste Profile Level</small>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="glyphicon glyphicon-cutlery text-info"></i>
              </span>
              <select name="sourtasteprofile" class="form-control" required>
              <option></option>
              <option value="0">No Taste</option>
              <option value="1">Faint Taste</option>
              <option value="2">Weak Taste</option>
              <option value="3">Normal Taste</option>
              <option value="4">Strong Taste</option>
              <option value="5">Super Strong Taste</option>
            </select>
            </div>
            <small class="text-muted">Sour Taste Profile Level</small>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="glyphicon glyphicon-cutlery text-info"></i>
              </span>
              <select name="citrusytasteprofile" class="form-control" required>
              <option></option>
              <option value="0">No Taste</option>
              <option value="1">Faint Taste</option>
              <option value="2">Weak Taste</option>
              <option value="3">Normal Taste</option>
              <option value="4">Strong Taste</option>
              <option value="5">Super Strong Taste</option>
            </select>
            </div>
            <small class="text-muted">Citrusy Taste Profile Level</small>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="glyphicon glyphicon-cutlery text-info"></i>
              </span>
              <select name="fruitytasteprofile" class="form-control" required>
              <option></option>
              <option value="0">No Taste</option>
              <option value="1">Faint Taste</option>
              <option value="2">Weak Taste</option>
              <option value="3">Normal Taste</option>
              <option value="4">Strong Taste</option>
              <option value="5">Super Strong Taste</option>
            </select>
            </div>
            <small class="text-muted">Fruity Taste Profile Level</small>
          </div>
        </div>

      </div>
      
      <div class="row">
        <div class="col-lg-8">
          <h4>From The Lab:</h4>
          <p class="text-muted text-danger">If you\'ve order a detailed test for this grow and know these details fill this section.</p>
        </div>
      </div>

      <div class="row">

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="glyphicon glyphicon-tag text-info"></i>
              </span>
              <input name="thcpercent" class="form-control" type="text" id="thcpercent" placeholder="10%" aria-describedby="thcpercentHelp">
            </div>
            <small class="text-muted">THC Percent</small>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="glyphicon glyphicon-tag text-info"></i>
              </span>
              <input name="cbdpercent" class="form-control" type="text" id="cbdpercent" placeholder="10%" aria-describedby="cbdpercentHelp">
            </div>
            <small class="text-muted">CBD Percent</small>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="glyphicon glyphicon-tag text-info"></i>
              </span>
              <input name="cbgpercent" class="form-control" type="text" id="cbgpercent" placeholder="10%" aria-describedby="cbgpercentHelp">
            </div>
            <small class="text-muted">CBG Percent</small>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="glyphicon glyphicon-tag text-info"></i>
              </span>
              <input name="cbcpercent" class="form-control" type="text" id="cbcpercent" placeholder="10%" aria-describedby="cbcpercentHelp">
            </div>
            <small class="text-muted">CBC Percent</small>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="glyphicon glyphicon-tag text-info"></i>
              </span>
              <input name="cbgvpercent" class="form-control" type="text" id="cbgvpercent" placeholder="10%" aria-describedby="cbgvpercentHelp">
            </div>
            <small class="text-muted">CBGV Percent</small>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="glyphicon glyphicon-tag text-info"></i>
              </span>
              <input name="thcvpercent" class="form-control" type="text" id="thcvpercent" placeholder="10%" aria-describedby="thcvpercentHelp">
            </div>
            <small class="text-muted">THCV Percent</small>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="glyphicon glyphicon-tag text-info"></i>
              </span>
              <input name="cbdvpercent" class="form-control" type="text" id="cbdvpercent" placeholder="10%" aria-describedby="cbdvpercentHelp">
            </div>
            <small class="text-muted">CBDV Percent</small>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="glyphicon glyphicon-tag text-info"></i>
              </span>
              <input name="cbcvpercent" class="form-control" type="text" id="cbcvpercent" placeholder="10%" aria-describedby="cbcvpercentHelp">
            </div>
            <small class="text-muted">CBCV Percent</small>
          </div>
        </div>

      </div>

      <div class="row">
        <div class="col-md-2">
          <h4>Detailed Notes:</h4>
        </div>
      </div>

      <textarea name="editor" id="editor" required></textarea>
      <script>
        CKEDITOR.replace( "editor" );
      </script>

      <p class="text-warning">
        To add an image, just drag it into the text area and it will automatically save it to the data that will be stored. 
        Preferably, try to keep images small in size as they will be converted to data and stored in the database.
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

    parent::Display();
  }

}

?>