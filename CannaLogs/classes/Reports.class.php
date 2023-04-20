<?php

class Reports extends Page
{
  
  //------------------------- Attributes -------------------------
  private $db = null;

  public $content = "<h1>This page was not instantiated correctly.</h1>" . "\r\n";
  public $title = "CannaLogs - Reports";
  public $keywords = "CannaLogs, reports";
  
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
   * Display - Displays the full page
   *
   * @param  mixed $filter
   *
   * @return void
   */
  public function Display()
  {
    parent::Display();
  }

}

?>