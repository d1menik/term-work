<?include("includes/includes.php"); ?>
<h1>Discover For You</h1>

<div class="gridContainer">

    <?php
    $stmt = $conn->prepare("SELECT * FROM albums ORDER BY RAND() LIMIT 10");
    $stmt->execute();
    $randAlbums = $stmt->fetchAll();

    foreach ($randAlbums as $row) {
        $logoPath = $row['logoPath'];
        $title = $row['title'];
        $id = $row['album_id'];

        echo "<div class ='gridItem'>
                              <span onclick=openPage('album.php?id=$id')>
                              <img src=$logoPath alt='logo'>
                              <div class='gridInfo'>$title</div>
                              </span>
                              </div>";
    }
    ?>
</div>