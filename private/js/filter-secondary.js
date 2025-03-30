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




// $(document).ready(function () {
//     // When any filter is changed
//     $('.select-filter').change(function () {
//         var formData = {};

//         // Get all selected filter values
//         $('.filter-select').each(function () {
//             var key = $(this).attr('name'); // Get the filter name
//             var value = $(this).val(); // Get the selected value
//             if (value !== "*" && value !== "") { // Ignore empty filters
//                 formData[key] = value;
//             }
//         });

//         console.log("Filters Sent: ", formData); // Debugging

//         // Send AJAX request to get filtered artworks
//         $.ajax({
//             url: 'get-artworks.php', // PHP file that returns filtered artworks
//             type: 'POST',
//             data: formData,
//             success: function (response) {
//                 $('.artwork-box').html(response); // Replace content with new artworks
//             },
//             error: function () {
//                 alert('Error loading artworks.');
//             }
//         });
//     });
// });


// $(document).ready(function () {

//     $(".tag-button").on("click", function(event) {
//         event.preventDefault();

//         let selectedTagsContainer = $("#selected-tags");
//         let value = $(this).attr("data-value");

//         if(this.classList.contains("selected")) {
//             this.classList.remove("selected");
//             selectedTagsContainer.find(`input[value='${value}']`).remove();
//         }
//         else {
//             this.classList.add("selected");
//             selectedTagsContainer.append(`<input type='hidden' name='medium[]' value='${value}'>`);
//         }
//     });


// });



// $(document).ready(function () {
    
//     $(".select-filter").on("change", function () {
//         event.preventDefault();

//         let selectedValue = $(this).val(); // get selected option
//         let filterName = $(this).attr("id"); //get name of filter

//         console.log("Selected filter:", filterName);
//         console.log("Selected value:", selectedValue);  

//         $.ajax({
//             url: "../../private/filter-secondary.php", 
//             type: "POST",
//             data: { filter: filterName, value: selectedValue },
//             success: function (response) {
//                 console.log("Filter applied:", response);

//                 // apply secondary filters to current artworks on page
//                 updateArtworks();
//             },
//             error: function () {
//                 console.log("Error applying filter.");
//             }
//         });
//     });

//     // function to update artworks on the page based on selected filters with php
//     function updateArtworks() {
//         $.ajax({
//             url: "../../private/get-artworks.php",
//             type: "GET",
//             success: function (data) {
//                 $(".artwork-box").html(data); // update artworks displaying
//             },
//             error: function () {
//                 console.log("Error fetching artworks.");
//             }
//         });
//     }
// });
