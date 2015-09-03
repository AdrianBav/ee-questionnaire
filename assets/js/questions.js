
// Ensure the document is ready
$(document).ready(function() {


	/* ********** Submit Questionnaire ********** */
	$('#complete-questionnaire').on('click', function() {

		if ($("#complete-questionnaire-agree").is(':checked')) {
			window.location.replace("/questions/complete");
		} else {
			// feedback!
			alert('Please read the statement and check the box to submit your answers.');
		}

	});


});
