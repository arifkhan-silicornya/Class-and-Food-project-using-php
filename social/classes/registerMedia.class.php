<?php

namespace miuan;

class registerMedia
{
	private $conn;
	private $albumId = 0;
	private $dir = 'photos/' . date('Y') . '/' . date('m');
	private $escapeObj;
	private $allowedExtensions = array('jpg', 'jpeg', 'gif', 'png');
	private $minImageSize = 1024;
	private $image;
	private $imageId;
	private $imageName;
	private $imageUrl;
	private $imageExtension;
	private $imageWidth;
	private $imageHeight;
	private $imageResolution;

	function __construct()
	{
		set_time_limit(0);

		if (! file_exists($this->dir))
		{
	        mkdir($this->dir, 0777, true);
	    }

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
		if (isset($this->image))
		{
			$query = $this->getConnection()->query("INSERT INTO " . DB_MEDIA . " (extension,name,type) VALUES ('" . $this->imageExtension . "','" . $this->image['name'] . "','photo')");
			$this->imageId = $this->getConnection()->insert_id;
			$this->imageUrl = $this->dir . '/' . generateKey() . '_' . $this->imageId . '_' . md5($this->imageId);
			$this->imageName = $this->imageUrl . '.' . $this->imageExtension;

			if (move_uploaded_file($this->image['tmp_name'], $this->imageName))
			{
				if (preg_match('/(jpg|jpeg)/', $this->imageExtension))
				{
					$this->adjustOrient();
					$this->imageResolution = $this->imageWidth;

					if ($this->imageWidth > $this->imageHeight)
					{
						$this->imageResolution = $this->imageHeight;
					}

					$this->imageResolution = floor($this->imageResolution);

					if ($this->imageResolution > 1150)
					{
						/**/
					}
				}
			}
		}
	}

	private function getExtension($n)
	{
		$n = $this->escapeObj->stringEscape($n);
		$l = strlen($n);
		$k = strrpos($n, '.');
		return strtolower(substr($n, $k + 1, $l - $k));
	}

	public function setImage(\Array $image)
	{
		if (! is_uploaded_file($image['tmp_name']))
    	{
    		return false;
    	}

    	$this->imageExtension = $this->getExtension($image['name']);

    	if (! in_array($this->imageExtension, $this->allowedExtensions))
		{
			return false;
		}

		if ($image['size'] < $this->minImageSize)
		{
			return false;
		}

		$image['name'] = preg_replace('/([^A-Za-z0-9_\-\.]+)/i', '', $image['name']);

		list($this->imageWidth, $this->imageHeight) = getimagesize($image['tmp_name']);
		$this->image = $image;
	}

	public function setAlbumId($a=0)
	{
		$a = (int) $a;
	}

	private function adjustOrient()
	{
	    $image = imagecreatefromjpeg($this->imageName);
	    $exif = exif_read_data($this->imageName);
	 
	    if (! empty($exif['Orientation']))
	    {
	        switch ($exif['Orientation'])
	        {
	            case 3:
	                $image = imagerotate($image, 180, 0);
	                break;

	            case 6:
	                $image = imagerotate($image, -90, 0);
	                break;

	            case 8:
	                $image = imagerotate($image, 90, 0);
	                break;
	        }
	    }

	    imagejpeg($image, $this->imageName);
	    return true;
	}

	function __destruct()
	{
		set_time_limit(60);
	}
}