<?

// Make sure the hash matches
if (!isset($_POST['hash']) || $_POST['hash'] !== $VOTER->getHash()) exit();

// Make sure the talk_id and rating are set
if (!isset($_POST['talk_id']) || !isset($_POST['rating'])) exit();


$db = cfp_db();
$talk_id = intval($_POST['talk_id']);
$rating = intval($_POST['rating']);

if (!$db->fquery("SELECT 1 FROM talks WHERE id=?", $talk_id)) exit();
if ($rating < 0 || $rating > 5) exit();

$VOTER->vote($talk_id, $rating);

header("Content-Type: text/plain");
echo "1";
