<?php


// NEED TO SEND POST OF movie_id




require_once("./inc/connect_pdo.php");

$search_count = $_POST["movie_count"];
$search_text = $_POST["search_text"];


if ($search_count) {
	$search_count = $search_count;
} else {
	$search_count = "10";
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



$query = "SELECT movie_id, name, cover_id
FROM movie_hp
WHERE name LIKE '%$search_text%'
ORDER BY name
LIMIT 0,$search_count";
//print("$query");
foreach($dbo->query($query) as $row) {
	$movie_id = stripslashes($row["0"]);
	$movie_name = stripslashes($row["1"]);
	$movie_cover_id = stripslashes($row["2"]);

	unset($movie);

	$movie["type"] = "1";

	$movie["movie_id"] = $movie_id;

	$movie["movie_name"] = $movie_name;
	$movie["cover_id"] = $movie_cover_id;

	$cover = get_cover($movie_cover_id,$dbo);
	$movie["cover_name"] = $cover;



	$movies["$movie_name"] = $movie;
}


unset($movie);


function get_cover_people ($poeple_cover_id,$dbo) {
	$query = "SELECT name
	FROM image_hp
	WHERE image_id = '$poeple_cover_id' ";
	//print("$query");
	foreach($dbo->query($query) as $row) {
		$image_name = stripslashes($row["0"]);
	}

	return $image_name;
}

$query = "SELECT people_id, name, image_id
FROM people_hp
WHERE name LIKE '%$search_text%'
ORDER BY name
LIMIT 0,$search_count";
//print("$query");
foreach($dbo->query($query) as $row) {
	$people_id = stripslashes($row["0"]);
	$people_name = stripslashes($row["1"]);
	$poeple_cover_id = stripslashes($row["2"]);

	unset($movie);
	$movie["type"] = "2";
	$movie["people_id"] = $people_id;

	$movie["people_name"] = $people_name;
	$movie["poeple_cover_id"] = $poeple_cover_id;

	$cover = get_cover_people($poeple_cover_id,$dbo);
	$movie["cover_name"] = $cover;



	$movies["$movie_name"] = $movie;
}

ksort($movies);

//

while(count($movies) > $search_count) {
	array_pop($movies);
}



if (empty($search_text)) {
	unset($movies);
}


$data = json_encode($movies);

header("Content-Type: application/json");

print($data);




?>