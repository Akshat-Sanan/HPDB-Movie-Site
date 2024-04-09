<?php


// NEED TO SEND POST OF movie_id




require_once("./inc/connect_pdo.php");

$movie_count = $_POST["movie_count"];


if ($movie_count) {
	$movie_count = $movie_count;
} else {
	$movie_count = "8";
}

function get_cover ($movie_cover_id,$dbo) {
	$query = "SELECT name
	FROM image_hp
	WHERE image_id = '$movie_cover_id' ";
	//print("$query");
	foreach($dbo->query($query) as $row) {
		$image_name = stripslashes($row["0"]);
	}

	return $image_name;
}

function get_poster ($movie_poster_id,$dbo) {
	$query = "SELECT name
	FROM image_hp
	WHERE image_id = '$movie_poster_id' ";
	//print("$query");
	foreach($dbo->query($query) as $row) {
		$imagePoster_name = stripslashes($row["0"]);
	}

	return $imagePoster_name;
}



$query = "SELECT movie_id, name, cover_id, date_me
FROM movie_hp
ORDER BY RAND()";
//print("$query");
foreach($dbo->query($query) as $row) {
	$movie_id = stripslashes($row["0"]);
	$movie_name = stripslashes($row["1"]);
	$movie_cover_id = stripslashes($row["2"]);
	$movie_date_me = stripslashes($row["3"]);

	$movie["movie_id"] = $movie_id;
	$movie["movie_name"] = $movie_name;

	$movie["cover_id"] = $movie_cover_id;

	$cover_image = get_cover($movie_cover_id,$dbo);
	$movie["cover_image"] = $cover_image;


	$movie["movie_year"] = date('Y', strtotime($movie_date_me));

	$movies[] = $movie;
}


$queryPoster = "SELECT name, poster_id, youtube, movie_id
FROM movie_hp
ORDER BY RAND()
-- WHERE movie_id = '8'
LIMIT 1";
//print("$query");
foreach($dbo->query($queryPoster) as $row) {
	$movie_name = stripslashes($row["0"]);
	$movie_poster_id = stripslashes($row["1"]);
	$movie_youtube = stripslashes($row["2"]);

	$movie2["name"] = $movie_name;
	$movie2["poster_id"] = $movie_poster_id;
	$movie2["youtube"] = $movie_youtube;

	$poster_image = get_poster($movie_poster_id,$dbo);
	$movie2["poster_image"] = $poster_image;

	$movies[] = $movie2;
}




$data = json_encode($movies);

header("Content-Type: application/json");

print($data);




?>