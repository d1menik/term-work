<?php

class Album
{
    private $conn;
    private $id;
    private $title;
    private $artistId;
    private $genre;
    private $logo;

    public function __construct($conn, $id)
    {
        $this->conn = $conn;
        $this->id = $id;

        $stmt = $this->conn->prepare("SELECT * FROM albums WHERE album_id=:id");
        $stmt->bindParam('id', $id);
        $stmt->execute();

        $album = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->title = $album['title'];
        $this->artistId = $album['artist'];
        $this->genre = $album['genre'];
        $this->logo = $album['logoPath'];
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function logoPath()
    {
        return $this->logo;
    }
}