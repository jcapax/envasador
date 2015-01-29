<?
	include ("/var/www/jpgraph-2.3.3/src/jpgraph.php");
	include ("/var/www/jpgraph-2.3.3/src/jpgraph_line.php");
	include ("/var/www/jpgraph-2.3.3/src/jpgraph_date.php");

	$f = $_GET['fecha'];
	$rb = $_GET['botRec'];
	$rc = $_GET['cajRec'];
	$db = $_GET['botDes'];
	$dc = $_GET['cajRes'];
	
	$nom_dist = $_GET['nom_dist'];
	$tn = $_GET['tn'];
		
	$fecha = explode(',',$f);
	$botRec = explode(',',$rb);
	$cajRec = explode(',',$rc);
	$botDes = explode(',',$db);
	$cajRes = explode(',',$dc);

$graph = new Graph(1000,500,"auto"); 

$graph->SetShadow();

$graph->img->SetMargin(40,30,40,80);

$graph->SetScale("textlin");

$graph->SetShadow();

if($tn == 5){
	$graph->title->Set('DESPACHO Y RECEPCIÓN DE ENVASES BOTELLAS '.$nom_dist);
}
else{
	$graph->title->Set('DESPACHO Y RECEPCIÓN DE ENVASES CAJAS '.$nom_dist);
}

$graph->yscale->SetAutoMin(0);

$graph->yscale->SetGrace(10);

$graph->title->SetFont(FF_FONT1,FS_BOLD);


$graph->xaxis->SetTickLabels($fecha);
$graph->xaxis->SetTextLabelInterval(1);
$graph->xaxis->SetLabelAngle(90);

if($tn == 5){
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
	
	$linea_botrec->value->Show();
	$linea_botdes->value->Show();
	
	$graph->Add($linea_botrec);
	$graph->Add($linea_botdes);
}
else
{
	$linea_cajrec = new LinePlot($cajRec);
	$linea_cajrec->SetColor("green");
	$linea_cajrec->mark->SetType(MARK_FILLEDCIRCLE);
	$linea_cajrec->mark->SetFillColor("green");
	$linea_cajrec->mark->SetWidth(4);
	$linea_cajrec->SetLegend("Recepción Caj.");
	
	$linea_cajdes = new LinePlot($cajRes);
	$linea_cajdes->SetColor("brown");
	$linea_cajdes->mark->SetType(MARK_FILLEDCIRCLE);
	$linea_cajdes->mark->SetFillColor("brown");
	$linea_cajdes->mark->SetWidth(4);
	$linea_cajdes->SetLegend("Despacho Caj.");
	
	$linea_cajrec->value->Show();
	$linea_cajdes->value->Show();

	$graph->Add($linea_cajrec);
	$graph->Add($linea_cajdes);
}

$graph->Stroke();
?><? //ob_end_flush();?>