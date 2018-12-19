<?php

class Album
{
    private $conn;
    private $id;
    private $title;
    private $artist_id;
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
        $this->artist_id = $album['artist_id'];
        $this->genre = $album['genre_id'];
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

    public function getArtist()
    {
        return new Artist($this->conn, $this->artist_id);
    }

    public function getSongIds()
    {
        $stmt = $this->conn->prepare("SELECT * FROM songs WHERE album_id=:id ORDER BY albumOrder ASC");

        $stmt->bindParam('id', $this->id);
        $stmt->execute();

        $songs = $stmt->fetchAll();

        $resultArr = array();

        foreach ($songs as $row) {
            array_push($resultArr, $row['song_id']);
        }
        return $resultArr;
    }
}