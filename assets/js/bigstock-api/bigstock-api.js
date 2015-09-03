/*!
 * API Documentation
 * http://help.bigstockphoto.com/hc/en-us/articles/200303245-API-Documentation
 *
 * Copyright 2014 Bigstock
 * http://www.bigstockphoto.com
 */


// Bigstock Account ID
var account_id = '222306';

// Globals
var selected_category, search_term, infinite_scroll, page, jsonp_happening;


$("#bigstock-button").click(function(e) {

    // Open search modal
    $("#search-form").modal({
    	backdrop: 'static'
    });

    if ($("#categories ul li").length == 0) {

    	// Populate the categories
        $.getJSON("http://api.bigstockphoto.com/2/"+account_id+"/categories/?callback=?", function(data){
            if(data && data.data) {
                $.each(data.data, function(i, v){
    				if(v.name == "Sexual") { return; }
                    $("#categories ul").append("<li><a href='#'>"+v.name+"</a></li>");
                });
            }
        });
    }

    // When the user clicks on a category
    $("#categories").on("click", "a", function(e){

    	selected_category = $(this).text();

    	// A category has been clicked, trigger a bigstock category search
        trigger_search({ category:true });

        e.preventDefault();
    });

    // Infinite scroll
    infinite_scroll = setInterval(function(){
        var offset = $("#results li:last").offset();

        if(offset && offset.top < 1000 && !jsonp_happening && $("#results-holder").is(":visible")) {
            page++;
            $("html").trigger("bigstock_search", { q: search_term, category:selected_category, page:page })
        }
    }, 100);

});


$("#search-button").click(function(e){

	// The search button has been clicked, trigger a bigstock keyword search
	trigger_search();

	e.preventDefault();
});


function trigger_search(val){

    page = 1;
    var results = $("#results");
    results.html("")
    results.append("<li id=\"loading\"><span class=\"label\">Loading...</span></li>");
    var val = val || {};

    // Check if the user selected a category or did a keyword search
    if (val.category) {
        search_term = "";
    } else {
        selected_category = "";
        search_term = $(".search-query").val();
    }

    // Start the search
    $("html").trigger("bigstock_search", { q: search_term, category:selected_category });
    $("#categories").hide();
    $("#results-holder").show('medium');
    $("#category-link").show();
}


$("html").on("bigstock_search", function(e, val){

	if(!jsonp_happening) {

        jsonp_happening = true;
        var val = val || {};
        val.page = val.page || 1;
        var results = $("#results");

        // Setup the paramaters for the JSONP request
        var params = {};
        if(val.category != "") params.category = val.category;
        params.q = val.q;
        params.page = val.page;

        $.getJSON("http://api.bigstockphoto.com/2/"+account_id+"/search/?callback=?", params, function(data){

            results.find("#loading").remove();
            results.find("#oops").remove();

            if (data && data.data && data.data.images) {

                var template = $(".item-template");
                $.each(data.data.images, function(i, v){

                	template.find("img").attr({src: v.small_thumb.url, alt: v.title});
                    template.find("a").attr("href", "#"+v.id);
                    results.append(template.html())
                });

            } else {

            	results.append("<li id=\"oops\"><div class=\"alert alert-error\">OOOPS! We found no results. Please try another search.</div></li>");
            }

            jsonp_happening = false;
        });
    }
})


$("#results").on("click", "a", function(e){

	// Remove the hash id from the begining of the href
	var bigstock_id = $(this).attr("href").substring(1);
	var bigstock_thumb = $(this).children().attr("src");

	// When a user clicks on a thumbnail
    $.getJSON("http://api.bigstockphoto.com/2/"+account_id+"/image/"+bigstock_id+"/?callback=?", function(data) {

        if (data && data.data && data.data.image) {

        	var detail_template = $(".detail-template");
            detail_template.find("img").attr({ src: data.data.image.preview.url, alt: bigstock_id, rel: bigstock_thumb });
            detail_template.find("h4").html(data.data.image.title);

            $(".detail-template").modal({backdrop:false});
            e.preventDefault();
        }
    });
});


$(".detail-template").on("click", ".btn-primary", function(e){

	/* User clicks on Select this Image. */

	var $template = $(this).closest(".detail-template");
	var $image = $template.find("img");
	var $heading = $template.find("h4");

	// Extract the image attributes and add to the form
	var bigstock_id = $image.attr('alt');
	var bigstock_thumb = $image.attr('rel');
	var bigstock_title = $heading.text();

	// Add the selected image to the form
	add_website_image(bigstock_id, bigstock_thumb, bigstock_title);

	// Close modal
	$('.detail-template').modal('hide');

	e.preventDefault();
});


$("#category-link").click(function(e){

	// When a user clicks "browse by category"
    $("#results-holder, #category-link").hide();
    $("#categories").show('medium');
    e.preventDefault();
});


function add_website_image(bigstock_id, bigstock_thumb, bigstock_title) {

	// The table keeps the index of the next row in a data object
	var row = $('#website-images-table').data('nextrow');

	// Define the markup for the form inputs
	var id_hidden = '<input type="hidden" name="company_website_images[' + row + '][id]" value="0">';
	var bigstock_id_hidden = '<input type="hidden" name="company_website_images[' + row + '][bigstock_id]" value="' + bigstock_id + '">';
	var bigstock_thumb_hidden = '<input type="hidden" name="company_website_images[' + row + '][bigstock_thumb]" value="' + bigstock_thumb + '">';
	var bigstock_title_hidden = '<input type="hidden" name="company_website_images[' + row + '][bigstock_title]" value="' + bigstock_title + '">';

	var thumb_html = '<img src="' + bigstock_thumb + '" class="img-thumbnail">';
	var delete_button = '<button type="button" class="btn btn-link btn-xs"><span class="text-danger"><span class="glyphicon glyphicon-remove-circle"></span> Remove</span></button>';

	// Structure the markup
	var html = '';

	html += '<tr>';
	html +=   '<td class="col-sm-3 text-right">' + delete_button + id_hidden + bigstock_id_hidden + '</td>';
	html +=   '<td class="col-sm-4 text-center">' + thumb_html + bigstock_thumb_hidden + '</td>';
	html +=   '<td class="col-sm-7">' + bigstock_title + bigstock_title_hidden + '</td>';
	html += '</tr>';

	// Add the new row to the end of the table and ensure it is visible
	$('#website-images-table tbody').append(html);
	$('#website-images-table').removeClass('hidden');

	// Increment the tables data object row counter
	$('#website-images-table').data('nextrow', (row + 1));
}


$('#website-images-table tbody').on('click', 'button', function() {

	// Remove the corresponding table row
	$(this).closest('tr').remove();

	// If the last row has been removed, hide the table
	if ($('#website-images-table tbody tr').length == 0) {
		$('#website-images-table').addClass('hidden');
	}
});
