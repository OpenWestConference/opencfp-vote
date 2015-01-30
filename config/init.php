<?

require_once __DIR__."/../vendor/autoload.php";
require_once __DIR__."/config.php";

function cfp_db() {
	global $db_conf;
	static $instance = false;
	if ($instance === false) {
		$instance = new Cohort\MySQLi\Connection($db_conf);
	}
	return $instance;
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

$TEMPLATE = new Cohort\Templates\Page($tmpl_conf);
$TEMPLATE->set_global("TEMPLATE");
$TEMPLATE->set_global("VOTER");

