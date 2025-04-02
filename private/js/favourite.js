$(document).ready(function () {
    $(".art-container").on("mouseenter", function() {
        $(this).find(".fave-button").removeClass("hidden");
    });

    $(".art-container").on("mouseleave", function() {
        $(this).find(".fave-button").addClass("hidden");
    });


    //add favourite when clicked
    $(".fave-button").on("click", function(event) {
        event.preventDefault();
        event.stopPropagation();

        //if not already a favourite, favourite it and add to db
        if(!($(this).closest(".art-container").hasClass("fave-artwork"))){
            console.log('not already a fave, adding it');

            $(this).text('unfave </3');
            $(this).closest(".art-container").addClass("fave-artwork");

            let object_id = $(this).closest(".art-container").attr("id");

            // console.log("Object ID:", object_id);
    
            //ajax call to filter based on culture
            $.ajax({
                url: '../../private/favourite.php',
                type: 'POST',
                data: { id: object_id , fave: "True"},
            })
            .done(function (res) {
                alert("Item favourited :D");
            })
            .fail(function (res) {
                console.log('error');
            });

        }else{  //if already a favourite, show unfave and remove from db
            console.log('already a fave, removing it');
            $(this).text('fave <3');

            $(this).closest(".art-container").removeClass("fave-artwork");
            let object_id = $(this).closest(".art-container").attr("id");

            //ajax call to filter based on culture
            $.ajax({
                url: '../../private/favourite.php',
                type: 'POST',
                data: { id: object_id , fave: "False"},
                success: function (response) {
                    $("#artwork-box").html(response);
                }
            })
            .done(function (res) {
                alert("Item removed from favourites :(");
            })
            .fail(function (res) {
                console.log('error', res);
            });


        }

        
    });


});
