<?php

class Playlist
{
    private $conn;
    private $id;
    private $name;
    private $owner;

    public function __construct($conn, $id)
    {
        $this->conn = $conn;
        $this->id = $id;

        $stmt = $this->conn->prepare("SELECT * FROM playlists WHERE playlist_id=:id");
        $stmt->bindParam('id', $id);
        $stmt->execute();

        $playlist = $stmt->fetch();

        $this->id = $playlist['playlist_id'];
        $this->name = $playlist['name'];
        $this->owner = $playlist['user_id'];
    }

    public function getName()
    {
        return $this->name;
    }

    public function getOwner()
    {
        return $this->owner;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNumberOfSongs()
    {
        $stmt = $this->conn->prepare("SELECT song_id FROM listSongs WHERE playlist_id=:id");
        $stmt->bindParam('id', $this->id);
        $stmt->execute();

        $numberOfSongs = $stmt->rowCount();
        return $numberOfSongs;
    }

    public function getSongIds()
    {
        $stmt = $this->conn->prepare("SELECT song_id FROM listSongs WHERE playlist_id=:id ORDER BY playlistOrder ASC");
        $stmt->bindParam('id', $this->id);
        $stmt->execute();

        $songIds = $stmt->fetchAll();
        $arrIds = array();

        foreach ($songIds as $songId) {
            array_push($arrIds, $songId['song_id']);
        }
        return $arrIds;

    }

}