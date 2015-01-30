<?

require_once "../vendor/autoload.php";

$tmpl_conf = new Cohort\Templates\Config([
	'template_path' => "/path/to/templates",
	'site_name' => "Conference Voting",
	'header' => "header.inc",
	'footer' => "footer.inc",
]);

$TEMPLATE = new Cohort\Templates\Page($tmpl_conf);
$TEMPLATE->set_global("TEMPLATE");

?>
