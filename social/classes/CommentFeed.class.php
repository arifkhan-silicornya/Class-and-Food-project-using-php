<?php

namespace miuan;

class CommentFeed {
	private $conn;
	private $postId;
	private $data = array();
	private $limit = 3;
	private $total = 0;

	function __construct()
	{
		global $conn;
		$this->conn = $conn;
		return $this;
	}

	public function setConnection(\mysqli $conn)
	{
		$this->conn = $conn;
		return $this;
	}

	protected function getConnection()
	{
		return $this->conn;
	}

	public function getFeed() {
		$queryString = "SELECT id FROM " . DB_COMMENTS . " WHERE post_id=" . $this->postId . " AND active=1";

		if ($this->total > $this->limit)
		{
	        $queryString .= " LIMIT " . ($this->total - $this->limit) . "," . $this->limit;
	    }
	    
		$query = $this->getConnection()->query($queryString);

		if ($query->num_rows < 1) {
			return $this->data;
		}

		while ($fetch = $query->fetch_array(MYSQLI_ASSOC)) {
			$this->data[] = $fetch['id'];
		}
		
		return $this->data;
	}

	public function setPostId($id) {
		$this->postId = (int) $id;
	}

	public function setLimit($li) {
		$this->limit = (int) $li;
	}

	public function setTotal($li) {
		$this->total = (int) $li;
	}
}