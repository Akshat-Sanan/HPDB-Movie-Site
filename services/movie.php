<?php


// NEED TO SEND POST OF movie_id



date_default_timezone_set('America/Toronto');

require_once("./inc/connect_pdo.php");

$movie_id = $_POST["movie_id"];


if (empty($movie_id)) {
	$movie_id = "1";
}

$query = "SELECT movie_id, name, rating, hour_me, minute_me, category_id, date_me, descript, country_id, language_id, youtube, writer, director, cover_id, poster_id
FROM movie_hp
WHERE movie_id = '$movie_id'
ORDER BY name ";
//print("$query");
foreach($dbo->query($query) as $row) {
	$movie_id = stripslashes($row["0"]);
	$movie_name = stripslashes($row["1"]);
	$movie_rating = stripslashes($row["2"]);
	$movie_hour_me = stripslashes($row["3"]);
	$movie_minute_me = stripslashes($row["4"]);
	$movie_category_id = stripslashes($row["5"]);
	$movie_date_me = stripslashes($row["6"]);
	$movie_descript = nl2br(stripslashes($row["7"]));
	$movie_country_id = stripslashes($row["8"]);
	$movie_language_id = stripslashes($row["9"]);
	$youtube = stripslashes($row["10"]);
	$writer  = stripslashes($row["11"]);
	$director = stripslashes($row["12"]);
	$movie_cover_id = stripslashes($row["13"]);
	$movie_poster_id = stripslashes($row["14"]);
	$display_date = date('d F Y', strtotime($movie_date_me));

	$movie["movie_id"] = $movie_id;
	$movie["movie_name"] = $movie_name;
	$movie["description"] = $movie_descript;
	$movie["movie_rating"] = $movie_rating;
	$movie["hours"] = "$movie_hour_me";
	$movie["minutes"] = "$movie_minute_me";
	$movie["date"] = "$display_date";
	$movie["writer"] = "$writer";
	$movie["director"] = "$director";
	$movie["youtube"] = $youtube;
}

if ($movie_poster_id) {
	$query = "SELECT name
	FROM image_hp
	WHERE image_id = '$movie_poster_id' ";
	foreach($dbo->query($query) as $row) {
		$image_poster_name = stripslashes($row["0"]);
	}
}

$movie["poster_image_id"] = $movie_poster_id;
$movie["poster_image_name"] = $image_poster_name;





	$query = "SELECT genre_movie_hp.id, genre.name
	FROM genre_movie_hp, genre
	WHERE genre_movie_hp.genre_id = genre.genre_id
	AND genre_movie_hp.movie_id = '$movie_id'
	ORDER BY genre.name ";
	//print("$query");
	foreach($dbo->query($query) as $row) {
		$genre_movie_id = stripslashes($row["0"]);
		$name = stripslashes($row["1"]);

		$genre[] = $name;

	}

	$movie["genre"] = $genre;



	$query = "SELECT category_id, name
	FROM category
	ORDER BY category_id ";
	//print("$query");
	foreach($dbo->query($query) as $row) {
		$category_id = stripslashes($row["0"]);

		if ($movie_category_id == $category_id) {
			$category_name = stripslashes($row["1"]);
		}
	}

	$movie["category"] = "$category_name";



	$query = "SELECT image_hp.image_id, image_hp.name, image_movie_hp.id
	FROM image_movie_hp, image_hp
	WHERE image_movie_hp.image_id = image_hp.image_id
	AND image_movie_hp.movie_id = '$movie_id'
	ORDER BY image_hp.image_id
	LIMIT 0,3";
	//print("$query");
	foreach($dbo->query($query) as $row) {
		$image_id = stripslashes($row["0"]);
		$name = stripslashes($row["1"]);
		$image_movie_id = stripslashes($row["2"]);

		$movie_image["id"] = $image_id;
		$movie_image["name"] = $name;
		$movie_images[] = $movie_image;

	}

	$movie["movie_images"] = $movie_images;



	unset($movie_images,$movie_image);

	// $query = "SELECT movie_related.id, movie.cover_id, image.name, movie.movie_id, movie.name
	// FROM movie_related, movie, image
	// WHERE movie_related.related_movie_id = movie.movie_id
	// AND movie.cover_id = image.image_id
	// AND movie_related.movie_id = '$movie_id'
	// ORDER BY movie_related.movie_id ";
	// foreach($dbo->query($query) as $row) {
	// 	$related_id = stripslashes($row["0"]);
	// 	$image_id = stripslashes($row["1"]);
	// 	$name = stripslashes($row["2"]);
	// 	$movie_id2 = stripslashes($row["3"]);
	// 	$movie_name = stripslashes($row["4"]);

	// 	$movie_image["movie_id"] = $movie_id2;
	// 	$movie_image["movie_name"] = $movie_name;
	// 	$movie_image["id"] = $image_id;
	// 	$movie_image["name"] = $name;

	// 	$movie_images[] = $movie_image;
	// }

	// $movie["related_movies"] = $movie_images;



	$query = "SELECT movie_people_hp.id, people_hp.people_id, people_hp.name, image_hp.image_id, image_hp.name, movie_people_hp.character_name
	FROM movie_people_hp, people_hp, image_hp
	WHERE movie_people_hp.people_id = people_hp.people_id
	AND people_hp.image_id = image_hp.image_id
	AND movie_people_hp.movie_id = '$movie_id'
	ORDER BY movie_people_hp.id ";


	foreach($dbo->query($query) as $row) {
		$movie_people_id = stripslashes($row["0"]);
		$people_id = stripslashes($row["1"]);
		$name = stripslashes($row["2"]);
		$image_id = stripslashes($row["3"]);
		$image_name = stripslashes($row["4"]);
		$character_name = stripslashes($row["5"]);

		$cast_member["people_id"] = $people_id;
		$cast_member["name"] = $name;
		$cast_member["image_id"] = $image_id;
		$cast_member["image_name"] = $image_name;
		$cast_member["character_name"] = $character_name;
		$cast[] = $cast_member;
	}

	$movie["cast"] = $cast;

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

	$query = "SELECT movie_id, name, cover_id, date_me
	FROM movie_hp
	WHERE movie_hp.movie_id != '$movie_id'
	ORDER BY RAND()
	LIMIT 0, 4";
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

$movie["movie_related"] = $movie_related;


	$query = "SELECT country_id, name
	FROM country
	ORDER BY name ";
	//print("$query");
	foreach($dbo->query($query) as $row) {
		$country_id = stripslashes($row["0"]);
		$name = stripslashes($row["1"]);

		if ($movie_country_id == $country_id) {
			$country = "$name";
		}
	}

	// $movie["country"] = $country;

	$query = "SELECT language_id, name
	FROM language
	ORDER BY name ";
	//print("$query");
	foreach($dbo->query($query) as $row) {
		$language_id = stripslashes($row["0"]);
		$name = stripslashes($row["1"]);

		if ($movie_language_id == $language_id) {
			$language = "$name";
		}
	}


	// $movie["language"] = $language;


$data = json_encode($movie);

header("Content-Type: application/json");

print($data);

?>