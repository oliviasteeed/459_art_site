
$(document).ready(function () {
    $("#reset-button").on("click", function () {

        console.log("resetting all values"); // Debugging

        $.ajax({
            url: "../../private/reset-filters.php",
            type: "POST"
        });
    });
});