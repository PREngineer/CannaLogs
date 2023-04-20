<?php

class Page
{
  
  //------------------------- Attributes -------------------------
  public $content = "<br><br><h1>This page was not instantiated correctly.</h1>" . "\r\n";
  public $title = "CannaLogs";
  public $keywords = "CannaLogs";
  public $NavBar;
  
  //------------------------- Operations -------------------------
  
  /**
   * __construct
   *
   * @return void
   */
  public function __construct()
  {
    $this->NavBar = new PageNavBar();
  }

  /**
   * Set
   *
   * @param  mixed $name
   * @param  mixed $value
   *
   * @return void
   */
  public function Set($name, $value)
  {
    $this->$name = $value;
  }

  /**
   * Display - Shows the actual page
   *
   * @return void
   */
  public function Display()
  {

    echo '<!DOCTYPE html>
    
    <html lang="en">
    
    <!-- ******************* Header Section ******************* -->
    
    <head>
    
      <!----------------- Generic HTML5 App Information ----------------->
      <!-- Encoding and Mobile First -->
      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
      <!-- Specify HTML5 Web App name and description -->
      <meta name="application-name" content="CannaLogs" />
      <meta name="description" content="A progressive web application to manage farm grows." />
      <meta name="author" content="Jorge Pabon" />
      
      <!---------------------------------------------- BOOTSTRAP INFORMATION ---------------------------------------------->

      <!-- CSS - Bootstrap and other dependencies -->
      <link href="theme/css/bootstrap-theme.min.css" rel="stylesheet" />
      <link href="theme/css/bootstrap.min.css" rel="stylesheet" />
      <link href="theme/css/bootstrap-datepicker3.standalone.min.css" rel="stylesheet" />
      <link href="theme/css/bootstrap-datepicker3.min.css" rel="stylesheet" />
      <link href="theme/css/jquery.timepicker.min.css" rel="stylesheet" />
    
      <!-- JS - jQuery and other dependencies -->
      <script src="theme/js/jquery-3.2.1.min.js"></script>
      <script src="theme/js/bootstrap-datepicker.min.js"></script>
      <script src="theme/js/jquery.timepicker.min.js"></script>
      <script src="theme/js/BootstrapValidator.min.js"></script>
      <script src="theme/js/validator.js"></script>
      <!-- Close the alerts after 5 seconds -->
      <script src="theme/js/closeAlerts.js"></script>
        
      <!-- JS - Bootstrap -->
      <script src="theme/js/bootstrap.js"></script>

      <!---------------------------------------------- WYSIWYG TEXT EDITOR INFORMATION ---------------------------------------------->
      <script src="lib/ckeditor/ckeditor.js"></script>

      <!------------------------------------------ ALLOWS TABLES TO BE SORTED BY COLUMN ------------------------------------------>
      <script src="lib/SortTable/sorttable.js"></script>
    
      <!---------------------------------------------- PWA INFORMATION ---------------------------------------------->

      <!-- PWA Manifest -->
      <link rel="manifest" href="manifest.json" />
      <script src="manup.js"></script>
    
      <!-- PWA Service Worker -->
      <script src="sw.js"></script>
      <script src="sw-reg.js"></script>
    
      <!----------------- For Android Devices ----------------->
      <!-- Define the Home Screen icon -->
      <link rel="icon" sizes="192x192" href="images/TLogo.png" />
      <!-- Hide Android UI buttons and set the splash color -->
      <meta name="mobile-web-app-capable" content="yes" />
      <meta name="theme-color" content="#2196F3" />
    
      <!----------------- For Apple Devices ----------------->
      <!-- Hide Safari UI buttons -->
      <meta name="apple-mobile-web-app-capable" content="yes" />
      <!-- Make the status bar black -->
      <meta name="apple-mobile-web-app-status-bar-style" content="black" />
      <!-- Define the name of the icon in the Home Screen -->
      <meta name="apple-mobile-web-app-title" content="CannaLogs" />
      <!-- Define the Apple Splash Screens -->
      <link  rel="apple-touch-startup-image" href="images/iphone5_splash.png" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)" />
      <link  rel="apple-touch-startup-image" href="images/iphone6_splash.png" media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2)" />
      <link  rel="apple-touch-startup-image" href="images/iphoneplus_splash.png" media="(device-width: 621px) and (device-height: 1104px) and (-webkit-device-pixel-ratio: 3)" />
      <link  rel="apple-touch-startup-image" href="images/iphonex_splash.png" media="(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3)" />
      <link  rel="apple-touch-startup-image" href="images/iphonexr_splash.png" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2)" />
      <link  rel="apple-touch-startup-image" href="images/iphonexsmax_splash.png" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3)" />
      <link  rel="apple-touch-startup-image" href="images/ipad_splash.png" media="(device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2)" />
      <link  rel="apple-touch-startup-image" href="images/ipadpro1_splash.png" media="(device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2)" />
      <link  rel="apple-touch-startup-image" href="images/ipadpro3_splash.png" media="(device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2)" />
      <link  rel="apple-touch-startup-image" href="images/ipadpro2_splash.png" media="(device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2)" />
      <!-- Define the Home Screen icon -->
      <link rel="apple-touch-icon" href="images/TLogo.png" />
      
      <!-- For Microsoft Devices -->
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <meta name="msapplication-TileImage" content="images/TLogo.png" />
      <meta name="msapplication-TileColor" content="#2196F3" />
    
      <!-- ... -->
      <meta property="og:title" content="CannaLogs" />
      <meta property="og:type" content="website" />
      <meta property="og:image" content="images/TLogo.png" />
      <meta property="og:url" content="' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '" />
      <meta property="og:description" content="A progressive web application to manage farm grows." />
    
      <!-- Twitter References -->
      <meta name="twitter:card" content="summary" />
      <meta name="twitter:url" content="https://www.twitter.com/PianistaPR" />
      <meta name="twitter:title" content="CannaLogs" />
      <meta name="twitter:description" content="A progressive web application to manage farm grows." />
      <meta name="twitter:image" content="images/TLogo.png" />
      <meta name="twitter:creator" content=@PianistaPR>
      
      <!-- Page Title -->
      <title>' . $this->title . '</title>
      
      <meta name="keywords" content="CannaLogs Platform"/>

    </head>
    
    <body>' . "\r\n";
    
    echo $this->NavBar->Display();
    
    echo '
      <!-- ******************* Content Section ******************* -->
      <div class="container" id="Content">' . "\r\n";

    echo $this->content;
    
    echo '
      </div>
      <br><br><br>
      <!-- ******************* Footer Section ******************* -->
      <div class="container-fluid">
      
      <!-- ******************* Footer Section ******************* -->
        <div class="container-fluid">
          <div class="text-center text-muted table-responsive nav navbar-inverse navbar-fixed-bottom">
            <table class="table">
              <tr>
                <td class="text-right" style="width: 50%">
                  <img src="images/btcuri.png">
                  <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=53CD2WNX3698E&lc=US&item_name=CannaLogs%20Donation%20Support&item_number=' . date('Y-m-d') . '&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted"><img src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif"></a> 
                </td>

                <td class="text-left" style="width: 50%; color: gray">
                  © ' . DATE("Y") . ' CannaLogs was created by <a href="https://github.com/PREngineer">Jorge Pabon</a>
                  <br>Please support this project so that we can continue developing and providing this platform.
                </td>
              </tr>
            </table>
          </div>
        </div>

      </div>

    </body>
    
    </html>';
  }

}

?>