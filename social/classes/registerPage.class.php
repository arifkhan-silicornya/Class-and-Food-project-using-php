<?php

namespace miuan;

class registerPage
{
	private $conn;
	private $name;
	private $username;
	private $about;
	private $catId;
	private $email;
	private $escapeObj;

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
		
		if (! empty($this->name) && ! empty($this->username) && ! empty($this->about) && $this->catId > 0)
		{
			$this->email = $this->username . '@yoursite.com';
			$query = $this->getConnection()->query("INSERT INTO ". DB_ACCOUNTS ." (about,active,cover_id,email,name,password,time,type,username) VALUES ('" . $this->about . "',1,0,'" . $this->email . "','" . $this->name . "','" . md5(generateKey()) . "'," . time() . ",'page','" . $this->username . "')");

			if ($query)
			{
				$pageId = $this->getConnection()->insert_id;
				$query2 = $this->getConnection()->query("INSERT INTO " . DB_PAGES . " (id,category_id) VALUES ($pageId," . $this->catId . ")");

				if ($query2)
				{
					global $user;
					$pageObj = new \miuan\User();
					$pageObj->setId($pageId);
					$page = $pageObj->getRows();

					$pageObj->putFollow();
					$query3 = $this->getConnection()->query("INSERT INTO " . DB_PAGE_ADMINS . " (active,admin_id,page_id,role) VALUES (1," . $user['id'] . ",$pageId,'admin')");

					return array(
	                    'url' => $page['url']
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

	private function validateCategory($cid=0)
	{
		$cid = (int) $cid;
		$query = $this->getConnection()->query("SELECT id FROM " . DB_PAGE_CATEGORIES . " WHERE id=$cid AND category_id<>0 AND active=1");

		if ($query->num_rows == 1)
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

	public function setCatId($cid=0)
	{
		if ($this->validateCategory($cid))
		{
			$this->catId = (int) $cid;
		}
	}
}