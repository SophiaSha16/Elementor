<?php

require_once './Connect.php';
$connect = new Connect();



class User
{

    function __construct($name, $email)
    {
        $this->name = $name;
        $this->email = $email;

    }

    public function buildFrom($userData)
    {
        $this->entranceTime = $userData->entranceTime;
        $this->lastUpdateTime = $userData->lastUpdateTime;
        $this->IP = $userData->IP;
        $this->userAgent = $userData->userAgent;;
        $this->visitsCount = $userData->visitsCount;
        $this->isOnline = $userData->isOnline;

        return $this;
    }



    public function buildNew()
    {
        $this->entranceTime = date("Y/m/d") . " " . date("h:i:sa");
        $this->lastUpdateTime = date("Y/m/d") . " " . date("h:i:sa");
        $this->IP = $this->getIPAddress();
        $this->userAgent = $_SERVER['HTTP_USER_AGENT'];
        $this->visitsCount = 1;
        $this->isOnline = true;

        return $this;
    }


    public function updateUserOnLogin($userData)
    {
        $this->entranceTime = date("Y/m/d") . " " . date("h:i:sa");
        $this->lastUpdateTime = date("Y/m/d") . " " . date("h:i:sa");
        $this->IP = $this->getIPAddress();
        $this->userAgent = $_SERVER['HTTP_USER_AGENT'];
        $this->visitsCount = $userData->visitsCount + 1;
        $this->isOnline = true;

        return $this;
    }


    public function updateUserOnLogout($userData)
    {
        $this->entranceTime = $userData->entranceTime;
        $this->lastUpdateTime =date("Y/m/d") . " " . date("h:i:sa");
        $this->IP = $userData->IP;
        $this->userAgent = $userData->userAgent;;
        $this->visitsCount = $userData->visitsCount;
        $this->isOnline =false;

        return $this;
    }


    function getIPAddress()
    {
        //whether IP is from the share internet  
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $IP = $_SERVER['HTTP_CLIENT_IP'];
        }
        //whether IP is from the proxy  
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $IP = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        //whether IP is from the remote address  
        else {
            $IP = $_SERVER['REMOTE_ADDR'];
        }
        return $IP;
    }
}
