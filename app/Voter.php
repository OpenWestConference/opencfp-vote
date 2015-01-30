<?

namespace OpenCFPVote;

class Voter {
	private $id = false;
	private $db = false;
	private $hash = false;
	
	public function __construct(\Cohort\MySQLi\Connection $db, $ip_address, $cookie) {
		$this->db = $db;
		
		$this->id = $this->db->fquery("SELECT id FROM voters WHERE cookie=?", $cookie);
		if (!$this->id) {
			$this->id = $this->db->query("INSERT INTO voters (cookie, ip_address, created_at) VALUES (?, ?, NOW())", $cookie, $ip_address);
		}
	}
	public function setDbConn(\Cohort\MySQLi\Connection $db) {
		$this->db = $db;
	}
	public function updateLastVoted() {
		$this->db->query("UPDATE voters SET last_voted_at=NOW() WHERE id=?", $this->id);
	}
	public function getVotesByCategory() {
		return $this->db->aquery("SELECT t.category AS name, COUNT(t.id) AS num_talks, COUNT(v.talk_id) AS num_votes FROM talks t LEFT JOIN votes v ON v.talk_id=t.id AND v.voter_id=? AND v.rating > 0 GROUP BY t.category", $this->id);
	}
	public function getTalksByCategory($category) {
		return $this->db->aquery("SELECT t.id, t.title, t.description, t.type, t.level, v.rating FROM talks t LEFT JOIN votes v ON v.talk_id=t.id AND v.voter_id=? WHERE t.category=? ORDER BY t.title", $this->id, $category);
	}
	public function getHash() {
		if ($this->hash === false) {
			$this->hash = sha1(sprintf("%s|%s|%s", mt_rand(), microtime(true), openssl_random_pseudo_bytes(32)));
		}
		return $this->hash;
	}
	public function vote($talk_id, $rating) {
		$this->db->query("INSERT INTO votes (voter_id, talk_id, rating, voted_at) VALUES (?, ?, ?, NOW()) ON DUPLICATE KEY UPDATE rating=VALUES(rating), voted_at=VALUES(voted_at)", $this->id, $talk_id, $rating);
	}
}
