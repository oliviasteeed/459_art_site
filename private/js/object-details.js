$(document).ready(function () {
    //make object details page white not blue/red when hovered
    $(".art-container").each(function () {
        if ($(this).hasClass("object-details-page")) {
            $(this).css({
                "background-color": "white",
                "color": "black"
            });
            $(this).find(".fave-button").removeClass("hidden");
        }
    });
});