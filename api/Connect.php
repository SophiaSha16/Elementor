<?php

class Connect
{
    private const DATA_FILE = '../db.txt';


    public function getAllUsers()
    {
        // open the file for reading and writing
        $file = fopen(self::DATA_FILE, 'a+') or die($php_errormsg);
        rewind($file) or die($php_errormsg);

        // get an exclusive lock on the file 
        flock($file, LOCK_EX) or die($php_errormsg);

        // read in and unserialize the data
        $users_data = fread($file, filesize(self::DATA_FILE)) or die($php_errormsg);


        return $users_data;
    }



    public function updateUsersDB($usersJSON)
    {
        // open the file for reading and writing
        $file = fopen(self::DATA_FILE, 'a+') or die($php_errormsg);
        rewind($file) or die($php_errormsg);


        // clear out the file
        rewind($file) or die($php_errormsg);
        ftruncate($file, 0) or die($php_errormsg);

        // write the data back to the file and release the lock 
        if (-1 == (fwrite($file, $usersJSON))) {
            die($php_errormsg);
        }
        fflush($file) or die($php_errormsg);
        flock($file, LOCK_UN) or die($php_errormsg);
        fclose($file) or die($php_errormsg);
    }
}
