$(document).ready(function () {
    $('.card').each(function() {
        // Find all child checkboxes within the card
        var childCheckboxes = $(this).find('.permission_check_box');

        // Check if all child checkboxes are checked
        var allChecked = childCheckboxes.length === childCheckboxes.filter(':checked').length;

        // Set the state of the parent checkbox based on allChecked
        $(this).find('.check_all_permissions').prop('checked', allChecked);
    });

    $('.check_all_permissions').on('change', function(){
        // Find the parent card
        var parentCard = $(this).closest('.card');

        // Find child checkboxes within the parent card
        var childCheckboxes = parentCard.find('.permission_check_box');

        // Set the state of child checkboxes based on the parent checkbox
        childCheckboxes.prop('checked', $(this).prop('checked'));
    });

    $('.permission_check_box').on('change', function(){
        // Find the parent card
        var parentCard = $(this).closest('.card');

        // Find all child checkboxes within the parent card
        var childCheckboxes = parentCard.find('.permission_check_box');

        // Check if all child checkboxes are checked
        var allChecked = childCheckboxes.length == childCheckboxes.filter(':checked').length;

        console.log(childCheckboxes.length)
        console.log(allChecked)
        // Set the state of the parent checkbox based on allChecked
        parentCard.find('.check_all_permissions').prop('checked', allChecked);
    });

});
