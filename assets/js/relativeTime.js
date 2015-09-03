$(document).ready(function() {

	$.getJSON('/dashboard/server_date', function(data) {

		/* Define server object. */
		var SERVER = {
			offset: moment(data.server_date).diff(moment()),
			adjust: function(timestamp, format) {
				if (timestamp == '') { return '' };
				return moment(timestamp, format)
					.subtract('milliseconds', this.offset)
					.fromNow();
			}
		};


		/* ********** Dashboard ********** */

		/* ********** Dashboard Recently Returned Table ********** */
		if ($('#recently-returned-table').length) {

			// Target the returned date column
			$('#recently-returned-table tbody td:last-child').each(function() {

				$(this).text(SERVER.adjust($(this).text(), "YYYY-MM-DD HH:mm:ss"));
			});
		}


		/* ********** Dashboard Recently Viewed Table ********** */
		if ($('#recently-viewed-table').length) {

			// Target the viewed date column
			$('#recently-viewed-table tbody td:last-child').each(function() {

				$(this).text(SERVER.adjust($(this).text(), "YYYY-MM-DD HH:mm:ss"));
			});
		}


	    /* ********** Dashboard Questionnaires Table ********** */
	    if ($('#questionnaires-table').length) {

	    	// Target the issued date column
	    	$('#questionnaires-table tbody td:nth-child(3)').each(function() {

	    		$(this)
	    			.text(SERVER.adjust($(this).text(), "YYYY-MM-DD HH:mm:ss"))
	    			.addClass('adjusted');
	    	});

	    	// Target the returned date column
	    	$('#questionnaires-table tbody td:last-child').each(function() {

	    		$(this)
	    			.text(SERVER.adjust($(this).text(), "YYYY-MM-DD HH:mm:ss"))
	    			.addClass('adjusted');
	    	});

	    	// When the table is sorted, adjust any timestamps that wern't previously visable
	    	$('#questionnaires-table').on('draw.dt', function() {

		    	// Target the issued date column
		    	$('#questionnaires-table tbody td:nth-child(3)').each(function() {

		    		if ($(this).hasClass('adjusted') == false) {

		    			$(this)
		    				.text(SERVER.adjust($(this).text(), "YYYY-MM-DD HH:mm:ss"))
		    				.addClass('adjusted');
		    		}
		    	});

		    	// Target the returned date column
		    	$('#questionnaires-table tbody td:last-child').each(function() {

		    		if ($(this).hasClass('adjusted') == false) {

			    		$(this)
			    			.text(SERVER.adjust($(this).text(), "YYYY-MM-DD HH:mm:ss"))
			    			.addClass('adjusted');
		    		}
		    	});
	    	});
	    }


	    /* ********** Questionnaire Page ********** */
	    var $issuedDate = $('#questionnaire-page .issued-date');
	    if ($issuedDate.length) {
	    	$issuedDate.text(SERVER.adjust($issuedDate.text(), "YYYY-MM-DD HH:mm:ss"));
	    }

	    var $returnedDate = $('#questionnaire-page .returned-date');
	    if ($returnedDate.length) {
	    	$returnedDate.text(SERVER.adjust($returnedDate.text(), "YYYY-MM-DD HH:mm:ss"));
	    }

	    var $downloadedDate = $('#questionnaire-page .downloaded-date');
	    if ($downloadedDate.length) {
	    	$downloadedDate.text(SERVER.adjust($downloadedDate.text(), "YYYY-MM-DD HH:mm:ss"));
	    }

	    var $remindersTable = $('#reminders-table');
	    if ($remindersTable.length) {

	    	$remindersTable.find('tbody td:first-child').each(function() {
	    		$(this).text(SERVER.adjust($(this).text(), "YYYY-MM-DD HH:mm:ss"));
	    	});
	    }

	    var $lastActivity = $('#questionnaire-page .last-activity');
	    if ($lastActivity.length) {
	    	if ($lastActivity.text()) {
	    		$lastActivity.text(SERVER.adjust($lastActivity.text(), "YYYY-MM-DD HH:mm:ss"));
	    	} else {
	    		$lastActivity.text('None');
	    	}
	    }

	    var $remindersTable = $('#project-assets-table');
	    if ($remindersTable.length) {

	    	var $linkContent;

	    	$remindersTable.find('tbody td:nth-child(3)').each(function() {
	    		$linkContent = $(this).children('a');
	    		$linkContent.text(SERVER.adjust($linkContent.text(), "YYYY-MM-DD HH:mm:ss"));
	    	});
	    }

	});

});