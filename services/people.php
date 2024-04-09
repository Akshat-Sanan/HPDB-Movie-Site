<?php

date_default_timezone_set('America/Toronto');

require_once("./inc/connect_pdo.php");

$people_id = $_POST["people_id"];

if (empty($people_id)) {
	$people_id = "1";
}

// $people_id = "5";

$query = "SELECT people_hp.people_id, people_hp.name, people_hp.biography, people_hp.date_birth, people_hp.date_death, people_hp.image_id, image_hp.name
FROM people_hp, image_hp
WHERE people_hp.image_id = image_hp.image_id
AND people_hp.people_id = '$people_id'
ORDER BY people_hp.name
LIMIT 0,4";
//print("$query");
foreach($dbo->query($query) as $row) {
	$people_id = stripslashes($row["0"]);
	$people_name = stripslashes($row["1"]);
	$people_biography = nl2br(stripslashes($row["2"]));
	$people_date_birth = stripslashes($row["3"]);
	$people_date_death = stripslashes($row["4"]);
	$people_image_id = stripslashes($row["5"]);
	$people_image_name = stripslashes($row["6"]);

	$display_date_born = date('d F Y', strtotime($people_date_birth));

	if ($people_date_death != "0000-00-00") {
		$display_date_death = date('d F Y', strtotime($people_date_death));
	} else {
		$display_date_death = "";
	}

	$people["people_id"] = $people_id;
	$people["people_name"] = "$people_name";
	$people["people_biography"] = "$people_biography";
	$people["born"] = "$display_date_born";
	$people["died"] = "$display_date_death";
	$people["image_id"] = $people_image_id;
	$people["image_name"] = $people_image_name;



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


	$query = "SELECT movie_hp.movie_id, movie_hp.name, movie_hp.cover_id, movie_hp.date_me
	FROM movie_hp, movie_people_hp
	WHERE movie_people_hp.people_id = '$people_id'
	AND movie_people_hp.movie_id = movie_hp.movie_id";
	//print("$query");
	foreach($dbo->query($query) as $row) {
		$movie_related_id = stripslashes($row["0"]);
		$movie_related_name = stripslashes($row["1"]);
		$movie_related_cover_id = stripslashes($row["2"]);
		$movie_related_date_me = stripslashes($row["3"]);

		$movie_relate["movie_related_id"] = $movie_related_id;
		$movie_relate["movie_related_name"] = $movie_related_name;

		$movie_relate["related_cover_id"] = $movie_related_cover_id;

		$cover_image = get_cover($movie_related_cover_id,$dbo);
		$movie_relate["related_cover_image"] = $cover_image;


		$movie_relate["movie_related_year"] = date('Y', strtotime($movie_related_date_me));

		$movie_related[] = $movie_relate;
}

$people["movie_related"] = $movie_related;

	// if ($people_image_id) {
	// 	$query = "SELECT name
	// 	FROM image
	// 	WHERE image_id = '$people_image_id' ";
	// 	//print("$query");
	// 	foreach($dbo->query($query) as $row) {
	// 		$image_name = stripslashes($row["0"]);
	// 	}
	// }




	// $query = "SELECT image.image_id, image.name, image_people.id
	// FROM image_people, image
	// WHERE image_people.image_id = image.image_id
	// AND image_people.people_id = '$people_id'
	// AND image.image_id != '$people_image_id'
	// ORDER BY image.image_id ";
	// //print("$query");
	// foreach($dbo->query($query) as $row) {
	// 	$image_id = stripslashes($row["0"]);
	// 	$name = stripslashes($row["1"]);
	// 	$image_movie_id = stripslashes($row["2"]);


	// 	$people_image["id"] = $image_id;
	// 	$people_image["name"] = $name;
	// 	$people_images[] = $people_image;

	// }

	// $people["people_images"] = $people_images;


	// $query = "SELECT movie_people.id, people.people_id, people.name, image.image_id, image.name, movie_people.character_name
	// FROM movie_people, people, image, movie
	// WHERE movie_people.people_id = people.people_id
	// AND movie_people.movie_id = movie.movie_id
	// AND people.image_id = image.image_id
	// AND movie_people.people_id = '$people_id'
	// ORDER BY movie.date_me DESC ";

	// $query = "SELECT movie.movie_id, image.image_id, image.name, movie.name, movie_people.character_name, movie.date_me
	// FROM movie_people, image, movie
	// WHERE movie_people.movie_id = movie.movie_id
	// AND movie.cover_id = image.image_id
	// AND movie_people.people_id = '$people_id'
	// ORDER BY movie.date_me DESC ";


	// foreach($dbo->query($query) as $row) {
	// 	$movie_id = stripslashes($row["0"]);
	// 	$image_id = stripslashes($row["1"]);
	// 	$image_name = stripslashes($row["2"]);
	// 	$movie_name = stripslashes($row["3"]);
	// 	$character_name = stripslashes($row["4"]);
	// 	$date_me = stripslashes($row["5"]);

	// 	$movie["movie_id"] = $movie_id;
	// 	$movie["image_id"] = $image_id;
	// 	$movie["image_name"] = $image_name;
	// 	$movie["movie_name"] = $movie_name;
	// 	$movie["character_name"] = $character_name;
	// 	$year = date('Y', strtotime($date_me));
	// 	$movie["year"] = $year;


	// 	$movies[] = $movie;

	// }

	// $people["movies"] = $movies;


}






$data = json_encode($people);

header("Content-Type: application/json");

print($data);




?>