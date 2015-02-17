<?

require_once __DIR__."/../vendor/autoload.php";
require_once __DIR__."/config.php";

function cfp_db() {
	global $DB_CONF;
	static $instance = false;
	if ($instance === false) {
		$instance = new Cohort\MySQLi\Connection($DB_CONF);
	}
	return $instance;
}



if (time() > strtotime($VOTE_ENDS)) {
	header("Location: $CONFERENCE_URL");
	exit();
}


session_start();

if (!isset($_SESSION['voter'])) {
	if (isset($_COOKIE['voterid']) && preg_match('/^[0-9a-f]{32}$/', $_COOKIE['voterid'])) {
		$cookie = $_COOKIE['voterid'];
	} else {
		$cookie = md5(mt_rand() . "|" . microtime(true) . "|" . openssl_random_pseudo_bytes(32));
		setcookie("voterid", $cookie, time() + (86400 * 30), "/");
	}
	$_SESSION['voter'] = new \OpenCFPVote\Voter(cfp_db(), $_SERVER['REMOTE_ADDR'], $cookie);
} else {
	$_SESSION['voter']->setDbConn(cfp_db());
}
$VOTER =& $_SESSION['voter'];

$TEMPLATE = new Cohort\Templates\Page($TMPL_CONF);
$TEMPLATE->set_global("TEMPLATE");
$TEMPLATE->set_global("VOTER");

