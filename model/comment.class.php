<?php


class Comment{
    private $commentid;
    private $comment;
    private $username;
    private $fileID;


    function __construct($commentid, $comment, $username, $fileID)
    {
        $this->commentid = $commentid;
        $this->comment = $comment;
        $this->username = $username;
        $this->fileID = $fileID;

    }


    function get_commentid()
    {
        return $this->commentid;
    }
    //set nachname und get nachname
    function set_commentid($new_commentid)
    {
        $this->commentid = $new_commentid;
    }

    function get_comment()
    {
        return $this->comment;
    }
    //set nachname und get nachname
    function set_comment($new_comment)
    {
        $this->comment = $new_comment;
    }

    function get_comusername()
    {
        return $this->username;
    }

    //set nachname und get nachname
    function set_comusername($new_username)
    {
        $this->username = $new_username;
    }

    function get_fileID()
    {
        return $this->fileID;
    }
    function set_fileID($new_fileID)
    {
        $this->fileID = $new_fileID;
    }

}







