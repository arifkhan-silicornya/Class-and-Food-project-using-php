<?php

namespace miuan;

class registerUser {
    private $conn;
    private $escapeObj;
    private $id;

    private $name;
    private $usename;
    private $email;
    private $password;
    private $gender;
    private $birthday = '1-1-1990';
    private $location = '';
    private $hometown = '';
    private $about = '';

    private $allowedGenders = array('male', 'female');

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
        if (! empty ($this->name) && ! empty ($this->username) && ! empty ($this->email) && ! empty ($this->password) && ! empty ($this->gender))
        {
            $query = $this->getConnection()->query("INSERT INTO " . DB_ACCOUNTS . " (active,about,cover_id,email,email_verification_key,name,password,time,type,username) VALUES (1,'" . $this->about . "',0,'" . $this->email . "','" . md5(generateKey()) . "','" . $this->name . "','" . $this->password . "'," . time() . ",'user','" . $this->username . "')");

            if ($query)
            {
                $this->id = $this->getConnection()->insert_id;
                $query2 = $this->getConnection()->query("INSERT INTO " . DB_USERS . " (id,birthday,gender,current_city,hometown) VALUES (" . $this->id . ",'" . $this->birthday . "','" . $this->gender . "','" . $this->location . "','" . $this->hometown . "')");

                if ($query2)
                {
                    $timelineObj = new \miuan\User();
                    $timelineObj->setId($this->id);
                    $get = $timelineObj->getRows();
                    return $get;
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

    public function setName($n)
    {
        if (! empty($n))
        {
            $this->name = $this->escapeObj->stringEscape($n);
        }
    }

    public function setUsername($u)
    {
        if ($this->validateUsername($u))
        {
            $this->username = $this->escapeObj->stringEscape($u);
        }
    }

    public function setEmail($e)
    {
        if (filter_var($e, FILTER_VALIDATE_EMAIL))
        {
            $this->email = $this->escapeObj->stringEscape($e);
        }
    }

    public function setPassword($p)
    {
        if (! empty($p))
        {
            $this->password = md5( trim($p));
        }
    }

    public function setGender($g)
    {
        if (in_array($g, $this->allowedGenders))
        {
            $this->gender = $g;
        }
    }

    public function setBirthday($b)
    {
        if (is_array($b))
        {
            $b = implode('-', $b);
            $regex = '/^([0-9]{1,2})\-([0-9]{1,2})\-([0-9]{4})$/';

            if (preg_match($regex, $b))
            {
                $this->birthday = $b;
            }
        }
    }

    public function setLocation($l)
    {
        if (! empty($l))
        {
            $this->location = $this->escapeObj->stringEscape($l);
        }
    }

    public function setHometown($h)
    {
        if (! empty($h))
        {
            $this->hometown = $this->escapeObj->stringEscape($h);
        }
    }

    public function setAbout($a)
    {
        if (! empty($a))
        {
            $this->about = $this->escapeObj->stringEscape($a);
        }
    }
}