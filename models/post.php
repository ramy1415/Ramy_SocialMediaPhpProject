<?php


class post{
    public $body;
    public $user_id;
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
    public function insert($postbody)
    {
        $sql = "INSERT INTO posts (body, user_id) VALUES ('{$postbody->body}',{$postbody->user_id})";
        $this->mysqli -> query($sql);
    }
    public function insertwithimage($postbody)
    {
        $sql = "INSERT INTO posts (body, user_id) VALUES ('{$postbody->body}' '<br>' '<img src=../files/images/{$postbody->image} >'   ,{$postbody->user_id})";
        $this->mysqli -> query($sql);
    }
    public function delete($postid)
    {
        $sql = "DELETE FROM posts WHERE id={$postid}";
        $sql2 = "DELETE FROM comments WHERE post_id={$postid}";
        $this->mysqli -> query($sql2);
        $this->mysqli -> query($sql);
    }

}

?>