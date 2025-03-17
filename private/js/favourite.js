$(document).ready(function () {
    $(".art-container").on("mouseenter", function() {
        $(this).find(".fave-button").removeClass("hidden");
        console.log("in it");
    });

    $(".art-container").on("mouseleave", function() {
        $(this).find(".fave-button").addClass("hidden");
        console.log("out of it");
    });

    $(".fave-button").on("click", function(event) {
        event.preventDefault();

        let object_id = $(this).closest(".artwork-box").attr("id");

        //ajax call to filter based on medium
        $.ajax({
            url: './server/favourite.php',
            type: 'POST',
            data: { id: object_id },
        })
        .done(function (res) {
            alert(res);
        })
        .fail(function (res) {
            console.log('error');
        });
    });


});
