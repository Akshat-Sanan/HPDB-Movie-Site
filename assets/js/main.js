function getSplash() {
    $(".hideAll").hide();
    $(".loadingScreen").show();
    $(window).scrollTop(0);

    let getSplash = $.ajax({
        url: "./services/splash.php",
        type: "POST",
        dataType: "json"
    });

    getSplash.fail(function (jqXHR, textStatus) {
        alert("Something went Wrong! (getSplash)" +
            textStatus);
    });

    getSplash.done(function (data) {
        let content='';
        $.each(data.slice(0, -1), function (i, item) {
            let movie_id = item.movie_id;
            let name = item.movie_name;
            let cover_id = item.cover_id;
            let cover_image = item.cover_image;
            let movie_year = item.movie_year;

            content += `<div class="cell small-12 medium-6 large-3  min-height-360 movie" data-id="${movie_id}">
            <img src="./uploads/${cover_id}/${cover_image}" alt="${name}">
            <h5>${name}</h5>
            <h5>${movie_year}</h5>
            </div>`;


        } );
        $(".splashPage-poster").html(`<img src="./uploads/${data[data.length-1].poster_id}/${data[data.length-1].poster_image}" alt="${data[data.length-1].name}">`);
        $(".splashPage-trailer").html(`<iframe  src="https://www.youtube.com/embed/${data[data.length-1].youtube}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>`);
        $(".posterContainer-splash").html(content);

        $(".splash-page").show();
        $(".loadingScreen").hide();
    });

}

function getMovie(id) {
    $(".loadingScreen").show();
    $(".hideAll").hide();
    $(window).scrollTop(0);

    // $(".movie-images").slick('unslick');

    let getMovie = $.ajax({
        url: "./services/movie.php",
        data: {movie_id:id},
        type: "POST",
        dataType: "json"
    });

    getMovie.fail(function (jqXHR, textStatus) {
        alert("Something went Wrong! (getMovie)" +
            textStatus);
    });

    getMovie.done(function (data) {

        let movie_name = data.movie_name;
        let description = data.description;
        let movie_rating = data.movie_rating;
        let hours = data.hours;
        let minutes = data.minutes;
        let date = data.date;
        let writer = data.writer;
        let director = data.director;
        let youtube = data.youtube;
        let poster_image_id = data.poster_image_id;
        let poster_image_name = data.poster_image_name;
        let category = data.category;


        let content_genre = ``;
        $.each(data.genre, function (i, item) {
            if (content_genre === "") {
                content_genre = `${item}`;
            } else {
                content_genre += `, ${item}`;
            }
        } );

        $('.movieName').html(movie_name);
        $('.moviePage-poster').html(`<img src="./uploads/${poster_image_id}/${poster_image_name}" alt="${poster_image_name}">`);
        $('.moviePage-trailer').html(`<iframe src="https://www.youtube.com/embed/${youtube}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>`);
        $('.movieInfo').html(`
        <h5><span>Genre :</span> ${content_genre}</h5>
        <h5><span>Director :</span> ${director}</h5>
        <h5><span>Writer :</span> ${writer}</h5>
        <h5><span>Rating :</span> ${movie_rating}</h5>
        <h5><span>Category :</span> ${category}</h5>
        <h5><span>Date :</span> ${date}</h5>
        <h5><span>Length :</span> ${hours}h ${minutes}min</h5>
        `);
        $('.movieDescript').html(description);


    content = ``;
    $.each(data.movie_images, function (i, item) {
        let movie_image_id = item.id;
        let movie_image_name = item.name;

        content +=`
            <div class="cell small-12 medium-4  min-height-120"><img src="./uploads/${movie_image_id}/${movie_image_name}" alt="${movie_image_name}"></div>
        `;
    });

    $(".movie-images").html(content);
    // startMovieSlider();


    content = ``;
    $.each(data.cast, function (i, item) {
        let people_id = item.people_id;
        let name = item.name;
        let image_id = item.image_id;
        let image_name = item.image_name;
        let character_name = item.character_name;

        content += `<div class="cell small-6 medium-4 large-2  min-height-180 person" data-id="${people_id}">
        <img src="./uploads/${image_id}/${image_name}" alt="${name}">
                        <h5>${name}</h5>
                        <h5>${character_name}</h5>
                    </div>`;
    });

    $(".actorContainer-movie").html(content);


    content = ``;
    $.each(data.movie_related, function (i, item) {
        let movie_related_id = item.movie_related_id;
        let movie_related_name = item.movie_related_name;
        let related_cover_id = item.related_cover_id;
        let related_cover_image = item.related_cover_image;
        let movie_related_year = item.movie_related_year;

        content += `<div class="cell small-12 medium-6 large-3  min-height-360 movie" data-id="${movie_related_id}">
            <img src="./uploads/${related_cover_id}/${related_cover_image}" alt="${movie_related_name}">
            <h5>${movie_related_name}</h5>
            <h5>${movie_related_year}</h5>
            </div>`;
    });

    $(".posterContainer-moviePage").html(content);


    });


    $(".movie-page").show();
    $(".loadingScreen").hide();
}

// function startMovieSlider () {
//     $(".movie-images").slick({
//         infinite: true,
//         slidesToShow: 3,
//         slidesToScroll: 1,
//         dots: true,

//       });
//       //autoplay: true,
//       //autoplaySpeed: 2000,
// }

function getPerson(id) {
    $(".loadingScreen").show();
    $(".hideAll").hide();
    $(window).scrollTop(0);

    let getPeople = $.ajax({
        url: "./services/people.php",
        data: {people_id:id},
        type: "POST",
        dataType: "json"
    });

    getPeople.fail(function (jqXHR, textStatus) {
        alert("Something went Wrong! (getSplash)" +
            textStatus);
    });

    getPeople.done(function (data) {

            let people_id = data.people_id;
            let people_name = data.people_name;
            let people_biography = data.people_biography;
            let born = data.born;
            let died = data.died;
            let image_id = data.image_id;
            let image_name = data.image_name;

            $(".actorName").html(people_name);
            $(".actorBio").html(people_biography);

            if(died != ""){
                $(".actorInfo").html(`<h6>Born</h6><h5>${born}</h5>
                                        <h6>Died</h6><h5>${died}</h5>
                `)
            }else{
                $(".actorInfo").html(`<h6>Born</h6><h5>${born}</h5>`)
            }

            $(".actorIMG").html(`<img src="./uploads/${image_id}/${image_name}" alt="${people_name}">`);

    content = ``;
    $.each(data.movie_related, function (i, item) {
        let movie_related_id = item.movie_related_id;
        let movie_related_name = item.movie_related_name;
        let related_cover_id = item.related_cover_id;
        let related_cover_image = item.related_cover_image;
        let movie_related_year = item.movie_related_year;

        content += `<div class="cell small-12 medium-6 large-3  min-height-360 movie" data-id="${movie_related_id}">
            <img src="./uploads/${related_cover_id}/${related_cover_image}" alt="${movie_related_name}">
            <h5>${movie_related_name}</h5>
            <h5>${movie_related_year}</h5>
            </div>`;
    });

    $(".posterContainer-peoplePage").html(content);

    $(".person-page").show();
    $(".loadingScreen").hide();
});



}


function getSearch (searchText) {


    // $(".movie-related").slick('unslick');

    let getSearch = $.ajax({
        url: "./services/search.php",
        data: {search_text:searchText},
        type: "POST",
        dataType: "json"
    });



    getSearch.done(function (data) {
        // console.log(data);
        let content = ``;
        $.each(data, function (i, item) {
            let type = item.type;

            if (type == "1") {
                let movie_id = item.movie_id;
                let name = item.movie_name;
                let image_id = item.cover_id;
                let image_name = item.cover_name;
                content += `<div class="movie menu-style" data-id="${movie_id}"><img src="./uploads/${image_id}/${image_name}"><span>${name}</span></div>`;
            } else {
                let people_id = item.people_id;
                let name = item.people_name;
                let image_id = item.poeple_cover_id;
                let image_name = item.cover_name;
                content += `<div class="person menu-style" data-id="${people_id}"><img src="./uploads/${image_id}/${image_name}"><span>${name}</span></div>`;
            }

        } );
        $(".menu-list").html(content);

    });
}


$(window).on("load", function () {

    // startMovieSlider();

    $("#search").keyup(
        function () {
            let searchText = $("#search").val();
            // alert(searchText);
            getSearch(searchText);
        }

    );

    $(document).on('click', 'body .splash', function () {
        location.href = "#/splash/";
    });


    $(document).on('click', 'body .person', function () {
        let people_id = $(this).attr("data-id");
        // $(".person-name").html(people_id);
        location.href = `#/people/${people_id}`;
    });


    $(document).on('click', 'body .movie', function () {
        let movie_id = $(this).attr("data-id");
        location.href = `#/movie/${movie_id}`;
    });



    var app = $.sammy(function () {

        this.get('#/splash/', function () {
            getSplash();
        });

        this.get('#/movie/:id', function () {
            let id = this.params["id"];
            getMovie(id);
        });

        this.get('#/people/:id', function () {
            let id = this.params["id"];
            getPerson(id);
        });

    });

	// default when page first loads
    $(function () {
        app.run('#/splash/');
    });
});
