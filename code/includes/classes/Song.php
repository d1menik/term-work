<?php

class Song
{
    private $conn;
    private $id;
    private $title;
    private $artistId;
    private $albumId;
    private $duration;
    private $path;
    private $plays;

    public function __construct($conn, $id)
    {
        $this->conn = $conn;
        $this->id = $id;

        $stmt = $this->conn->prepare("SELECT * FROM songs WHERE song_id=:id");
        $stmt->bindParam('id', $id);
        $stmt->execute();

        $song = $stmt->fetch();

        $this->title = $song['title'];
        $this->artistId = $song['artist_id'];
        $this->albumId = $song['album_id'];
        $this->duration = $song['duration'];
        $this->path = $song['path'];
        $this->plays = $song['plays'];

    }
    public function getTitle() {
        return $this->title;
    }
    public function getArtist() {
        return new Artist($this->conn, $this->artistId);
    }
    public function getAlbum() {
        return new Album($this->conn, $this->albumId);
    }
    public function getPath() {
        return $this->path;
    }
    public function getDuration() {
        return $this->duration;
    }
    public function plays() {
        return $this->plays;
    }

}