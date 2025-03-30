// handles secondary filters (dropdowns)


$(document).ready(function () {
    $(".select-filter").on("change", function () {
        let selectedValue = $(this).val();
        let filterName = $(this).attr("id");

        console.log("Filters Sent: ", filterName, selectedValue); // Debugging

        $.ajax({
            url: "../../private/filter-secondary.php",
            type: "POST",
            data: { filter: filterName, value: selectedValue },

            success: function (response) {
                $("#artwork-box").html(response);
            }
        });
    });
});

