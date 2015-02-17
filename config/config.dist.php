<?

$VOTE_ENDS = "2015-01-01";
$CONFERENCE_URL = "https://github.com/chartjes/opencfp";

$TMPL_CONF = new Cohort\Templates\Config([
	'template_path' => "/path/to/templates",
	'site_name' => "Conference Voting",
	'header' => "header.inc",
	'footer' => "footer.inc",
]);

$DB_CONF = new Cohort\MySQLi\Config([
	"host" => "localhost",
	"schema" => "opencfp",
	"username" => "opencfp",
	"password" => "password",
]);
