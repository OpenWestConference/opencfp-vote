<?

$tmpl_conf = new Cohort\Templates\Config([
	'template_path' => "/path/to/templates",
	'site_name' => "Conference Voting",
	'header' => "header.inc",
	'footer' => "footer.inc",
]);

$db_conf = new Cohort\MySQLi\Config([
	"host" => "localhost",
	"schema" => "opencfp",
	"username" => "opencfp",
	"password" => "password",
]);
