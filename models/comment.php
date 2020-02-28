<?php

class comment{
    public $body;
    public $user_id;
    public $user_Name;
    public $image;
    public $mysqli;
    public function __construct()
    {
        $this->mysqli = new mysqli("localhost","root","","socialmedia"); 
        if ($this->mysqli -> connect_errno) {
        echo "Failed to connect to MySQL: " . $this->mysqli -> connect_error;
        exit(); 
        }
    }
    public function insert($commentbody)
    {
        $sql = "INSERT INTO posts (body, user_id) VALUES ('{$commentbody->body}',{$commentbody->user_id})";
        $this->mysqli -> query($sql);
    }
    public function insertwithimage($commentbody)
    {
        $sql = "INSERT INTO posts (body, user_id) VALUES ('{$commentbody->body}' '<br>' '<img src=../files/images/{$commentbody->image} >'   ,{$commentbody->user_id})";
        $this->mysqli -> query($sql);
    }
    public function delete($commentid)
    {
        $sql = "DELETE FROM comments WHERE id={$commentid}";
        $this->mysqli -> query($sql);
    }

}

?>