<?
	include ("/var/www/jpgraph-2.3.3/src/jpgraph.php");
	include ("/var/www/jpgraph-2.3.3/src/jpgraph_line.php");
	include ("/var/www/jpgraph-2.3.3/src/jpgraph_date.php");

	$f = $_GET['fecha'];
	$e = $_GET['especial'];
	$se = $_GET['sesqui'];
	$st = $_GET['stout'];
	$b3 = $_GET['b33'];
	$bc = $_GET['bic'];

	
	$fecha = explode(',',$f);
	$especial = explode(',',$e);
	$sesqui = explode(',',$se);
	$stout = explode(',',$st);
	$b33 = explode(',',$b3);
	$bic = explode(',',$bc);

$graph = new Graph(1000,500,"auto"); 

$graph->SetShadow();

//$graph->SetScale("dattlin");

$graph->img->SetMargin(40,30,40,80);

$graph->SetScale("textlin");
//$graph->SetScale("linlin");
//$graph->SetScale("datlin");

$graph->SetShadow();
//$graph->title->Set("Devolución de Envases");
$graph->title->Set('PRODUCCIÓN - DISTRIBUCIÓN POR PRODUCTOS');

$graph->yscale->SetAutoMin(0);

$graph->yscale->SetGrace(10);

$graph->title->SetFont(FF_FONT1,FS_BOLD);


$graph->xaxis->SetTickLabels($fecha);
$graph->xaxis->SetTextLabelInterval(1);
$graph->xaxis->SetLabelAngle(90);

$linea_especial = new LinePlot($especial);
$linea_especial->SetColor("blue");
$linea_especial->mark->SetType(MARK_FILLEDCIRCLE);
$linea_especial->mark->SetFillColor("blue");
$linea_especial->mark->SetWidth(4);
$linea_especial->SetLegend("Especial");

$linea_sesqui = new LinePlot($sesqui);
$linea_sesqui->SetColor("green");
$linea_sesqui->mark->SetType(MARK_FILLEDCIRCLE);
$linea_sesqui->mark->SetFillColor("green");
$linea_sesqui->mark->SetWidth(4);
$linea_sesqui->SetLegend("Sesqui");

$linea_stout = new LinePlot($stout);
$linea_stout->SetColor("brown");
$linea_stout->mark->SetType(MARK_FILLEDCIRCLE);
$linea_stout->mark->SetFillColor("brown");
$linea_stout->mark->SetWidth(4);
$linea_stout->SetLegend("Stout");

$linea_b33 = new LinePlot($b33);
$linea_b33->SetColor("yellow");
$linea_b33->mark->SetType(MARK_FILLEDCIRCLE);
$linea_b33->mark->SetFillColor("yellow");
$linea_b33->mark->SetWidth(4);
$linea_b33->SetLegend("33");

$linea_bic = new LinePlot($bic);
$linea_bic->SetColor("red");
$linea_bic->mark->SetType(MARK_FILLEDCIRCLE);
$linea_bic->mark->SetFillColor("red");
$linea_bic->mark->SetWidth(4);
$linea_bic->SetLegend("Bicent.");

$linea_especial->value->Show();
$linea_sesqui->value->Show();
$linea_stout->value->Show();
$linea_b33->value->Show();
$linea_bic->value->Show();

$graph->Add($linea_especial);
$graph->Add($linea_sesqui);
$graph->Add($linea_stout);
$graph->Add($linea_b33);
$graph->Add($linea_bic);

$graph->Stroke();
?><? //ob_end_flush();?>