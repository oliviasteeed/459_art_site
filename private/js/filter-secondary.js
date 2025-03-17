// handles secondary filters (dropdowns)

$(document).ready(function () {
    
    $(".select-filter").on("change", function () {
        let selectedValue = $(this).val(); // get selected option
        let filterName = $(this).attr("id"); //get name of filter

        $.ajax({
            url: "../../private/filter-secondary.php", // Your PHP file handling the request
            type: "POST",
            data: { filter: filterName, value: selectedValue },
            success: function (response) {
                console.log("Filter applied:", response);
            },
            error: function () {
                console.log("Error applying filter.");
            }
        });
    });
});
