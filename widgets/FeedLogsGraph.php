<?php

/**
 * These files are used to generate graphs in the application.
 */
require_once '../lib/jpgraph-4.3.5/jpgraph.php';
require_once '../lib/jpgraph-4.3.5/jpgraph_bar.php';

// Library is JPGraph: https://jpgraph.net/
// https://jpgraph.net/download/manuals/chunkhtml/ch16s02.html

/**
 * This file receives the parameters for the bar graph from the URL, as a comma separated list of values.
 * Values are:
 *  $_GET['data']
 *  $_GET['date']
 */
 
// Sample data
// $data=array( 800, 950, 1200, 1000, 1400, 1200, 600, 800, 400 );

// Make an arra of the passed comma separated data
$data = explode(",", $_GET['data']);
// Make an arra of the passed comma separated data
$dates = explode(",", $_GET['dates']);
// Make sure that dates breaks like so:
// year *line break* month-day
// so that it fits in the bottom of the bars
// for( $i = 0; $i < sizeof( $dates ); $i++ )
// {
//     ($dates[$i])[4] = ".";
//     $dates[$i] = str_replace(".", "\n",  $dates[$i]);
// }

// Create the graph. These two calls are always required
// 
$graph = new Graph( ( ( sizeof($data) * 50 ) + 200 ),200,'auto');
$graph->SetScale("textlin");

$theme_class=new UniversalTheme;
$graph->SetTheme($theme_class);

// $graph->yaxis->SetTickPositions( 
//     array( 0, 200, 400, 600, 800, 1000, 1200, 1400, 1600, 1800, 2000, 2200, 2400, 2600, 2800, 3000 ), 
//     array( 100, 300, 500, 700, 9000, 1100, 1300, 1500, 1700, 1900, 2100, 2300, 2500, 2700, 2900 ) 
// );
$graph->SetBox(false);

$graph->ygrid->SetFill(false);
// $graph->xaxis->SetTickLabels( array("2021-\n11-04","2021-\n11-25","2021-\n12-25","2022-\n01-20") );
$graph->xaxis->SetTickLabels( $dates );
$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false,false);

// Create the bar plots
$plot = new BarPlot($data);

// Create the grouped bar plot
$gbplot = new GroupBarPlot( array($plot) );
// ...and add it to the graPH
$graph->Add( $gbplot );

// The bar colors
$plot->SetColor("black");
$plot->SetFillColor("darkgreen");

$graph->title->Set("Feed Schedule");

// Display the graph
$graph->Stroke();

?>