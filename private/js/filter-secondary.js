$(document).ready(function () {
    $(".select-filter").on("change", function () {
        let selectedValue = $(this).val(); // Get selected option
        let filterName = $(this).attr("id"); // Get select ID (name of filter)

        $.ajax({
            url: "./server/filter.php", // Your PHP file handling the request
            type: "POST",
            data: { filter: filterName, value: selectedValue },
            success: function (response) {
                console.log("Filter applied:", response);
                // You can update your page dynamically here
            },
            error: function () {
                console.log("Error applying filter.");
            }
        });
    });
});
