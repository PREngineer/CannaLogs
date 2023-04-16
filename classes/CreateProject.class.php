<?php

protectContributor();

class CreateProject extends Page
{
  
  //------------------------- Attributes -------------------------
  private $db      = null;
  public $content  = '';
  public $title    = "CannaLogs - Create Project";
  public $keywords = "CannaLogs, create project";
  
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
    header( 'Location: index.php?display=Projects' );
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
    $projectname                = $this->db->sanitize( $posted['projectname'] );
    $growerid                   = $posted['growerid'];
    $purpose                    = $posted['purpose'];
    $location                   = $posted['location'];
    $projectstatus              = $posted['projectstatus'];
    $startdate                  = $this->db->sanitize( $posted['startdate'] );
    if( isset( $posted['usinglst'] ) )
    {
      $usinglst                 = $posted['usinglst'];
    }
    else
    {
      $usinglst                 = 'off';
    }
    if( isset( $posted['usingmonstercropping'] ) )
    {
      $usingmonstercropping       = $posted['usingmonstercropping'];
    }
    else
    {
      $usingmonstercropping     = 'off';
    }
    if( isset( $posted['usingscreenofgreen'] ) )
    {
      $usingscreenofgreen       = $posted['usingscreenofgreen'];
    }
    else
    {
      $usingscreenofgreen       = 'off';
    }
    if( isset( $posted['usingseaofgreen'] ) )
    {
      $usingseaofgreen          = $posted['usingseaofgreen'];
    }
    else
    {
      $usingseaofgreen          = 'off';
    }
    $planttags                  = $this->db->sanitize( implode( ',', $posted['planttags'] ) );
    $plantstrains               = $this->db->sanitize( implode( ',', $posted['plantstrains'] ) );
    $plantsex                   = implode( ',', $posted['plantsex'] );
    $plantvariety               = implode( ',', $posted['plantvariety'] );
    $planttype                  = implode( ',', $posted['planttype'] );
    $plantbreeders              = $this->db->sanitize( implode( ',', $posted['plantbreeders'] ) );
    $plantprices                = $this->db->sanitize( implode( ',', $posted['plantprices'] ) );
    $startermedium              = $posted['startermedium'];
    $medium                     = $posted['medium'];
    if( isset( $posted['hydromethod'] ) )
    {
      $hydromethod              = $posted['hydromethod'];
    }
    if( isset( $posted['mediumcomponents'] ) )
    {
      $mediumcomponents         = implode( ',', $posted['mediumcomponents'] );
    }
    if( isset( $posted['mediumcomponentspercentage'] ) )
    {
      $mediumcomponentspercentage = implode( ',', $posted['mediumcomponentspercentage'] );
    }
    $nutrientbrands             = $this->db->sanitize( implode( ',', $posted['nutrientbrands'] ) );
    $nutrientnames              = $this->db->sanitize( implode( ',', $posted['nutrientnames'] ) );
    $containersizeseedling      = $this->db->sanitize( $posted['containersizeseedling'] );
    $containersizevegetation    = $this->db->sanitize( $posted['containersizevegetation'] );
    $containersizeflowering     = $this->db->sanitize( $posted['containersizeflowering'] );
    $usingtent                  = $posted['usingtent'];
    if( isset( $posted['tentsize'] ) )
    {
      $tentsize                 = str_replace( "'", "ft", $posted['tentsize'] );
      $tentsize                 = $this->db->sanitize( str_replace( '"', 'in', $tentsize ) );
    }
    $lighttype                  = $posted['lighttype'];
    $lightwattage               = $this->db->sanitize( $posted['lightwattage'] );
    $usingventilationfans       = $posted['usingventilationfans'];
    if( isset( $posted['ventilationfansamount'] ) )
    {
      $ventilationfansamount    = $this->db->sanitize( $posted['ventilationfansamount'] );
    }
    if( isset( $posted['ventilationfanstype'] ) )
    {
      $ventilationfanstype      = $posted['ventilationfanstype'];
    }
    $usingextractionfan         = $posted['usingextractionfan'];
    if( isset( $posted['extractionfancfm'] ) )
    {
      $extractionfancfm         = $this->db->sanitize( $posted['extractionfancfm'] );
    }
    $usingintakefan             = $posted['usingintakefan'];
    if( isset( $posted['intakefancfm'] ) )
    {
      $intakefancfm             = $this->db->sanitize( $posted['intakefancfm'] );
    }
    $usingcarbonfilter          = $posted['usingcarbonfilter'];
    $usingdehumidifier          = $posted['usingdehumidifier'];
    $usinghumidifier            = $posted['usinghumidifier'];
    $usingheater                = $posted['usingheater'];
    $usingac                    = $posted['usingac'];
    $usingthermohygrometer      = $posted['usingthermohygrometer'];
    $usingppmphmeters           = $posted['usingppmphmeters'];
    $usingpowerstrip            = $posted['usingpowerstrip'];
    $usingtimers                = $posted['usingtimers'];
    $usingphbalancers           = $posted['usingphbalancers'];
    $usinggloves                = $posted['usinggloves'];
    $usingsunglasses            = $posted['usingsunglasses'];
    $usingspraybottles          = $posted['usingspraybottles'];
    $usingtiesstring            = $posted['usingtiesstring'];
    $usingtape                  = $posted['usingtape'];
    $usingscissors              = $posted['usingscissors'];
    $usingmagnifier             = $posted['usingmagnifier'];
    $usingmasonjars             = $posted['usingmasonjars'];
    $usingdryingrack            = $posted['usingdryingrack'];
    
    // Make change in the database
    $query = "INSERT INTO Projects
                    (projectname, growerid, purpose, location, projectstatus, startdate, usinglst, usingmonstercropping, usingscreenofgreen, usingseaofgreen, planttags, plantstrains, plantsex, 
                    plantvariety, planttype, plantbreeders, plantprices, startermedium, medium, ";

    if( isset( $posted['mediumcomponents'] ) )
    { 
      $query .=    "mediumcomponents, ";
    }
    if( isset( $posted['mediumcomponentspercentage'] ) )
    { 
      $query .=    "mediumcomponentspercentage, ";
    }

    if( isset( $posted['hydromethod'] ) )
    { 
      $query .=    "hydromethod, ";
    }
                    
    $query .=      "nutrientbrands, nutrientnames, containersizeseedling,
                    containersizevegetation, containersizeflowering, usingtent, ";

    if( isset( $posted['tentsize'] ) )
    { 
      $query .=    "tentsize, ";
    }
                    
    $query .=      "lighttype, lightwattage, usingventilationfans, ";

    if( isset( $posted['ventilationfansamount'] ) )
    { 
      $query .=    "ventilationfansamount, ";
    }

    if( isset( $posted['ventilationfanstype'] ) )
    { 
      $query .=    "ventilationfanstype, ";
    }
                    
    $query .=      "usingextractionfan, ";

    if( isset( $posted['extractionfancfm'] ) )
    { 
      $query .=    "extractionfancfm, ";
    }
                    
    $query .=      "usingintakefan, ";
    
    if( isset( $posted['intakefancfm'] ) )
    { 
      $query .=    "intakefancfm, ";
    }

    $query .=      "usingcarbonfilter,
                    usingdehumidifier, usinghumidifier, usingheater, usingac, usingthermohygrometer, usingppmphmeters, usingpowerstrip, usingtimers,
                    usingphbalancers, usinggloves, usingsunglasses, usingspraybottles, usingtiesstring, usingtape, usingscissors, usingmagnifier,
                    usingmasonjars, usingdryingrack)
                    VALUES ('$projectname', '$growerid', '$purpose', '$location', '$projectstatus', '$startdate', '$usinglst', '$usingmonstercropping', 
                    '$usingscreenofgreen', '$usingseaofgreen', '$planttags', '$plantstrains', '$plantsex', '$plantvariety', '$planttype', 
                    '$plantbreeders', '$plantprices', '$startermedium', '$medium', ";
    
    if( isset( $posted['mediumcomponents'] ) )
    { 
      $query .=     "'$mediumcomponents', ";
    }
    if( isset( $posted['mediumcomponentspercentage'] ) )
    { 
      $query .=     "'$mediumcomponentspercentage', ";
    }

    if( isset( $posted['hydromethod'] ) )
    { 
      $query .=     "'$hydromethod', ";
    }

    $query .=       "'$nutrientbrands', '$nutrientnames', '$containersizeseedling', '$containersizevegetation', '$containersizeflowering', '$usingtent', ";
    
    if( isset( $posted['tentsize'] ) )
    { 
      $query .=     "'$tentsize', ";
    }

    $query .=       "'$lighttype', '$lightwattage', '$usingventilationfans', ";
    
    if( isset( $posted['ventilationfansamount'] ) )
    { 
      $query .=     "'$ventilationfansamount', ";
    }

    if( isset( $posted['ventilationfanstype'] ) )
    { 
      $query .=     "'$ventilationfanstype', ";
    }

    $query .=       "'$usingextractionfan', ";
    
    if( isset( $posted['extractionfancfm'] ) )
    { 
      $query .=     "'$extractionfancfm', ";
    }

    $query .=       "'$usingintakefan', ";

    if( isset( $posted['intakefancfm'] ) )
    { 
      $query .=     "'$intakefancfm', ";
    }
                    
    $query .=       "'$usingcarbonfilter', '$usingdehumidifier', '$usinghumidifier', '$usingheater', '$usingac', '$usingthermohygrometer', 
                    '$usingppmphmeters', '$usingpowerstrip', '$usingtimers', '$usingphbalancers', '$usinggloves', '$usingsunglasses', '$usingspraybottles', 
                    '$usingtiesstring', '$usingtape', '$usingscissors', '$usingmagnifier', '$usingmasonjars', '$usingdryingrack')";
    
    $check = $this->db->query_DB( $query );
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
    if( isset( $_POST['projectname'] ) )
    {
      $this->handlePOST( $_POST );
    }
    
    // Set the page header
    $this->content .= '
      <ol class="breadcrumb">
        <li><a href="index.php?display=Projects">Projects</a></li>
        <li><a href="#">New Project</a></li>
      </ol>
      <h1 id="page-title" tabindex="-1" role="heading" aria-level="1">Create Project</h1>
      
      <form class="container" method="POST">

        <p><strong> Note: All fields marked with an asterisk ( <span class="text-danger">*</span> ) are required. </strong></p>

        <hr>
        <h2>General Project Details</h2>
        <hr>

        <div class="form-group">
          <label for="projectname">
            <span class="text-danger">*</span> Project Name
          </label>
          <div class="input-group">
            <span class="input-group-addon">
              <i class="glyphicon glyphicon-tag"></i>
            </span>
            <input name="projectname" type="text" class="form-control" placeholder="Flower Buds 01" aria-describedby="projectnameHelp" required>
          </div>
        </div>

        <input name="growerid" type="hidden" value="' . $_SESSION['userID'] . '">

        <div class="form-group">
          <label for="purpose">
            <span class="text-danger">*</span> Grow Purpose
          </label>
          <div class="input-group">
            <span class="input-group-addon">
              <i class="glyphicon glyphicon-glass"></i>
            </span>
            <select name="purpose" class="form-control" id="purpose" required>
              <option></option>
              <option value="Concentrate">Concentrate</option>
              <option value="Edible">Edible</option>
              <option value="Flower">Flower</option>
              <option value="Just Learning">Just Learning</option>
              <option value="Mother">Mother</option>
              <option value="Pollen">Pollen</option>
              <option value="Seeds">Seeds</option>
            </select>
          </div>
          <small id="purposeHelp" class="form-text text-muted">The new project\'s purpose.</small>
        </div>
        
        <div class="form-group">
          <label for="location">
            <span class="text-danger">*</span> Location
          </label>
          <div class="input-group">
            <span class="input-group-addon">
              <i class="glyphicon glyphicon-screenshot"></i>
            </span>
            <select name="location" class="form-control" id="location" required>
              <option></option>
              <option value="Indoor">Indoor</option>
              <option value="Outdoor">Outdoor</option>
            </select>
          </div>
        </div>

        <input name="projectstatus" type="hidden" value="In Progress">

        <div class="form-group">
          <label for="startdate"> <span class="text-danger">*</span> Start Date:</label>
          <div class="input-group">
            <span class="input-group-addon">
              <i class="glyphicon glyphicon-calendar"></i>
            </span>
            <input name="startdate" class="form-control" type="text" id="startdate" placeholder="YYYY-MM-DD" value="' . date('Y-m-d') . '" aria-describedby="startdateHelp" required>
          </div>
        </div>

        <script type="text/javascript">
          $(\'#startdate\').datepicker(
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

        <hr>
        <h2>Special Grow Techniques</h2>
        <small class="text-muted">Select the method if you plan to use it in your project.</small>
        <hr>

        <div class="row">

          <div class="col-md-3">
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon">
                  <input type="checkbox" name="usingscreenofgreen">
                </span>
                <span class="form-control">SCROG</span>
              </div>
              <small class="text-muted">
                Screen Of Green Description&nbsp;&nbsp;&nbsp;
                <span class="glyphicon glyphicon-info-sign text-info" style="cursor: pointer" data-toggle="modal" data-target="#SCROGModal"></span>
              </small>
            </div>
          </div>

          <!-- Modal -->
          <div class="modal fade" id="SCROGModal" role="dialog">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="SCROGModalLabel">SCROG - Screen Of Green</h4>
                </div>
                <div class="modal-body">
                  <img src="images/method-scrog.jpg" width="500" height="250">
                  <h4>What is it?</h4>
                  <p>This method consists of using a trellis net or mesh to force the plant to grow sideways in a controlled manner and with even lighting.</p>
                  <h4>Why do it?</h4>
                  <p>This method leads to the formation of plenty of flowers.  In the ideal case, it will end up with an even and thick carpet of flowers.</p>
                  <h4>Special Considerations</h4>
                  <p>The growth (vegetation) phase will last longer when using this method.  This method is not generally suitable for autoflower plants because of that.  
                  This method is preferable with plants that tend to shoot up when growing.</p>
                  <h4>Ideal Conditions</h4>
                  <p>It is important for plants to have enough space.  The pots should not be too close together.  1-5 plants per square meter, or 30x30 cm is enough space.
                  The mesh should be placed between the plants and the light.</p>
                  <h4>Flowering Phase</h4>
                  <p>The plant should be allowed to grow up through the netting in order for the flowers to get the maximum amount of light.  Push as many leaves 
                  as possible below the netting.</p>
                  <h4>Expected Results</h4>
                  <p>Screen Of Green should give you an increase of about 20% yield.</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-3">
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon">
                  <input type="checkbox" name="usingseaofgreen">
                </span>
                <span class="form-control">SOG</span>
              </div>
              <small class="text-muted">
                Sea Of Green Description&nbsp;&nbsp;&nbsp;
                <span class="glyphicon glyphicon-info-sign text-info" style="cursor: pointer" data-toggle="modal" data-target="#SOGModal"></span>
              </small>
            </div>
          </div>

          <!-- Modal -->
          <div class="modal fade" id="SOGModal" role="dialog">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="SOGModalLabel">SOG - Sea Of Green</h4>
                </div>
                <div class="modal-body">
                  <img src="images/method-sog.jpg" width="500" height="250">
                  <h4>What is it?</h4>
                  <p>This method consists of using lots of small plants, instead of a few large plants.  Growth (vegetation) is kept intentionally short so that the space is
                  completely filled and the light efficiency can be maximized.</p>
                  <h4>Why do it?</h4>
                  <p>This method is preferred if you want to improve the yield but minimize your growth time.</p>
                  <h4>Special Considerations</h4>
                  <p>You should use clones from the same parent plant.  It will guarantee that all plants grow the same way.  Growing identical plants for a short period
                  is the key to a successful Sea Of Green project.  Always consider the legal restrictions in your country/state as this method requires plenty of plants.</p>
                  <p>If you prefer to use seeds, make sure that the variety is the same.  Autoflowers are preferred for this method since they shift to the flowering stage 
                  within a few weeks of germination.</p>
                  <h4>Ideal Conditions</h4>
                  <p>The ideal pot size is around 15 cm and holds about 4-6 liters.  This will make the plant mature at 30-50 cm.</p>
                  <p>Leave enough space between plants so that they are not competing with each other.  Ideally, they should not touch each other initially.</p>
                  <h4>Flowering Phase</h4>
                  <p>Preferably, let it vegetate for at least 2 weeks.  Plants should start overlapping or touching each other at about the fourth week of flowering.</p>
                  <h4>Expected Results</h4>
                  <p>Sea Of Green should grant you maximum yield in minimum time.  It should allow you to do multiple harvests in a year.</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-3">
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon">
                  <input type="checkbox" name="usingmonstercropping">
                </span>
                <span class="form-control">Monster Cropping</span>
              </div>
              <small class="text-muted">
                Monster Cropping Description&nbsp;&nbsp;&nbsp;
                <span class="glyphicon glyphicon-info-sign text-info" style="cursor: pointer" data-toggle="modal" data-target="#MCModal"></span>
              </small>
            </div>
          </div>

          <div class="col-md-3">
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon">
                  <input type="checkbox" name="usinglst">
                </span>
                <span class="form-control">Low Stress Training</span>
              </div>
              <small class="text-muted">
                Low Stress Training&nbsp;&nbsp;&nbsp;
                <span class="glyphicon glyphicon-info-sign text-info" style="cursor: pointer" data-toggle="modal" data-target="#LSTModal"></span>
              </small>
            </div>
          </div>

          <!-- Modal -->
          <div class="modal fade" id="MCModal" role="dialog">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="MCModalLabel">Monster Cropping</h4>
                </div>
                <div class="modal-body">
                  <img src="images/method-mc.png" width="500" height="250">
                  <h4>What is it?</h4>
                  <p>This method consists of taking clones form a female plant that is between 2-4 weeks into the flowering stage and putting 
                  them in the vegetative light cycle.  This method also helps to increase yields or to prepare the plant for 
                  other training techniques.</p>
                  <h4>Why do it?</h4>
                  <p>By doing this, the plant will grow unusually bushy.  This growing pattern can be seen as developing more flowering sites, 
                  more side branches, or more leaves.  </p>
                  <h4>Special Considerations</h4>
                  <p>Using this method takes more time as you have to give the clones time to switch from flowering to vegetation.  This method
                  does not work with autoflower plants.  Flowering clones have a lower success rate than vegetative clones.</p>
                  <h4>Expected Results</h4>
                  <p>If everything goes correct and the plant is able to develop more flowering sites or branches, your yield will increase when
                  compared to the mother plant.</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>

          <!-- Modal -->
          <div class="modal fade" id="LSTModal" role="dialog">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="LSTModalLabel">Low Stress Training</h4>
                </div>
                <div class="modal-body">
                  <img src="images/method-lst.jpg" width="500" height="250">
                  <h4>What is it?</h4>
                  <p>This method consists of manipulating your plant as much as possible without causing a stress response.  This allows you to 
                  give a specific shape to the plant while it grows.</p>
                  <h4>Why do it?</h4>
                  <p>If your plant\'s top is growing too high compared to the rest, you can bend it and allow the lower parts of the plant to "catch up" with it.  
                  The idea is to keep all stems about the same distance from the light.  You want to continually bend the tallest stems down.</p>
                  <h4>Special Considerations</h4>
                  <p>Do not use wires or materials that can cut into the plant.  Use soft materials like a wire with rubber coating, wool, or ribbons.</p>
                  <h4>Expected Results</h4>
                  <p>You will have an even canopy and similar light exposure for all stems and branches.</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>

        </div>  
        
        <hr>
        <h2><span class="text-danger">*</span> Plant Details</h2>
        <hr>
        
        <div class="form-group">
          <div class="input-group">
            <table class="table" id="plantdetailstable">
              <thead>
                <tr>
                  <th>
                    Tag
                  </th>
                  <th>
                    Strain
                  </th>
                  <th>
                    Sex
                  </th>
                  <th>
                    Variety
                  </th>
                  <th>
                    Type
                  </th>
                  <th>
                    Breeder/Provider
                  </th>
                  <th>
                    Price Per Seed/Clone
                  </th>
                </tr>
              </thead>

              <tbody>
                <tr>
                  <td>
                    <input name=\'planttags[]\' type=\'text\' class=\'form-control\' placeholder=\'Tag Number\' aria-describedby=\'planttagsHelp\' required>
                  </td>
                  <td>
                    <input name=\'plantstrains[]\' type=\'text\' class=\'form-control\' placeholder=\'Grand Daddy Purple\' aria-describedby=\'plantstrainsHelp\' required>
                  </td>
                  <td>
                    <select name=\'plantsex[]\' class=\'form-control\' id=\'plantsex\' required>
                      <option></option>
                      <option value=\'F\'>F</option>
                      <option value=\'M\'>M</option>
                      <option value=\'Unknown\'>Unknown</option>
                    </select>
                  </td>
                  <td>
                    <select name=\'plantvariety[]\' class=\'form-control\' id=\'plantvariety\' required>
                      <option></option>
                      <option value=\'Hybrid\'>Hybrid</option>
                      <option value=\'Indica\'>Indica</option>
                      <option value=\'Sativa\'>Sativa</option>
                      <option value=\'Unknown\'>Unknown</option>
                    </select>
                  </td>
                  <td>
                    <select name=\'planttype[]\' class=\'form-control\' id=\'planttype\' required>
                      <option></option>
                      <option value=\'Auto\'>Auto</option>
                      <option value=\'Photo\'>Photo</option>
                      <option value=\'Unknown\'>Unknown</option>
                    </select>
                  </td>
                  <td>
                    <input name=\'plantbreeders[]\' type=\'text\' class=\'form-control\' placeholder=\'Great Seeds\' aria-describedby=\'plantbreedersHelp\' required>
                  </td>
                  <td>
                    <input name=\'plantprices[]\' type=\'text\' class=\'form-control\' placeholder=\'$100 / €85\' aria-describedby=\'plantpricesHelp\' required>
                  </td>
                </tr>
              </tbody>
            </table>
            <span style="color: blue; cursor: pointer;" onClick="addPlantDetailsRow()"><span class="glyphicon glyphicon-plus"></span> Add Row</span>&nbsp;&nbsp;
            <span style="color: red; cursor: pointer;" onClick="deletePlantDetailsRow()"><span class="glyphicon glyphicon-minus"></span> Remove Last Row</span>
          </div>
          <small id="plantdetailsHelp" class="form-text text-muted">Add a row per plant.</small>
        </div>

        <script>
          function addPlantDetailsRow()
          {
            // Get the Table to modify
            var table = document.getElementById("plantdetailstable");

            // Insert a new row
            var row = table.insertRow();

            // Insert new cells
            var cell = row.insertCell();
            cell.innerHTML = "<input name=\'planttags[]\' type=\'text\' class=\'form-control\' placeholder=\'Tag Number\' aria-describedby=\'planttagsHelp\' required>";
            cell = row.insertCell();
            cell.innerHTML = "<input name=\'plantstrains[]\' type=\'text\' class=\'form-control\' placeholder=\'Grand Daddy Purple\' aria-describedby=\'plantstrainsHelp\' required>";
            cell = row.insertCell();
            cell.innerHTML = "<select name=\'plantsex[]\' class=\'form-control\' id=\'plantsex\' required><option></option><option value=\'F\'>F</option><option value=\'M\'>M</option><option value=\'Unknown\'>Unknown</option></select>";
            cell = row.insertCell();
            cell.innerHTML = "<select name=\'plantvariety[]\' class=\'form-control\' id=\'plantvariety\' required><option></option><option value=\'Hybrid\'>Hybrid</option><option value=\'Indica\'>Indica</option><option value=\'Sativa\'>Sativa</option><option value=\'Unknown\'>Unknown</option></select>";
            cell = row.insertCell();
            cell.innerHTML = "<select name=\'planttype[]\' class=\'form-control\' id=\'planttype\' required><option></option><option value=\'Auto\'>Auto</option><option value=\'Photo\'>Photo</option><option value=\'Unknown\'>Unknown</option></select>";
            cell = row.insertCell();
            cell.innerHTML = "<input name=\'plantbreeders[]\' type=\'text\' class=\'form-control\' placeholder=\'Great Seeds\' aria-describedby=\'plantbreedersHelp\' required>";
            cell = row.insertCell();
            cell.innerHTML = "<input name=\'plantprices[]\' type=\'text\' class=\'form-control\' placeholder=\'$100 / €85\' aria-describedby=\'plantpricesHelp\' required>";
          }
          function deletePlantDetailsRow()
          {
            // Get the Table to modify
            var table = document.getElementById("plantdetailstable");

            // Remove last row
            if( table.rows.length-1 > 1)
            {
              table.deleteRow( table.rows.length-1 );
            }
          }
        </script>

        <hr>
        <h2>Grow Medium Details</h2>
        <hr>
        
        <div class="form-group">
          <label for="startermedium">
            <span class="text-danger">*</span> Starter Grow Medium
          </label>
          <div class="input-group">
            <span class="input-group-addon">
              <i class="glyphicon glyphicon-tint text-warning"></i>
            </span>
            <select name="startermedium" class="form-control" id="startermedium" required>
              <option></option>
              <option value="Clay Pellets">Clay Pellets</option>
              <option value="Jiffy Pellet">Jiffy Pellet</option>
              <option value="Paper Towel">Paper Towel</option>
              <option value="Peat Pellet">Peat Pellet</option>
              <option value="Rockwool Cube">Rockwool Cube</option>
              <option value="Soil">Soil</option>
              <option value="Water">Water</option>
            </select>
          </div>
          <small id="startermediumHelp" class="form-text text-muted">What method you use to grow roots from seeds or clones.</small>
        </div>
        
        <div class="form-group">
          <label for="medium">
            <span class="text-danger">*</span> Grow Medium
          </label>
          <div class="input-group">
            <span class="input-group-addon">
              <i class="glyphicon glyphicon-tint text-success"></i>
            </span>
            <select name="medium" class="form-control" id="medium" required>
              <option></option>
              <option value="Soil">Soil</option>
              <option value="Blend">Blend</option>
              <option value="Hydroponic">Hydroponic</option>
            </select>
          </div>
          <small id="mediumHelp" class="form-text text-muted">The grow medium where you will be transplanting your young plant.</small>
        </div>

        <script>
          $(document).ready(function()
          {
              $(\'#medium\').on(\'change\', function()
              {
                if ( this.value == \'Blend\')
                {
                  $("#mediumcomponentsdiv").html(\'<label for="mediumcomponents"><span class="text-danger">*</span> Grow Medium Components</label><div class="input-group"><table class="table" id="mediumcomponentstable"><thead><tr><th>Component Name</th><th>Percentage</th></tr></thead><tbody><tr><td><input name="mediumcomponents[]" type="text" class="form-control" placeholder="Soil" aria-describedby="mediumcomponentsHelp" required></td><td><input name="mediumcomponentspercentage[]" type="text" class="form-control" placeholder="80" aria-describedby="mediumcomponentspercentageHelp" required></td></tr></tbody></table><span style="color: blue; cursor: pointer;" onClick="addGrowMediumComponentsRow()"><span class="glyphicon glyphicon-plus"></span> Add Row</span>&nbsp;&nbsp;<span style="color: red; cursor: pointer;" onClick="deleteGrowMediumComponentsRow()"><span class="glyphicon glyphicon-minus"></span> Remove Last Row</span></div><small id="mediumcomponentsHelp" class="form-text text-muted">Create a list of all of the grow medium components and their percentage. One row per component.</small>\');
                }
                else
                {
                  $("#mediumcomponentsdiv").html(\'\');
                }
              });

              $(\'#medium\').on(\'change\', function()
              {
                  if ( this.value == \'Hydroponic\')
                  {
                      $("#hydromethoddiv").html(\'<label for="hydromethod"><span class="text-danger">*</span> Hydro Method</label><div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-tint"></i></span><select name="hydromethod" class="form-control" id="hydromethod" required><option></option><option value="Aeroponics">Aeroponics</option><option value="Deep Water Culture (DWC)">Deep Water Culture (DWC)</option><option value="Drip">Drip</option><option value="Ebb & Flow">Ebb & Flow</option><option value="Kratky">Kratky</option><option value="Nutrient Film">Nutrient Film</option><option value="Wick">Wick</option></select></div><small id="mediumcomponentsHelp" class="form-text text-muted">Represents the hydroponic method that you will use in your grow. <span data-toggle="modal" data-target="#hydromethodmodal" style="cursor: pointer; color: blue">Click here for details if you are not sure.</span></small>\');
                  }
                  else
                  {
                      $("#hydromethoddiv").html(\'\');
                  }
              });
          });
        </script>

        <div class="form-group" id="mediumcomponentsdiv"></div>

        <div class="modal fade" tabindex="-1" role="dialog" id="hydromethodmodal">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Hydroponic Growth Methods</h4>
              </div>
              <div class="modal-body text-center">
                <div class="panel panel-primary">
                  <div class="panel-heading">Aeroponics</div>
                  <div class="panel-body">
                    <img src="../images/method-aeroponics.jpg" alt="Aeroponics Method" height="400" width="500">
                  </div>
                </div>
                <div class="panel panel-primary">
                  <div class="panel-heading">Drip</div>
                  <div class="panel-body">
                    <img src="../images/method-drip.jpg" alt="Drip Method" height="400" width="500">
                  </div>
                </div>
                <div class="panel panel-primary">
                  <div class="panel-heading">Deep Water Culture</div>
                  <div class="panel-body">
                    <img src="../images/method-dwc.jpg" alt="Deep Water Culture Method" height="400" width="500">
                  </div>
                </div>
                <div class="panel panel-primary">
                  <div class="panel-heading">Ebb & Flow</div>
                  <div class="panel-body">
                    <img src="../images/method-ebbAndFlow.jpg" alt="Ebb & Flow Method" height="400" width="500">
                  </div>
                </div>
                <div class="panel panel-primary">
                  <div class="panel-heading">Kratky</div>
                  <div class="panel-body">
                    <img src="../images/method-kratky.jpg" alt="Kratky Method" height="400" width="500">
                  </div>
                </div>
                <div class="panel panel-primary">
                  <div class="panel-heading">Nutrient Film</div>
                  <div class="panel-body">
                    <img src="../images/method-nutrientFilm.jpg" alt="Nutrient Film Method" height="400" width="500">
                  </div>
                </div>
                <div class="panel panel-primary">
                  <div class="panel-heading">Wick</div>
                  <div class="panel-body">
                    <img src="../images/method-wick.jpg" alt="Wick Method" height="400" width="500">
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>

        <script>
          function addGrowMediumComponentsRow()
          {
            // Get the Table to modify
            var table = document.getElementById("mediumcomponentstable");

            // Insert a new row
            var row = table.insertRow();

            // Insert new cells
            var cell = row.insertCell();
            cell.innerHTML = "<input name=\'mediumcomponents[]\' type=\'text\' class=\'form-control\' placeholder=\'Soil\' aria-describedby=\'mediumcomponentsHelp\' required>";
            cell = row.insertCell();
            cell.innerHTML = "<input name=\'mediumcomponentspercentage[]\' type=\'text\' class=\'form-control\' placeholder=\'80\' aria-describedby=\'mediumcomponentspercentageHelp\' required>";
          }
          function deleteGrowMediumComponentsRow()
          {
            // Get the Table to modify
            var table = document.getElementById("mediumcomponentstable");

            // Remove last row
            if( table.rows.length-1 > 1)
            {
              table.deleteRow( table.rows.length-1 );
            }
          }
        </script>

        <div class="form-group" id="hydromethoddiv"></div>
        
        <div class="form-group">
          <label for="containersize">
            <span class="text-danger">*</span> Container Sizes &nbsp;&nbsp;&nbsp;
            <i class="glyphicon glyphicon-leaf" style="color: orange">=Seed/Clone</i> &nbsp;
            <i class="glyphicon glyphicon-grain" style="color: green">=Vegetation</i> &nbsp;
            <i class="glyphicon glyphicon-tree-deciduous" style="color: purple">=Flowering</i>
          </label>
          <div class="input-group">
            <span class="input-group-addon">
              <i class="glyphicon glyphicon-leaf" style="color: orange"></i>
            </span>
            <input name="containersizeseedling" type="text" class="form-control" placeholder="3 oz" aria-describedby="containersizeHelp" required>
          </div>
          <div class="input-group">
            <span class="input-group-addon">
              <i class="glyphicon glyphicon-grain" style="color: green"></i>
            </span>
            <input name="containersizevegetation" type="text" class="form-control" placeholder="3 gal" aria-describedby="containersizeHelp" required>
          </div>
          <div class="input-group">
            <span class="input-group-addon">
              <i class="glyphicon glyphicon-tree-deciduous" style="color: purple"></i>
            </span>
            <input name="containersizeflowering" type="text" class="form-control" placeholder="5 gal" aria-describedby="containersizeHelp" required>
          </div>
            <small id="containersizeHelp" class="form-text text-muted">The size of the container in each phase. Please provide amount and units (ml, oz, cup, l, gal).
            </small>
        </div>
        
        <div class="form-group">
          <div class="input-group">
            <table class="table" id="nutrientslisttable">
              <thead>
                <tr>
                  <th>
                    <span class="text-danger">*</span> Nutrient / Additive Brand
                  </th>
                  <th>
                    <span class="text-danger">*</span> Nutrient / Additive Name
                  </th>
                </tr>
              </thead>

              <tbody>
                <tr>
                  <td>
                    <input name=\'nutrientbrands[]\' type=\'text\' class=\'form-control\' placeholder=\'General Hydroponics\' aria-describedby=\'nutrientbrandsHelp\' required>
                  </td>
                  <td>
                    <input name=\'nutrientnames[]\' type=\'text\' class=\'form-control\' placeholder=\'MaxiGrow\' aria-describedby=\'nutrientnamesHelp\' required>
                  </td>
                </tr>
              </tbody>
            </table>
            <span style="color: blue; cursor: pointer;" onClick="addNutrientsListRow()"><span class="glyphicon glyphicon-plus"></span> Add Row</span>&nbsp;&nbsp;
            <span style="color: red; cursor: pointer;" onClick="deleteNutrientsListRow()"><span class="glyphicon glyphicon-minus"></span> Remove Last Row</span>
          </div>
          <small id="plantdetailsHelp" class="form-text text-muted">Add a row per nutrient.</small>
        </div>

        <script>
          function addNutrientsListRow()
          {
            // Get the Table to modify
            var table = document.getElementById("nutrientslisttable");

            // Insert a new row
            var row = table.insertRow();

            // Insert new cells
            var cell = row.insertCell();
            cell.innerHTML = "<input name=\'nutrientbrands[]\' type=\'text\' class=\'form-control\' placeholder=\'General Hydroponics\' aria-describedby=\'nutrientbrandsHelp\' required>";
            cell = row.insertCell();
            cell.innerHTML = "<input name=\'nutrientnames[]\' type=\'text\' class=\'form-control\' placeholder=\'MaxiGrow\' aria-describedby=\'nutrientnamesHelp\' required>";
            cell = row.insertCell();
          }
          function deleteNutrientsListRow()
          {
            // Get the Table to modify
            var table = document.getElementById("nutrientslisttable");

            // Remove last row
            if( table.rows.length-1 > 1)
            {
              table.deleteRow( table.rows.length-1 );
            }
          }
        </script>

        <hr>
        <h2>Grow Equipment Details</h2>
        <hr>
        
        <div class="form-group">
          <label for="tentinformation">
            <span class="text-danger">*</span> Tent Information
          </label>
          <div class="input-group">
            <span class="input-group-addon">
              <i class="glyphicon glyphicon-tent"> Are you using a tent?</i>
            </span>
            <select name="usingtent" class="form-control" id="usingtent" required>
              <option></option>
              <option value="Yes">Yes</option>
              <option value="No">No</option>
            </select>
          </div>
          <div class="input-group" id="tentsize"></div>
        </div>

        <script>
          $(document).ready(function()
          {
              $(\'#usingtent\').on(\'change\', function()
              {
                if ( this.value == \'Yes\')
                {
                  $("#tentsize").html(\'<span class="input-group-addon"><i class="glyphicon glyphicon-resize-full"> Provide Your Tent Size</i></span><input name="tentsize" type="text" class="form-control" placeholder="36x36x72" aria-describedby="tentsizeHelp" required>\');
                }
                else
                {
                  $("#tentsize").html(\'\');;
                }
              });
          });
        </script>
        
        <div class="form-group">
          <label for="lightbrand">
            <span class="text-danger">*</span> Lighting
          </label>
          <div class="input-group">
            <span class="input-group-addon">
              <i class="glyphicon glyphicon-lamp"> Type:</i>
            </span>
            <select name="lighttype" class="form-control" required>
              <option></option>
              <option value="Compact Fluorescent Lights (CFL)">Compact Fluorescent Lights (CFL)</option>
              <option value="Chip On Board LED (COB)">Chip On Board LED (COB)</option>
              <option value="High Intensity Discharge (HID)">High Intensity Discharge (HID)</option>
              <option value="Incandescent">Incandescent</option>
              <option value="Light Emitting Ceramic (LEC)">Light Emitting Ceramic (LEC)</option>
              <option value="Light Emitting Diodes (LED)">Light Emitting Diodes (LED)</option>
              <option value="Mixed">Mixed</option>
              <option value="Natural">Natural</option>
            </select>
          </div>
          <div class="input-group">
            <span class="input-group-addon">
              <i class="glyphicon glyphicon-flash"> Watts</i>
            </span>
            <input name="lightwattage" type="text" class="form-control" placeholder="1500W" aria-describedby="lightwattageHelp" required>
          </div>
        </div>
        
        <div class="form-group">
          <label for="usingventilationfans">
            <span class="text-danger">*</span> Ventilation Fan(s)
          </label>
          <div class="input-group">
            <span class="input-group-addon">
              <i class="glyphicon glyphicon-cd"> Are you using fans?</i>
            </span>
            <select name="usingventilationfans" class="form-control" id="usingventilationfans" required>
              <option></option>
              <option value="Yes">Yes</option>
              <option value="No">No</option>
            </select>
          </div>
          <div class="input-group" id="ventilationfansamount"></div>
          <div class="input-group" id="ventilationfanstype"></div>
        </div>

        <script>
          $(document).ready(function()
          {
              $(\'#usingventilationfans\').on(\'change\', function()
              {
                if ( this.value == \'Yes\')
                {
                  $("#ventilationfansamount").html(\'<span class="input-group-addon"><i class="glyphicon glyphicon-cd"> Amount &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</i></span><input name="ventilationfansamount" type="text" class="form-control" placeholder="2" aria-describedby="ventilationfansamountHelp" required>\');
                  $("#ventilationfanstype").html(\'<span class="input-group-addon"><i class="glyphicon glyphicon-cd"> Type: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</i></span><select name="ventilationfanstype" class="form-control" id="ventilationfanstype" required><option></option><option value="Clip On">Clip On</option><option value="Pedestal">Pedestal</option><option value="Tower">Tower</option><option value="Mixed">Mixed</option></select>\');
                }
                else
                {
                  $("#ventilationfansamount").html(\'\');
                  $("#ventilationfanstype").html(\'\');
                }
              });
          });
        </script>

        <div class="form-group">
          <label for="usingextractionfan">
            <span class="text-danger">*</span> Extraction Fan
          </label>
          <div class="input-group">
            <span class="input-group-addon">
              <i class="glyphicon glyphicon-cd"> Are you using an extraction fan?</i>
            </span>
            <select name="usingextractionfan" class="form-control" id="usingextractionfan" required>
              <option></option>
              <option value="Yes">Yes</option>
              <option value="No">No</option>
            </select>
          </div>
          <div class="input-group" id="extractionfancfm"></div>
          <small id="extractionfancfmHelp" class="form-text text-muted text-danger"></small>
        </div>

        <script>
          $(document).ready(function()
          {
              $(\'#usingextractionfan\').on(\'change\', function()
              {
                if ( this.value == \'Yes\')
                {
                  $("#extractionfancfm").html(\'<span class="input-group-addon"><i class="glyphicon glyphicon-cd"> CFM &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</i></span><input name="extractionfancfm" type="text" class="form-control" placeholder="400" aria-describedby="extractionfancfmHelp" required>\');
                  $("#extractionfancfmHelp").html(\'CFM = Cubic Feet / Minute\');
                }
                else
                {
                  $("#extractionfancfm").html(\'\');
                  $("#extractionfancfmHelp").html(\'\');
                }
              });
          });
        </script>

        <div class="form-group">
          <label for="usingintakefan">
            <span class="text-danger">*</span> Intake Fan
          </label>
          <div class="input-group">
            <span class="input-group-addon">
              <i class="glyphicon glyphicon-cd"> Are you using an intake fan?</i>
            </span>
            <select name="usingintakefan" class="form-control" id="usingintakefan" required>
              <option></option>
              <option value="Yes">Yes</option>
              <option value="No">No</option>
            </select>
          </div>
          <div class="input-group" id="intakefancfm"></div>
          <small id="intakefancfmHelp" class="form-text text-muted text-danger"></small>
        </div>

        <script>
          $(document).ready(function()
          {
              $(\'#usingintakefan\').on(\'change\', function()
              {
                if ( this.value == \'Yes\')
                {
                  $("#intakefancfm").html(\'<span class="input-group-addon"><i class="glyphicon glyphicon-cd"> CFM &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</i></span><input name="intakefancfm" type="text" class="form-control" placeholder="400" aria-describedby="intakefancfmHelp" required>\');
                  $("#intakefancfmHelp").html(\'CFM = Cubic Feet / Minute\');
                }
                else
                {
                  $("#intakefancfm").html(\'\');
                  $("#intakefancfmHelp").html(\'\');
                }
              });
          });
        </script>

        <div class="form-group">
          <label for="usingcarbonfilter">
            <span class="text-danger">*</span> Carbon Filter
          </label>
          <div class="input-group">
            <span class="input-group-addon">
              <i class="glyphicon glyphicon-log-in"> Are you using a carbon filter?</i>
            </span>
            <select name="usingcarbonfilter" class="form-control" id="usingcarbonfilter" required>
              <option></option>
              <option value="Yes">Yes</option>
              <option value="No">No</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label for="usingdehumidifier">
            <span class="text-danger">*</span> De-Humidifier
          </label>
          <div class="input-group">
            <span class="input-group-addon">
              <i class="glyphicon glyphicon-cloud-download"> Are you using a de-humidifier?</i>
            </span>
            <select name="usingdehumidifier" class="form-control" id="usingdehumidifier" required>
              <option></option>
              <option value="Yes">Yes</option>
              <option value="No">No</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label for="usinghumidifier">
            <span class="text-danger">*</span> Humidifier
          </label>
          <div class="input-group">
            <span class="input-group-addon">
              <i class="glyphicon glyphicon-cloud-upload"> Are you using a humidifier?</i>
            </span>
            <select name="usinghumidifier" class="form-control" id="usinghumidifier" required>
              <option></option>
              <option value="Yes">Yes</option>
              <option value="No">No</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label for="usingheater">
            <span class="text-danger">*</span> Space Heater
          </label>
          <div class="input-group">
            <span class="input-group-addon">
              <i class="glyphicon glyphicon-fire"> Are you using a space heater?</i>
            </span>
            <select name="usingheater" class="form-control" id="usingheater" required>
              <option></option>
              <option value="Yes">Yes</option>
              <option value="No">No</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label for="usingac">
            <span class="text-danger">*</span> Air Conditioning (Cooling)
          </label>
          <div class="input-group">
            <span class="input-group-addon">
              <i class="glyphicon glyphicon-transfer"> Are you using an air conditioner?</i>
            </span>
            <select name="usingac" class="form-control" id="usingac" required>
              <option></option>
              <option value="Yes">Yes</option>
              <option value="No">No</option>
            </select>
          </div>
        </div>

        <hr>
        <h2>Additional Gear Details</h2>
        <hr>

        <div class="form-group">
          <label for="usingthermohygrometer">
            <span class="text-danger">*</span> Thermometer/Hygrometer
          </label>
          <div class="input-group">
            <span class="input-group-addon">
              <i class="glyphicon glyphicon-scale"> Are you using a Thermometer/Hygrometer?</i>
            </span>
            <select name="usingthermohygrometer" class="form-control" id="usingthermohygrometer" required>
              <option></option>
              <option value="Yes">Yes</option>
              <option value="No">No</option>
            </select>
          </div>
          <small id="replaceHelp" class="form-text text-muted">Thermometer = Device to measure temperature.<br>Hygrometer = Device to measure humidity.</small>
        </div>

        <div class="form-group">
          <label for="usingppmphmeters">
            <span class="text-danger">*</span> PPM/PH Meters
          </label>
          <div class="input-group">
            <span class="input-group-addon">
              <i class="glyphicon glyphicon-scale"> Are you using PPM/PH meters?</i>
            </span>
            <select name="usingppmphmeters" class="form-control" id="usingppmphmeters" required>
              <option></option>
              <option value="Yes">Yes</option>
              <option value="No">No</option>
            </select>
          </div>
          <small id="usingppmphmetersHelp" class="form-text text-muted">PPM (Parts Per Million) = Amount of nutrients in the grow medium.<br>PH (Potential of Hydrogen) = Acidity of the grow medium.</small>
        </div>

        <div class="form-group">
          <label for="usingpowerstrip">
            <span class="text-danger">*</span> Power Strips
          </label>
          <div class="input-group">
            <span class="input-group-addon">
              <i class="glyphicon glyphicon-flash"> Are you using a power strip?</i>
            </span>
            <select name="usingpowerstrip" class="form-control" id="usingpowerstrip" required>
              <option></option>
              <option value="Yes">Yes</option>
              <option value="No">No</option>
            </select>
          </div>
          <small id="usingpowerstripHelp" class="form-text text-muted">A device that multiplies your outlet connectors.</small>
        </div>

        <div class="form-group">
          <label for="usingtimers">
            <span class="text-danger">*</span> Timers
          </label>
          <div class="input-group">
            <span class="input-group-addon">
              <i class="glyphicon glyphicon-time"> Are you using timers?</i>
            </span>
            <select name="usingtimers" class="form-control" id="usingtimers" required>
              <option></option>
              <option value="Yes">Yes</option>
              <option value="No">No</option>
            </select>
          </div>
          <small id="usingtimersHelp" class="form-text text-muted">A device that turns outlets on and off on a schedule.</small>
        </div>

        <div class="form-group">
          <label for="usingphbalancers">
            <span class="text-danger">*</span> PH Balancers
          </label>
          <div class="input-group">
            <span class="input-group-addon">
              <i class="glyphicon glyphicon-sort"> Are you using PH balancers?</i>
            </span>
            <select name="usingphbalancers" class="form-control" id="usingphbalancers" required>
              <option></option>
              <option value="Yes">Yes</option>
              <option value="No">No</option>
            </select>
          </div>
          <small id="usingphbalancersHelp" class="form-text text-muted">These are solutions that raise or lower the grow medium\'s acidity.</small>
        </div>

        <div class="form-group">
          <label for="usinggloves">
            <span class="text-danger">*</span> Gloves
          </label>
          <div class="input-group">
            <span class="input-group-addon">
              <i class="glyphicon glyphicon-thumbs-up"> Are you using gloves?</i>
            </span>
            <select name="usinggloves" class="form-control" id="usinggloves" required>
              <option></option>
              <option value="Yes">Yes</option>
              <option value="No">No</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label for="usingsunglasses">
            <span class="text-danger">*</span> Sunglasses
          </label>
          <div class="input-group">
            <span class="input-group-addon">
              <i class="glyphicon glyphicon-eye-open"> Are you using a sunglasses?</i>
            </span>
            <select name="usingsunglasses" class="form-control" id="usingsunglasses" required>
              <option></option>
              <option value="Yes">Yes</option>
              <option value="No">No</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label for="usingspraybottles">
            <span class="text-danger">*</span> Spray Bottles
          </label>
          <div class="input-group">
            <span class="input-group-addon">
              <i class="glyphicon glyphicon-baby-formula"> Are you using Spray Bottles?</i>
            </span>
            <select name="usingspraybottles" class="form-control" id="usingspraybottles" required>
              <option></option>
              <option value="Yes">Yes</option>
              <option value="No">No</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label for="usingtiesstring">
            <span class="text-danger">*</span> Ties/Strings/Nets
          </label>
          <div class="input-group">
            <span class="input-group-addon">
              <i class="glyphicon glyphicon-paperclip"> Are you using Ties/Strings/Nets?</i>
            </span>
            <select name="usingtiesstring" class="form-control" id="usingtiesstring" required>
              <option></option>
              <option value="Yes">Yes</option>
              <option value="No">No</option>
            </select>
          </div>
          <small id="usingtiesstringHelp" class="form-text text-muted">Used for Low Stress Training.</small>
        </div>

        <div class="form-group">
          <label for="usingtape">
            <span class="text-danger">*</span> Tape
          </label>
          <div class="input-group">
            <span class="input-group-addon">
              <i class="glyphicon glyphicon-menu-hamburger"> Are you using Tape?</i>
            </span>
            <select name="usingtape" class="form-control" id="usingtape" required>
              <option></option>
              <option value="Yes">Yes</option>
              <option value="No">No</option>
            </select>
          </div>
          <small id="usingtiesstringHelp" class="form-text text-muted">Reflective tape to prevent light leaks inside the water in hydroponics.</small>
        </div>

        <div class="form-group">
          <label for="usingscissors">
            <span class="text-danger">*</span> Pruning Scissors
          </label>
          <div class="input-group">
            <span class="input-group-addon">
              <i class="glyphicon glyphicon-scissors"> Are you using Pruning Scissors?</i>
            </span>
            <select name="usingscissors" class="form-control" id="usingscissors" required>
              <option></option>
              <option value="Yes">Yes</option>
              <option value="No">No</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label for="usingmagnifier">
            <span class="text-danger">*</span> Magnifier
          </label>
          <div class="input-group">
            <span class="input-group-addon">
              <i class="glyphicon glyphicon-search"> Are you using a Magnifier/Jewelers Loupe/Camera?</i>
            </span>
            <select name="usingmagnifier" class="form-control" id="usingmagnifier" required>
              <option></option>
              <option value="Yes">Yes</option>
              <option value="No">No</option>
            </select>
          </div>
          <small id="usingtiesstringHelp" class="form-text text-muted">Used to monitor the trichomes in the flowering stage.</small>
        </div>

        <div class="form-group">
          <label for="usingmasonjars">
            <span class="text-danger">*</span> Mason Jars
          </label>
          <div class="input-group">
            <span class="input-group-addon">
              <i class="glyphicon glyphicon-oil"> Are you using Mason Jars?</i>
            </span>
            <select name="usingmasonjars" class="form-control" id="usingmasonjars" required>
              <option></option>
              <option value="Yes">Yes</option>
              <option value="No">No</option>
            </select>
          </div>
          <small id="usingtiesstringHelp" class="form-text text-muted">Used to cure and store the buds after harvest.</small>
        </div>

        <div class="form-group">
          <label for="usingdryingrack">
            <span class="text-danger">*</span> Drying Rack
          </label>
          <div class="input-group">
            <span class="input-group-addon">
              <i class="glyphicon glyphicon-pushpin"> Are you using a Drying Rack?</i>
            </span>
            <select name="usingdryingrack" class="form-control" id="usingdryingrack" required>
              <option></option>
              <option value="Yes">Yes</option>
              <option value="No">No</option>
            </select>
          </div>
          <small id="usingtiesstringHelp" class="form-text text-muted">Used to hang the branches for drying during harvest.</small>
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