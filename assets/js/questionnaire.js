
// Ensure the document is ready
$(document).ready(function() {


    /* ********** Table Popovers ********** */
    if ($('.table-popover').length) {

    	$('.table-popover').popover({
    		placement: 'top',
    		trigger: 'hover'
    	})

    	$('.table-popover').click(function(e) {
    		e.preventDefault();
    	});
    }


    /* ********** Table Tooltips ********** */
    if ($('.table-tooltip').length) {

    	$('.table-tooltip').tooltip();

    	$('.table-tooltip').click(function(e) {
    		e.preventDefault();
    	});
    }


});
