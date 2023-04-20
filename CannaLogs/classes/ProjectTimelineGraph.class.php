<?php

/*
How to use it:
    $graph = new ProjectTimelineGraph();
    $graph->Display();
 */

class ProjectTimelineGraph
{
  //------------------------- Attributes -------------------------
  
  public $content         = null;
  public $startDays       = null;
  public $germinationDays = null;
  public $vegetationDays  = null;
  public $floweringDays   = null;
  public $flushingDays    = null;
  public $totalDays       = null;
  
  //------------------------- Operations -------------------------
  
  public function __construct( $calculations )
  {
    $this->content = '';
    if( $calculations['startDays'] != 0 )
    {
      $this->startDays     = $calculations['startDays'];
    }
    else
    {
      $this->startDays     = 1;
    }
    $this->germinationDays = $calculations['germinationDays'];
    $this->vegetationDays  = $calculations['vegetationDays'];
    $this->floweringDays   = $calculations['floweringDays'];
    $this->flushingDays    = $calculations['flushingDays'];
    if( $calculations['totalDays'] != 0 )
    {
      $this->totalDays     = $calculations['totalDays'];
    }
    else
    {
      $this->totalDays     = 1;
    }
  }

  /**
   * Display - Returns the HTML of the Project Timeline Graph
   *
   * @return string
   */
  public function Display( $data )
  {
    // Define how the sections will be sized
    // Percentage in Start
    if( ( $this->startDays/$this->totalDays ) * 100 > 3 )
    {
      $startpercent = ( ( $this->startDays/$this->totalDays ) * 100 );
    }
    else
    {
      $startpercent = 3;
    }
    
    // Percentage in Germination
    if( $data['germinationdate'] != '' )
    {
      $germinationpercent = ( ( $this->germinationDays/$this->totalDays ) * 100 );

      // Check that we don't exceed 100%
      if( $startpercent + $germinationpercent > 100 )
      {
        $germinationpercent = $germinationpercent - ( ( $startpercent + $germinationpercent ) - 100 );
      }
    }
    else
    {
      $germinationpercent = '0';
    }

    // Percentage in Vegetation
    if( $data['vegetationdate'] != '' )
    {
      $vegetationpercent = ( ( $this->vegetationDays/$this->totalDays ) * 100 );
      
      // Check that we don't exceed 100%
      if( $startpercent + $germinationpercent + $vegetationpercent > 100 )
      {
        $toreduce = ( $startpercent + $germinationpercent + $vegetationpercent ) - 100;
        $germinationpercent = $germinationpercent - ($toreduce/2);
        $vegetationpercent = $vegetationpercent - ($toreduce/2);
      }
    }
    else
    {
      $vegetationpercent = '0';
    }

    // Percentage in Flower
    if( $data['floweringdate'] != '' )
    {
      $flowerpercent = ( ( $this->floweringDays/$this->totalDays ) * 100 );

      // Check that we don't exceed 100%
      if( $startpercent + $germinationpercent + $vegetationpercent + $flowerpercent > 100 )
      {
        $toreduce = ( $startpercent + $germinationpercent + $vegetationpercent + $flowerpercent ) - 100;
        $germinationpercent = $germinationpercent - ($toreduce/3);
        $vegetationpercent = $vegetationpercent - ($toreduce/3);
        $flowerpercent = $flowerpercent - ($toreduce/3);
      }
    }
    else
    {
      $flowerpercent = '0';
    }

    // Percentage in Flush
    if( $data['flushingdate'] != '' )
    {
      $flushpercent = ( ( $this->flushingDays/$this->totalDays ) * 100 );

      // Check that we don't exceed 100%
      if( $startpercent + $germinationpercent + $vegetationpercent + $flowerpercent + $flushpercent > 100 )
      {
        $toreduce = ( $startpercent + $germinationpercent + $vegetationpercent + $flowerpercent + $flushpercent ) - 100;
        $germinationpercent = $germinationpercent - ($toreduce/4);
        $vegetationpercent = $vegetationpercent - ($toreduce/4);
        $flowerpercent = $flowerpercent - ($toreduce/4);
        $flushpercent = $flushpercent - ($toreduce/4);
      }
    }
    else
    {
      $flushpercent = '0';
    }

    // If we have harvested, reduce the other ones to fit the Harvest step
    if( $data['harvestingdate'] != '' )
    {
      $harvest = 5;
      // Check that we don't exceed 100%, make space for harvest
      $germinationpercent--;
      $vegetationpercent--;
      $flowerpercent--;
      $flushpercent = $flushpercent - 2;
    }
    else
    {
      $harvest = 0;
    }

    $this->content = '
      <div class="progress">
        <div class="progress-bar progress-bar-light" role="progressbar" style="width: ';
        if( $data['harvestingdate'] != '' ){ $this->content .= $startpercent . '%'; }
        else{ $this->content .= ($startpercent) . '%'; }
        $this->content .= '">
          Start
        </div>
        <div class="progress-bar progress-bar-info" role="progressbar" style="width: ';
        if( $data['harvestingdate'] != '' ){ $this->content .= $germinationpercent . '%'; }
        else{ $this->content .= ($germinationpercent) . '%'; }
        $this->content .= '">
          Germinate
        </div>
        <div class="progress-bar progress-bar-success" role="progressbar" style="width: ';
        if( $data['harvestingdate'] != '' ){ $this->content .= $vegetationpercent . '%'; }
        else{ $this->content .= ($vegetationpercent) . '%'; }
        $this->content .= '">
          Vegetate
        </div>
        <div class="progress-bar progress-bar-warning" role="progressbar" style="width: ';
        if( $data['harvestingdate'] != '' ){ $this->content .= $flowerpercent . '%'; }
        else{ $this->content .= ($flowerpercent) . '%'; }
        $this->content .= '">
          Flower
        </div>
        <div class="progress-bar progress-bar-danger" role="progressbar" style="width: ';
        if( $data['harvestingdate'] != '' ){ $this->content .= $flushpercent . '%'; }
        else{ $this->content .= ($flushpercent) . '%'; }
        $this->content .= '">
          Flush
        </div>
        <div class="progress-bar progress-bar-light" role="progressbar" style="width: 
    ';

    if( $data['harvestingdate'] != '' )
    {
      $this->content .= $harvest . '%';
    }
    else
    {
      $this->content .= '0%';
    }
    
    $this->content .= '">
        Harvest
        </div>
      </div>
    ';
    
    return $this->content;
  }

}

?>