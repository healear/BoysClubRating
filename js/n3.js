function ReadFilms() {
    class Film{
    constructor(id, name, year, country, genre, rating, actors, awards)
    {
        this.id = id;
        this.name = name;
        this.year = year;
        this.country = country;
        this.genre = genre;
        this.rating = rating;
        this.actors = actors;
        this.awards = awards;
	}

    addActor(_actor){
    this.actors+=", "+_actor;
	}

    addAward(_award)
    {
     this.awards+=", "+_award;
	}
	}

    $.ajax({
        type: "GET",
        dataType: "text",
        url: "php/controller.php",
        data: {},
        success: function (data) {

            var Tresult = JSON.parse(data);
            console.log(Tresult);
            var MovieId = Tresult[0].Id;
            var filmAr = [];

            var newFilm = new Film(Tresult[0].Id, Tresult[0].Name,Tresult[0].Year, Tresult[0].Country, Tresult[0].Genre, Tresult[0].Rating, Tresult[0].Actor, Tresult[0].Award);
            for (var i = 1; i<Tresult.length; i++)
            {
                if (MovieId !== Tresult[i].Id)
                {
                    MovieId = Tresult[i].Id;
                    filmAr.push(newFilm);
                    newFilm = new Film(Tresult[i].Id, Tresult[i].Name,Tresult[i].Year, Tresult[i].Country, Tresult[i].Genre, Tresult[i].Rating, Tresult[i].Actor, Tresult[i].Award);
				}
                else
                {
                    if (!newFilm.actors.includes(Tresult[i].Actor)){
                    newFilm.addActor(Tresult[i].Actor);
                    }
                    if (!newFilm.awards.includes(Tresult[i].Award)){
                    newFilm.addAward(Tresult[i].Award);
                    }

				}
			}
        filmAr.push(newFilm);

        $(".Films_Table--d").html("");
            for (var i = 0; i < filmAr.length; i++) {
                var Block = "";
                console.log(filmAr[i].name);
                Block = "<tr class='Films_Table--record'>";
                Block += "<th><input class = '_oname_film"+filmAr[i].id+"' maxlength='50' size='30' value = '"+filmAr[i].name+"'></th>";
                Block += "<th><input class = '_oyear_film"+filmAr[i].id+"' maxlength='4' size='5' value = '"+filmAr[i].year+"'></td>";
                Block += "<th><input class = '_ocountry_film"+filmAr[i].id+"' maxlength='50' size='15' value = '"+filmAr[i].country+"'></td>";
                Block += "<th><input class = '_ogenre_film"+filmAr[i].id+"' maxlength='50' size='15' value = '"+filmAr[i].genre+"'></td>";
                Block += "<th><input class = '_oactors"+filmAr[i].id+"' maxlength='500' size='40' value = '"+filmAr[i].actors+"'></td>";
                Block += "<th><input class = '_orating"+filmAr[i].id+"' maxlength='2' size='5'  value = '"+filmAr[i].rating+"'></td>";
                Block += "<th><input class = '_oawards"+filmAr[i].id+"' maxlength='500' size='40' value = '"+filmAr[i].awards+"'></td>";
                Block += "<th style='text-align: center'> <button class='Update_film' data-value ='"+filmAr[i].id+"'>Изменить</button></td>";
				Block += "<th style='text-align: center'><button class = 'Delete_film' data-value ='"+filmAr[i].id+"'>Удалить</button></td>";
				Block += "<th> <p style='text-align: center'><button class='Add_rating' data-value ='"+filmAr[i].id+"'>Добавить рейтинг</button></th>";


                Block += "</tr>";
                $(".Films_Table--d").append(Block);

            }
        }
    });
}

$(document).ready(function () {

    ReadFilms();
});

$("#Submit_form").on("click", function () {
    var name = $("#name_input").val();
    var year = $("#year_input").val();
    var country = $("#country_input").val();
    var genre = $("#genre_input").val();
    var actors = $("#actors_input").val();
    var awards = $("#awards_input").val();

    var actorAr = actors.split(", ");
    var awardAr = awards.split(", ");

    $.ajax({
        type: "POST",
        dataType: "text",
        url: "php/new_film.php",
        data: {
            "Action": "Create",
            "Name": name,
            "Year": year,
            "Country": country,
            "Genre":genre,
            "Actors":actorAr,
            "Awards":awardAr
        },
        success: function (data) {
            $("#name_input").val(null);
            $("#year_input").val(null);
            $("#country_input").val(null);
            $("#genre_input").val(null);
            $("#actors_input").val(null);
            $("#awards_input").val(null);
            console.log(data);
            ReadFilms();

        }
    });
});

$("body").on("click", ".Add_rating", function()
{
    $("#SendRating").data("value",$(this).data("value"));
    $(".zatemnenie--passive").toggleClass("active");

});

$("#SendRating").on("click", function()
{
    var index = $(this).data("value");
    var name = $("#rating_name").val();
    var pas = $("#rating_pass").val();
    var rating = $("#rating_value").val();

    $.ajax({
        type:"GET",
        dataType:"text",
        url:"php/get_id.php",
        data:{
          "Action":"GetId",
          "Name":name,
          "Pas":pas
		},
        success: function(data){
            uid = JSON.parse(data);
            console.log(Uid.Id);
            $.ajax({
                type:"POST",
                dataType:"text",
                url:"php/add_rating.php",
                data: {
                    "Action":"Update",
                    "UId":uid.Id,
                    "Id":index,
                    "Rating":rating
				},
                success:function(data){
                    $(".zatemnenie").removeClass("active");
                    ReadFilms();
				}
            });
		}
    });
});

$("body").on("click",".Update_film", function(){
    var id = $(this).data("value");
    var name = $("._oname_film"+id+"").val();
    var year = $("._oyear_film"+id+"").val();
    var country = $("._ocountry_film"+id+"").val();
    var genre = $("._ogenre_film"+id+"").val();
    var actors = $("._oactors"+id+"").val();
    var awards = $("._oawards"+id+"").val();

    var actorAr = actors.split(", ");
    var awardAr = awards.split(", ");
    //запрос про актеров
    $.ajax({
        type:"GET",
        dataType:"text",
        url:"php/get_act.php",
        data:{
            "Action":"GetAct",
            "FilmId":id,
            "Actors":actorAr,
		},
        success:function(data){
            var tactorsId = JSON.parse(data); //id актеров которые остались (на случай если некоторых из них убрали при изменении, но не всех)
            var actorsId = [];
            for (var i = 0; i<tactorsId.length; i++)
            {
                actorsId.push(tactorsId[i].Id_actor);
			}
            $.ajax({
            type:"POST",
            dataType:"text",
            url:"php/update_film.php",
            data:{
                  "Action":"Update",
                  "ActorsId":actorsId,
                  "Actors":actorAr,
                  "FilmId":id
			},
            success:function(data){

			}

            });
		}
    });
    //запрос про награды
    $.ajax({
        type:"POST",
        dataType:"text",
        url:"php/update_film.php",
        data:{
            "Action":"Awards",
            "FilmId":id,
            "Awards":awardAr
		},
        success:function(data){

		}
    });
    $.ajax({
        type:"POST",
        dataType:"text",
        url:"php/update_film.php",
        data:{
            "Action":"Rest",
            "Id":id,
            "Name":name,
            "Year":year,
            "Country":country,
            "Genre":genre

        },
        success:function(data){
            console.log("Changed");
		}
    });
});

$("body").on("click",".Delete_film", function(){
    var id = $(this).data("value");
    $.ajax({
        type:"POST",
        dataType:"text",
        url:"php/delete_film.php",
        data:{
            "Action":"Delete",
            "FilmId":id
        },
        success:function(data){
            console.log(data);
            ReadFilms();
        }
    });
});