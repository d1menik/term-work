<?php
class Random
{
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getSomeAlbums()
    {
        $stmt = $this->conn->prepare("SELECT * FROM albums ORDER BY RAND() LIMIT 10");
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getSomeSongs() {
        $stmt = $this->conn->prepare("SELECT * FROM songs ORDER BY RAND() LIMIT 10");
        $stmt->execute();

        return $stmt->fetchAll();
    }


}