// resetting secondary filters button

$(document).ready(function () {
    $("#reset-button").on("click", function () {
        console.log("Resetting all values..."); // Debugging

        $.ajax({
            url: "../../private/reset-filters.php",
            type: "POST",
            success: function () {
                console.log("Filters reset successfully");

                // Call another PHP file after reset
                $.ajax({
                    url: "../../private/filter-secondary.php", // Change this to your file
                    type: "POST",
                    success: function () {
                        window.location.href = "../../public/pages/browse.php"; // Redirect to browse.php
                    },
                    error: function (xhr, status, error) {
                        console.error("Error in second AJAX call:", error);
                    }
                });
            },
            error: function (xhr, status, error) {
                console.error("Error resetting filters:", error);
            }
        });
    });
});

