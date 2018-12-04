<?php
class RandomAlbums
{
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getSomeSongs()
    {
        $stmt = $this->conn->prepare("SELECT * FROM albums ORDER BY RAND() LIMIT 10");
        $stmt->execute();

        return $stmt->fetchAll();
    }

}