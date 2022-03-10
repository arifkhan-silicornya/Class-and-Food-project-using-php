<?php

namespace miuan;

class updateTimeline {
	private $conn;
	private $escapeObj;

	private $timelineId;
	private $name;
	private $username;
	private $about;

	/* User */
	private $email;
	private $timezone;
	private $currentPassword;
	private $newPassword;
	private $avatarImage;
	private $coverImage;
	private $birthday;
	private $gender;
	private $location;
	private $hometown;
		/* Privacy */
		private $confirmFollowers;
		private $followPrivacy;
		private $commentPrivacy;
		private $postPrivacy;

	/* Page */
	private $address;
	private $awards;
	private $phone;
	private $products;
	private $website;
	
	/* Group */
	private $groupPrivacy;
	private $addPrivacy;
	private $timelinePostPrivacy;

	/* Privacy */
	private $messagePrivacy;
	private $timelinePostPrivacy;


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
}