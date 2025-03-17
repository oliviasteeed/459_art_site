
$(document).ready(function () {

    $(".tag-button").on("click", function(event) {
        event.preventDefault();

        let selectedTagsContainer = $("#selected-tags");
        let value = $(this).attr("data-value");

        if(this.classList.contains("selected")) {
            this.classList.remove("selected");
            selectedTagsContainer.find(`input[value='${value}']`).remove();
        }
        else {
            this.classList.add("selected");
            selectedTagsContainer.append(`<input type='hidden' name='medium[]' value='${value}'>`);
        }
    });


});




