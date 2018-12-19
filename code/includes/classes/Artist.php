<?php

class Artist
{
    private $conn;
    private $id;

    public function __construct($conn, $id)
    {
        $this->conn = $conn;
        $this->id = $id;
    }

    public function getName()
    {
        $stmt = $this->conn->prepare("SELECT * FROM artists WHERE artist_id=:id");
        $stmt->bindParam('id', $this->id);
        $stmt->execute();

        $artist = $stmt->fetch();
        return $artist['name'];
    }
}