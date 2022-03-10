<?php

namespace miuan;

class Media {
	private $id;
	private $conn;
	public $data = array();

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

	public function getMedia()
	{
		$query1 = $this->getConnection()->query("SELECT * FROM " . DB_MEDIA . " WHERE id=" . $this->id);

		if ($query1->num_rows == 1)
		{
			$media = $query1->fetch_array(MYSQLI_ASSOC);

			if ($media['type'] === "photo")
			{
				$media['complete_url'] = $media['url'] . '.' . $media['extension'];
        		$media['post_url'] = smoothLink('index.php?tab1=story&id=' . $media['post_id']);
        		$this->data = array(
        			'type' => 'photo',
        			'num' => 1
        		);
				$this->data['each'][] = $media;
			}
			elseif ($media['type'] === "album")
			{
				$query2 = $this->getConnection()->query("SELECT * FROM " . DB_MEDIA . " WHERE album_id=" . $media['id'] . " AND active=1 ORDER BY id DESC");
				$userObj = new \miuan\User();
				$this->data = array(
        			'type' => 'album',
        			'num' => $query2->num_rows,
        			'name' => $media['name'],
        			'timeline' => $userObj->getById($media['timeline_id']),
        			'temp' => $media['temp']
        		);

				while ($single_media = $query2->fetch_array(MYSQLI_ASSOC))
				{
					$single_media['post_url'] = smoothLink('index.php?tab1=story&id=' . $single_media['post_id']);
					$this->data['each'][] = $single_media;
				}
			}

			return $this->data;
		}
	}

	public function getRows()
	{
		$query1 = $this->getConnection()->query("SELECT * FROM " . DB_MEDIA . " WHERE id=" . $this->id);

		if ($query1->num_rows == 1)
		{
			$media = $query1->fetch_array(MYSQLI_ASSOC);

			if ($media['type'] === "photo")
			{
				$media['complete_url'] = $media['url'] . '.' . $media['extension'];
        		$media['post_url'] = smoothLink('index.php?tab1=story&id=' . $media['post_id']);
        		$this->data = array(
        			'id' => $media['id'],
        			'type' => 'photo',
        			'num' => 1
        		);
				$this->data['each'][] = $media;
				
			}
			elseif ($media['type'] === "album")
			{
				$query2 = $this->getConnection()->query("SELECT * FROM " . DB_MEDIA . " WHERE album_id=" . $media['id'] . " AND active=1 ORDER BY id DESC");
				$userObj = new \miuan\User();
				$this->data = array(
					'id' => $media['id'],
        			'type' => 'album',
        			'num' => $query2->num_rows,
        			'name' => $media['name'],
        			'timeline' => $userObj->getById($media['timeline_id']),
        			'temp' => $media['temp']
        		);

				while ($single_media = $query2->fetch_array(MYSQLI_ASSOC)) {
					$single_media['post_url'] = smoothLink('index.php?tab1=story&id=' . $single_media['post_id']);
					$this->data['each'][] = $single_media;
				}
			}

			return $this->data;
		}
	}

	public function getById($id) {
		$this->setId($id);
		return $this->getRows();
	}

	public function setId($id) {
		$this->id = (int) $id;
	}
}