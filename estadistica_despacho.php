<?
	include ("/var/www/jpgraph-2.3.3/src/jpgraph.php");
	include ("/var/www/jpgraph-2.3.3/src/jpgraph_line.php");

	$f = $_GET['fecha'];
	$botEsp_ = $_GET['botEsp'];
	$botSes_ = $_GET['botSes'];
	$botSto_ = $_GET['botSto'];
	$botBic_ = $_GET['botBic'];		
	$latEsp_ = $_GET['latEsp'];
	$latSes_ = $_GET['latSes'];
	$latSto_ = $_GET['latSto'];	
	$bllEsp_ = $_GET['bllEsp'];
	$bllSes_ = $_GET['bllSes'];
	$bllSto_ = $_GET['bllSto'];
	$bll33_  = $_GET['bll33'];
	$bllBic_ = $_GET['bllBic'];	
	$choEsp_ = $_GET['choEsp'];
	$choSes_ = $_GET['choSes'];	
	
	$fecha  = explode(',',$f);
	$botEsp = explode(',',$botEsp_);
	$botSes = explode(',',$botSes_);
	$botSto = explode(',',$botSto_);
	$botBic = explode(',',$botBic_);		
	$latEsp = explode(',',$latEsp_);
	$latSes = explode(',',$latSes_);
	$latSto = explode(',',$latSto_);	
	$bllEsp = explode(',',$bllEsp_);
	$bllSes = explode(',',$bllSes_);
	$bllSto = explode(',',$bllSto_);
	$bll33 	= explode(',',$bll33_);	
	$bllBic = explode(',',$bllBic_);	
	$choEsp = explode(',',$choEsp_);
	$choSes = explode(',',$choSes_);

$graph = new Graph(1000,500,"auto"); 

$graph->SetShadow();

$graph->img->SetMargin(40,30,40,80);

$graph->SetScale("textlin");

$graph->SetShadow();

$graph->title->Set('Salida Productos');

$graph->yscale->SetAutoMin(0);

$graph->yscale->SetGrace(10);

$graph->title->SetFont(FF_FONT1,FS_BOLD);

$graph->xaxis->SetTickLabels($fecha);
$graph->xaxis->SetTextLabelInterval(1);
$graph->xaxis->SetLabelAngle(90);

$linea_botEsp = new LinePlot($botEsp);
$linea_botEsp->SetColor("blue");
$linea_botEsp->mark->SetType(MARK_FILLEDCIRCLE);
$linea_botEsp->mark->SetFillColor("blue");
$linea_botEsp->mark->SetWidth(4);
$linea_botEsp->SetLegend("Bot.Esp.");

$linea_botSes = new LinePlot($botSes);
$linea_botSes->SetColor("green");
$linea_botSes->mark->SetType(MARK_FILLEDCIRCLE);
$linea_botSes->mark->SetFillColor("green");
$linea_botSes->mark->SetWidth(4);
$linea_botSes->SetLegend("Bot. Sesq.");

$linea_botSto = new LinePlot($botSto);
$linea_botSto->SetColor("brown");
$linea_botSto->mark->SetType(MARK_FILLEDCIRCLE);
$linea_botSto->mark->SetFillColor("brown");
$linea_botSto->mark->SetWidth(4);
$linea_botSto->SetLegend("Bot. Stou.");

$linea_botBic = new LinePlot($botBic);
$linea_botBic->SetColor("red");
$linea_botBic->mark->SetType(MARK_FILLEDCIRCLE);
$linea_botBic->mark->SetFillColor("red");
$linea_botBic->mark->SetWidth(4);
$linea_botBic->SetLegend("Bot. Bicent.");

$linea_latEsp = new LinePlot($latEsp);
$linea_latEsp->SetColor("yellow");
$linea_latEsp->mark->SetType(MARK_FILLEDCIRCLE);
$linea_latEsp->mark->SetFillColor("yellow");
$linea_latEsp->mark->SetWidth(4);
$linea_latEsp->SetLegend("Lat. Esp.");

$linea_botEsp->value->Show();
$linea_botSes->value->Show();
$linea_botSto->value->Show();
$linea_botBic->value->Show();
$linea_latEsp->value->Show();

$graph->Add($linea_botEsp);
$graph->Add($linea_botSes);
$graph->Add($linea_botSto);
$graph->Add($linea_botBic);
$graph->Add($linea_latEsp);

$graph->Stroke();
?>