$(document).ready(function () {
    $(".art-container").on("mouseenter", function() {
        $(this).find(".fave-button").removeClass("hidden");
        console.log("in it");
    });

    $(".art-container").on("mouseleave", function() {
        $(this).find(".fave-button").addClass("hidden");
        console.log("out of it");
    });

    // go to details page when clicked
    // $(".art-container").on("click", function() {

    //     let object_id = $(this).attr("id");
    //     window.location.href = "details.php?id=" + object_id;

    //     $(this).find(".fave-button").addClass("hidden");
    // });

    $(".fave-button").on("click", function(event) {
        event.preventDefault();
        event.stopPropagation();

        //if not already a favourite, favourite it and add to db
        if(!($(this).closest(".art-container").hasClass("fave-artwork"))){
            // console.log('not already a fave, adding it');
            $(this).text('unfave </3');
            $(this).closest(".art-container").addClass("fave-artwork");

            let object_id = $(this).closest(".art-container").attr("id");

            // console.log("Object ID:", object_id);
    
            //ajax call to filter based on medium
            $.ajax({
                url: '../../private/favourite.php',
                type: 'POST',
                data: { id: object_id , fave:true},
            })
            .done(function (res) {
                alert(res);
            })
            .fail(function (res) {
                console.log('error');
            });
            //TODO: unfave function

        }else{  //if already a favourite, show unfave and remove from db
            console.log('already a fave, removing it');
            $(this).text('fave <3');

            $(this).closest(".art-container").removeClass("fave-artwork");
            let object_id = $(this).closest(".art-container").attr("id");

            //ajax call to filter based on medium
            $.ajax({
                url: '../../private/favourite.php',
                type: 'POST',
                data: { id: object_id , fave: false},
            })
            .done(function (res) {
                alert(res);
            })
            .fail(function (res) {
                console.log('error');
            });


        }

        
    });


});
