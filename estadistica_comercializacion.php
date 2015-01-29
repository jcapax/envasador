<?
	include ("/var/www/jpgraph-2.3.3/src/jpgraph.php");
	include ("/var/www/jpgraph-2.3.3/src/jpgraph_line.php");
	include ("/var/www/jpgraph-2.3.3/src/jpgraph_date.php");

	$f = $_GET['fecha'];
	$br = $_GET['botR'];
	$bd = $_GET['botD'];
	$bv = $_GET['botV'];

	$nom_dist = $_GET['nom_dist'];
		
	$fecha = explode(',',$f);
	$botRec = explode(',',$br);
	$botDes = explode(',',$bd);
	$botVen = explode(',',$bv);	

$graph = new Graph(1000,500,"auto"); 

$graph->SetShadow();

$graph->img->SetMargin(40,30,40,80);

$graph->SetScale("textlin");

$graph->SetShadow();

$graph->title->Set('ESTADÍSTICA COMERCIALIZACIÓN '.$nom_dist);


$graph->yscale->SetAutoMin(0);

$graph->yscale->SetGrace(10);

$graph->title->SetFont(FF_FONT1,FS_BOLD);


$graph->xaxis->SetTickLabels($fecha);
$graph->xaxis->SetTextLabelInterval(1);
$graph->xaxis->SetLabelAngle(90);

	$linea_botrec = new LinePlot($botRec);
	$linea_botrec->SetColor("blue");
	$linea_botrec->mark->SetType(MARK_FILLEDCIRCLE);
	$linea_botrec->mark->SetFillColor("blue");
	$linea_botrec->mark->SetWidth(4);
	$linea_botrec->SetLegend("Recepción Bot.");

	$linea_botdes = new LinePlot($botDes);
	$linea_botdes->SetColor("red");
	$linea_botdes->mark->SetType(MARK_FILLEDCIRCLE);
	$linea_botdes->mark->SetFillColor("red");
	$linea_botdes->mark->SetWidth(4);
	$linea_botdes->SetLegend("Despacho Bot.");	
	
	$linea_botven = new LinePlot($botVen);
	$linea_botven->SetColor("green");
	$linea_botven->mark->SetType(MARK_FILLEDCIRCLE);
	$linea_botven->mark->SetFillColor("green");
	$linea_botven->mark->SetWidth(4);
	$linea_botven->SetLegend("Venta Bot.");

	$linea_botrec->value->Show();
	$linea_botdes->value->Show();
	$linea_botven->value->Show();
	
	$graph->Add($linea_botrec);
	$graph->Add($linea_botdes);
	$graph->Add($linea_botven);
	
$graph->Stroke();
?><? //ob_end_flush();?>