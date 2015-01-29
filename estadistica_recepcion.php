<?
	include ("/var/www/jpgraph-2.3.3/src/jpgraph.php");
	include ("/var/www/jpgraph-2.3.3/src/jpgraph_line.php");
	include ("/var/www/jpgraph-2.3.3/src/jpgraph_date.php");

	$bot = $_GET['bot'];
	$caj = $_GET['caj'];
	$f = $_GET['fecha'];
	$nom_dist = $_GET['nom_dist'];
	
	$botellas = explode(',', $bot);
	$cajas = explode(',', $caj);	
	$fecha = explode(',',$f);

$graph = new Graph(1000,500,"auto"); 

$graph->SetShadow();

//$graph->SetScale("dattlin");

$graph->img->SetMargin(40,30,40,80);

$graph->SetScale("textlin");
//$graph->SetScale("linlin");
//$graph->SetScale("datlin");

$graph->SetShadow();
//$graph->title->Set("Devolución de Envases");
$graph->title->Set('RECEPCIÓN DE ENVASES - '.$nom_dist);

$graph->yscale->SetAutoMin(0);

$graph->yscale->SetGrace(10);

$graph->title->SetFont(FF_FONT1,FS_BOLD);


$graph->xaxis->SetTickLabels($fecha);
//$graph->xaxis->SetTextLabelInterval();
//$graph->xaxis->scale->SetDateFormat("Y-m-d");
$graph->xaxis->SetTextLabelInterval(1);
$graph->xaxis->SetLabelAngle(90);
//$graph->xaxis->title->Set($nom_dist);


$linea_botellas = new LinePlot($botellas);
$linea_botellas->SetColor("blue");


$linea_cajas = new LinePlot($cajas);
$linea_cajas->SetColor("red");

$linea_botellas->mark->SetType(MARK_FILLEDCIRCLE);
$linea_botellas->mark->SetFillColor("red");
$linea_botellas->mark->SetWidth(4);
$linea_botellas->SetLegend("Botellas");

$linea_cajas->mark->SetType(MARK_FILLEDCIRCLE);
$linea_cajas->mark->SetFillColor("green");
$linea_cajas->mark->SetWidth(4);
$linea_cajas->SetLegend("Cajas");

$linea_cajas->value->Show();
$linea_botellas->value->Show();

$graph->Add($linea_cajas);
$graph->Add($linea_botellas);

$graph->Stroke();
?>