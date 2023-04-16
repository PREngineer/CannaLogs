<?php

/**
 * These files are used to generate graphs in the application.
 */
require_once '../lib/jpgraph-4.3.5/jpgraph.php';
require_once '../lib/jpgraph-4.3.5/jpgraph_radar.php';

// Library is JPGraph: https://jpgraph.net/
// https://jpgraph.net/download/manuals/chunkhtml/ch16s02.html

/**
 * This file receives the parameters for the radar graph from the URL.
 * Values are:
 *  $_GET['floral']
 *  $_GET['sweet']
 *  $_GET['spicy']
 *  $_GET['earthy']
 *  $_GET['woody']
 *  $_GET['sour']
 *  $_GET['citrusy']
 *  $_GET['fruity']
 */
 
// Create the basic rtadar graph
$graph = new RadarGraph(400,360);
 
// Set background color and shadow
$graph->SetColor("gray");
//$graph->SetShadow();

// Set the scale to linear or logarithmic [lin, log]
$graph->SetScale("lin", 0, 5);
 
// Position the graph
$graph->SetCenter(0.48,0.54);
 
// Setup the axis formatting     
$graph->axis->SetFont(FF_FONT1,FS_BOLD);
// $graph->axis->SetWeight(2);
 
// Setup the grid lines
$graph->grid->SetLineStyle("longdashed");
$graph->grid->SetColor("navy");
$graph->grid->Show();
$graph->HideTickMarks();
// $graph->ShowMinorTickMarks();
$graph->grid->Show();
$graph->grid->SetLineStyle('dashed');
$graph->grid->SetColor('darkgray');
        
// Setup graph titles
$graph->title->Set("Taste Profile");
// $graph->title->SetFont(FF_FONT1,FS_BOLD);
$graph->SetTitles( array("Floral","Sweet","Spicy","Earthy","Woody","Sour","Citrusy","Fruity") );

// Create the first radar plot 
$plot = new RadarPlot( array( $_GET['floral'], $_GET['sweet'], $_GET['spicy'], $_GET['earthy'], $_GET['woody'], $_GET['sour'], $_GET['citrusy'], $_GET['fruity'] ) );
// $plot->SetLegend("Profile");
$plot->SetColor("blue","lightblue");
 
// Add the plots to the graph
$graph->Add($plot);
// $graph->Add($plot);
 
// And output the graph
$graph->Stroke();

?>