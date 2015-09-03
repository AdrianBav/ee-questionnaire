
// Ensure the document is ready
$(document).ready(function() {


	/* ********** Save Questionnaire ********** */
	$('#cms_questions_save, #cms_questions_submit').on('click', function() {

		// Do not submit the form if it has errors
		if ($('#cms_questions_form .has-error').length) {
			return false;
		}

		// Show the loading state
		$(this).button('loading');

		// Submit the CMS questions
		$('#cms_questions_form').submit();
	});


	/* ********** Display Company Address ********** */
	$('#display_address').change(function() {

		if($(this).is(':checked')) {
			$('#website_elements_company_address').prop('checked', true);
		} else {
			$('#website_elements_company_address').prop('checked', false);
		}
	});

	$('#website_elements_company_address').change(function() {

		if($(this).is(':checked')) {
			$('#display_address').prop('checked', true);
		} else {
			$('#display_address').prop('checked', false);
		}
	});


	/* ********** Display Company Map ********** */
	$('#display_map').change(function() {

		if($(this).is(':checked')) {
			$('#website_elements_location_map').prop('checked', true);
		} else {
			$('#website_elements_location_map').prop('checked', false);
		}
	});

	$('#website_elements_location_map').change(function() {

		if($(this).is(':checked')) {
			$('#display_map').prop('checked', true);
		} else {
			$('#display_map').prop('checked', false);
		}
	});


	/* ********** Display Company Telephone ********** */
	$('#display_telephone').change(function() {

		if($(this).is(':checked')) {
			$('#website_elements_phone_number').prop('checked', true);
		} else {
			$('#website_elements_phone_number').prop('checked', false);
		}
	});

	$('#website_elements_phone_number').change(function() {

		if($(this).is(':checked')) {
			$('#display_telephone').prop('checked', true);
		} else {
			$('#display_telephone').prop('checked', false);
		}
	});


	/* ********** Display Company Fax ********** */
	$('#display_fax').change(function() {

		if($(this).is(':checked')) {
			$('#website_elements_phone_fax').prop('checked', true);
		} else {
			$('#website_elements_phone_fax').prop('checked', false);
		}
	});

	$('#website_elements_phone_fax').change(function() {

		if($(this).is(':checked')) {
			$('#display_fax').prop('checked', true);
		} else {
			$('#display_fax').prop('checked', false);
		}
	});


	/* ********** Add Key Service ********** */
	$('#add-key-service').click(function() {

		var $service_input = $('#company_key_services_service');
		var $description_input = $('#company_key_services_description');

		var service_value = $service_input.val();
		var description_value = $description_input.val();

		// Ensure a service and a description have been given
		if (service_value == '' || description_value == '') {

			// Show empty input warning
			$('#key-services').addClass('has-warning');
			return false;
		}

		// Remove any previous warning
		$('#key-services').removeClass('has-warning');

		// The table keeps the index of the next row in a data object
		var row = $('#key-services-table').data('nextrow');

		// Define the markup for the form inputs
		var service_hidden = '<input type="hidden" name="company_key_services[' + row + '][service]" value="' + service_value + '">';
		var description_hidden = '<input type="hidden" name="company_key_services[' + row + '][description]" value="' + description_value + '">';
		var id_hidden = '<input type="hidden" name="company_key_services[' + row + '][id]" value="0">';
		var delete_button = '<button type="button" class="btn btn-link btn-xs remove"><span class="text-danger"><span class="glyphicon glyphicon-remove-circle"></span> Remove</span></button>';

		// Structure the markup
		var html = '';

		html += '<tr>';
		html +=   '<td class="col-sm-3 text-right">' + delete_button + id_hidden + '</td>';
		html +=   '<td class="col-sm-4">' + service_value + service_hidden + '</td>';
		html +=   '<td class="col-sm-5">' + description_value + description_hidden + '</td>';
		html += '</tr>';

		// Add the new row to the end of the table and ensure it is visible
		$('#key-services-table tbody').append(html);
		$('#key-services-table').removeClass('hidden');

		// Increment the tables data object row counter
		$('#key-services-table').data('nextrow', (row + 1));

		// Reset the inputs
		$service_input.val('');
		$description_input.val('');
	});


	/* ********** Remove Key Service ********** */
	$('#key-services-table tbody').on('click', 'button.remove', function() {

		// Remove the corresponding table row
		$(this).closest('tr').remove();

		// If the last row has been removed, hide the table
		if ($('#key-services-table tbody tr').length == 0) {
			$('#key-services-table').addClass('hidden');
		}
	});


	/* ********** Show Website Look Other Textbox ********** */
	$('#website_look_other').change(function() {

		if($(this).is(':checked')) {
			$('#website_look_other_text').slideDown("slow", function() {
				$(this).show();
			});
		} else {
			$('#website_look_other_text').fadeOut("slow", function() {
				$(this).hide();
			});
		}
	});


	/* ********** Show Website Elements Other Textbox ********** */
	$('#website_elements_other').change(function() {

		if($(this).is(':checked')) {
			$('#website_elements_other_text').slideDown("slow", function() {
				$(this).show();
			});
		} else {
			$('#website_elements_other_text').fadeOut("slow", function() {
				$(this).hide();
			});
		}
	});


	/* ********** Show Website Social Media Other Textbox ********** */
	$('#website_social_media_other').change(function() {

		if($(this).is(':checked')) {
			$('#website_social_media_other_text').slideDown("slow", function() {
				$(this).show();
			});
		} else {
			$('#website_social_media_other_text').fadeOut("slow", function() {
				$(this).hide();
			});
		}
	});


	/* ********** Show Your Operating System Platform Other Textbox ********** */
	$('#your_operating_system_platform_other').change(function() {

		if($(this).is(':checked')) {
			$('#your_operating_system_platform_other_text').slideDown("slow", function() {
				$(this).show();
			});
		} else {
			$('#your_operating_system_platform_other_text').fadeOut("slow", function() {
				$(this).hide();
			});
		}
	});


	/* ********** Show Your Operating System Platform Other Textbox ********** */
	$('#your_mobile_operating_system_platform_other').change(function() {

		if($(this).is(':checked')) {
			$('#your_mobile_operating_system_platform_other_text').slideDown("slow", function() {
				$(this).show();
			});
		} else {
			$('#your_mobile_operating_system_platform_other_text').fadeOut("slow", function() {
				$(this).hide();
			});
		}
	});


	/* ********** Show Your Browser IE Textbox ********** */
	$('#your_browser_internet_explorer').change(function() {

		if($(this).is(':checked')) {
			$('#your_browser_ie_text').slideDown("slow", function() {
				$(this).show();
			});
		} else {
			$('#your_browser_ie_text').fadeOut("slow", function() {
				$(this).hide();
			});
		}
	});


	/* ********** Show Your Browser Other Textbox ********** */
	$('#your_browser_other').change(function() {

		if($(this).is(':checked')) {
			$('#your_browser_other_text').slideDown("slow", function() {
				$(this).show();
			});
		} else {
			$('#your_browser_other_text').fadeOut("slow", function() {
				$(this).hide();
			});
		}
	});


	/* ********** Sortable Website Functions ********** */
	if ($('#website-function-items').length) {

		$('#website-function-items').sortable({
			placeholder: "ui-state-highlight"
		});

		$('#website-function-items').disableSelection();

		$('#website-function-items').on('sortstop', function(event, ui) {

			// Get the order of the items and update the hidden input
			var sortOrder = $(this).sortable('toArray');
			$('#website_function').val(sortOrder);
		});

		// Initialize the hidden input
		var sortOrder = $('#website-function-items').sortable('toArray');
		$('#website_function').val(sortOrder);
	}


	/* ********** Current Website URL ********** */
	$('#current_website_url').blur(function() {

		if ($('#current_website_url').val() == '') {

			$('#current_website_likes_holder').fadeOut("slow", function() {
				$(this).hide();
			});

			$('#current_website_dislikes_holder').fadeOut("slow", function() {
				$(this).hide();
			});

		} else {

			$('#current_website_likes_holder').slideDown("slow", function() {
				$(this).show();
			});

			$('#current_website_dislikes_holder').slideDown("slow", function() {
				$(this).show();
			});
		}
	});


	/* ********** Add Reference Website ********** */
	$('#add-reference-website').click(function() {

		var $title_input = $('#company_reference_websites_title');
		var $url_input = $('#company_reference_websites_url');
		var $competitor_input = $('#company_reference_websites_competitor');
		var $comments_input = $('#company_reference_websites_comments');

		var title_value = $title_input.val();
		var url_value = $url_input.val();
		var competitor_value = $competitor_input.is(':checked');
		var comments_value = $comments_input.val();

		// Ensure a title and a url have been given
		if (title_value == '' || url_value == '') {

			// Show empty input warning
			$('#reference_websites').addClass('has-warning');
			return false;
		}

		// Remove any previous warning
		$('#reference_websites').removeClass('has-warning');

		var website_html = '<a href="#" class="table-tooltip" data-toggle="tooltip" title="' + url_value + '">' + title_value + '</a>';
		var view_site_html = '<a href="' + url_value + '" target="_blank" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-globe"></span> Launch</a>';
		var competitor_html = (competitor_value) ? '<span class="glyphicon glyphicon-ok"></span>' : '<span class="glyphicon glyphicon-remove"></span>';

		if (comments_value.length > 50) {

			var comments_trimmed = comments_value.substring(0, 49) + "...";
			var comments_html = '<button type="button" class="btn btn-link table-popover" data-toggle="popover" data-content="' + comments_value + '">' + comments_trimmed + '</button>';

		} else {

			var comments_html = comments_value;
		}

		// Ensure a title and url have been given
		if (title_value == '' || url_value == '') {

			// Show empty input warning
			$('#reference-websites').addClass('has-warning');
			return false;
		}

		// Remove any previous warning
		$('#reference-websites').removeClass('has-warning');

		// The table keeps the index of the next row in a data object
		var row = $('#reference-websites-table').data('nextrow');

		// Define the markup for the form inputs
		var title_hidden = '<input type="hidden" name="company_reference_websites[' + row + '][title]" value="' + title_value + '">';
		var url_hidden = '<input type="hidden" name="company_reference_websites[' + row + '][url]" value="' + url_value + '">';
		var competitor_hidden = '<input type="hidden" name="company_reference_websites[' + row + '][competitor]" value="' + competitor_value + '">';
		var comments_hidden = '<input type="hidden" name="company_reference_websites[' + row + '][comments]" value="' + comments_value + '">';
		var id_hidden = '<input type="hidden" name="company_reference_websites[' + row + '][id]" value="0">';
		var delete_button = '<button type="button" class="btn btn-link btn-xs remove"><span class="text-danger"><span class="glyphicon glyphicon-remove-circle"></span> Remove</span></button>';

		// Structure the markup
		var html = '';

		html += '<tr>';
		html +=   '<td class="col-sm-3 text-right">' + delete_button + id_hidden + '</td>';
		html +=   '<td class="col-sm-2">' + website_html + title_hidden + '</td>';
		html +=   '<td class="col-sm-2">' + view_site_html + url_hidden + '</td>';
		html +=   '<td class="col-sm-2">' + competitor_html + competitor_hidden + '</td>';
		html +=   '<td class="col-sm-3">' + comments_html + comments_hidden + '</td>';
		html += '</tr>';

		// Add the new row to the end of the table and ensure it is visible
		$('#reference-websites-table tbody').append(html);
		$('#reference-websites-table').removeClass('hidden');

		// Increment the tables data object row counter
		$('#reference-websites-table').data('nextrow', (row + 1));

		// Re-initalise the tooltips and popovers
		$('.table-tooltip').tooltip();
    	$('.table-popover').popover({
    		placement: 'top',
    		trigger: 'hover'
    	})
    	$('.table-popover').click(function(e) {
    		e.preventDefault();
    	});

		// Reset the inputs
		$title_input.val('');
		$url_input.val('');
		$competitor_input.removeAttr('checked');
		$comments_input.val('');
	});


	/* ********** Remove Website Reference ********** */
	$('#reference-websites-table tbody').on('click', 'button.remove', function() {

		// Remove the corresponding table row
		$(this).closest('tr').remove();

		// If the last row has been removed, hide the table
		if ($('#reference-websites-table tbody tr').length == 0) {
			$('#reference-websites-table').addClass('hidden');
		}
	});


	/* ********** Remove Project Assets ********** */
	$('#project-assets-table tbody').on('click', 'button.remove', function() {

		// get details
		var id = $(this).data('project-asset-id');

		// Request the row to be removed from the database.
		$.ajax({
			type: 'POST',
			url: '/project_asset/remove',
			data: { id: id },
			context: this

		}).done(function(data) {

			// Remove the corresponding table row
			$(this).closest('tr').remove();

			// If the last row has been removed, hide the table
			if ($('#project-assets-table tbody tr').length == 0) {
				$('#project-assets-table').addClass('hidden');
			}

		}).fail(function(data) {

			// Display any errors
			alert('Error: ' + data.statusText);
		});
	});


    /* ********** Project Assets Popovers ********** */
    if ($('.table-popover').length) {

    	$('.table-popover').popover({
    		placement: 'top',
    		trigger: 'hover'
    	})
    }


});
