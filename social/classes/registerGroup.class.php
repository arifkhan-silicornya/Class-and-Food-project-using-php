<?php

namespace miuan;

class registerGroup
{
	private $conn;
	private $name;
	private $username;
	private $about;
	private $privacy;
	private $email;
	private $escapeObj;
	private $validPrivacies = array('open', 'closed', 'secret');

	function __construct()
	{
		global $conn;
		$this->conn = $conn;
		$this->escapeObj = new \miuan\Escape();
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

	public function register()
	{
		if (! isLogged())
		{
			return false;
		}
		
		if (! empty($this->name) && ! empty($this->username) && ! empty($this->about) && ! empty($this->privacy))
		{
			$this->email = $this->username . '@yoursite.com';
			$query = $this->getConnection()->query("INSERT INTO ". DB_ACCOUNTS ." (about,active,cover_id,email,name,password,time,type,username) VALUES ('" . $this->about . "',1,0,'" . $this->email . "','" . $this->name . "','" . md5(generateKey()) . "'," . time() . ",'group','" . $this->username . "')");

			if ($query)
			{
				$groupId = $this->getConnection()->insert_id;
				$query2 = $this->getConnection()->query("INSERT INTO " . DB_GROUPS . " (id,group_privacy) VALUES ($groupId,'" . $this->privacy . "')");

				if ($query2)
				{
					global $user;
					$this->getConnection()->query("INSERT INTO " . DB_FOLLOWERS . " (active,follower_id,following_id,time) VALUES (1," . $user['id'] . "," . $groupId . "," . time() . ")");

					$query3 = $this->getConnection()->query("INSERT INTO " . DB_GROUP_ADMINS . " (active,admin_id,group_id) VALUES (1," . $user['id'] . ",$groupId)");

					return array(
	                    'id' => $groupId,
	                    'username' => $this->username
	                );
				}
			}
		}
	}

	private function validateUsername($u)
	{
		if (strlen($u) > 3 && ! is_numeric($u) && preg_match('/^[A-Za-z0-9_]+$/', $u))
		{
			return true;
		}
	}

	private function validatePrivacy($p)
	{
		if (in_array($p, $this->validPrivacies))
		{
			return true;
		}
	}

	public function setName($n)
	{
		$this->name = $this->escapeObj->stringEscape($n);
	}

	public function setUsername($u)
	{
		if ($this->validateUsername($u))
		{
			$this->username = $this->escapeObj->stringEscape($u);
		}
	}

	public function setAbout($a)
	{
		$this->about = $this->escapeObj->postEscape($a);
	}

	public function setPrivacy($p)
	{
		if ($this->validatePrivacy($p))
		{
			$this->privacy = $p;
		}
	}
}