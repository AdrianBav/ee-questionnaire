<div class="container">

    <div class="page-header">
		<h1>Website Design Questionnaire</h1>
    </div>

    <div class="row">
    	<div class="col-xs-3">

	    	<!-- Question Sidebar -->
			<section id="side-bar" data-spy="affix" data-offset-top="30">

	    		<nav id="side-nav">
					<ul class="nav nav-pills nav-stacked">
					  <li class="active"><a href="#section-1"><span class="glyphicon glyphicon-chevron-right"></span> Company Basics</a></li>
					  <li><a href="#section-2"><span class="glyphicon glyphicon-chevron-right"></span> About Your Company</a></li>
					  <li><a href="#section-3"><span class="glyphicon glyphicon-chevron-right"></span> Look and Feel</a></li>
					  <li><a href="#section-4"><span class="glyphicon glyphicon-chevron-right"></span> Inspiration</a></li>
					  <li><a href="#section-5"><span class="glyphicon glyphicon-chevron-right"></span> Website Structure</a></li>
					  <li><a href="#section-6"><span class="glyphicon glyphicon-chevron-right"></span> Miscellanious</a></li>
					</ul>
				</nav>

				<div class="form-group mt3">
					<p>
						<abbr title='Required field'>*</abbr> <?php echo form_label('Required field', array('class' => 'control-label')); ?>
						<span class="help-block">You must provide this information.</span>
					</p>
					<p>
						<abbr title='Recommended field' class='recommended'>*</abbr> <?php echo form_label('Recommended field', array('class' => 'control-label')); ?>
						<span class="help-block">We would like you to provide this information.</span>
					</p>
				</div>

				<div class="control mt3">
					<button type="button" id="cms_questions_save" data-loading-text="Saving..." class="btn btn-success btn-lg" autocomplete="off"><span class="glyphicon glyphicon-floppy-save"></span> Save Progress</button>
					<span class="help-block">You can save your progress at any time.</span>
				</div>

			</section>

    	</div>
        <div class="col-xs-8 col-md-offset-1">

			<!-- Questions -->
			<?php echo validation_errors(); ?>

			<?php echo form_open('/questions/cms', array('id' => 'cms_questions_form', 'class' => 'form-horizontal mb4', 'role' => 'form', 'data-toggle' => 'validator')); ?>

				<!-- Section 1 -->
				<h2 id="section-1">Company Basics</h2>

                <div class="form-group">
                    <?php echo questionnaire_form_label($cms_rules[0], array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-9">
                    	<?php echo questionnaire_form_input('text', $cms_rules[0], $cms->company_name, array('class' => 'form-control')); ?>
                    	<?php echo questionnaire_help_block($cms_rules[0]); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo questionnaire_form_label($cms_rules[1], array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-9">
                    	<?php echo questionnaire_form_input('text', $cms_rules[1], $cms->company_legal_name, array('class' => 'form-control')); ?>
                    	<?php echo questionnaire_help_block($cms_rules[1]); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo questionnaire_form_label($cms_rules[2], array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-9">
                    	<?php echo questionnaire_form_input('text', $cms_rules[2], $cms->company_slogan, array('class' => 'form-control')); ?>
                    	<?php echo questionnaire_help_block($cms_rules[2]); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo questionnaire_form_label($cms_rules[3], array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-9">
                    	<?php echo questionnaire_form_textarea($cms_rules[3], $cms->company_address, array('class' => 'form-control', 'rows' => 3)); ?>
                    	<?php echo questionnaire_help_block($cms_rules[3]); ?>

						<div class="checkbox">
							<label class="checkbox-inline">
						  		<?php echo form_checkbox(array('name' => 'company_address_options', 'id' => 'display_address', 'checked' => in_array('company_address', $cms->website_elements), 'value' => 1)); ?> Display Address on Website
						 	</label>
							<label class="checkbox-inline">
						  		<?php echo form_checkbox(array('name' => 'company_address_options', 'id' => 'display_map', 'checked' => in_array('location_map', $cms->website_elements), 'value' => 1)); ?> Display Map on Website
						 	</label>
					 	</div>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo questionnaire_form_label($cms_rules[4], array('class' => 'col-sm-3 control-label', 'recommended' => 'recommended')); ?>
                    <div class="col-sm-9">
                    	<?php echo questionnaire_form_input('tel', $cms_rules[4], $cms->company_telephone, array('class' => 'form-control')); ?>
                    	<?php echo questionnaire_help_block($cms_rules[4]); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo questionnaire_form_label($cms_rules[5], array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-9">
                    	<?php echo questionnaire_form_input('tel', $cms_rules[5], $cms->company_fax, array('class' => 'form-control')); ?>
                    	<?php echo questionnaire_help_block($cms_rules[5]); ?>

                    	<div class="checkbox">
							<label class="checkbox-inline">
						  		<?php echo form_checkbox(array('name' => 'company_telephone_options', 'id' => 'display_telephone', 'checked' => in_array('phone_number', $cms->website_elements), 'value' => 1)); ?> Display Telephone Number on Website
						 	</label>
							<label class="checkbox-inline">
						  		<?php echo form_checkbox(array('name' => 'company_fax_options', 'id' => 'display_fax', 'checked' => in_array('fax_number', $cms->website_elements), 'value' => 1)); ?> Display Fax Number on Website
						 	</label>
					 	</div>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo questionnaire_form_label($cms_rules[6], array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-9">
                    	<?php echo questionnaire_form_input('email', $cms_rules[6], $cms->company_email, array('class' => 'form-control')); ?>
	                    <?php echo questionnaire_help_block($cms_rules[6]); ?>
                    </div>
                </div>

				<!-- Section 2 -->
                <h2 id="section-2" class="mt5">About Your Company</h2>

                <div class="form-group">
                    <?php echo questionnaire_form_label($cms_rules[7], array('class' => 'col-sm-3 control-label', 'recommended' => 'recommended')); ?>
                    <div class="col-sm-9">
                    	<?php echo questionnaire_form_textarea($cms_rules[7], $cms->company_function, array('class' => 'form-control', 'rows' => 4)); ?>
                    	<?php echo questionnaire_help_block($cms_rules[7]); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo questionnaire_form_label($cms_rules[8], array('class' => 'col-sm-3 control-label', 'recommended' => 'recommended')); ?>
                    <div class="col-sm-9">
                    	<?php echo questionnaire_form_textarea($cms_rules[8], $cms->company_unique, array('class' => 'form-control', 'rows' => 4)); ?>
                    	<?php echo questionnaire_help_block($cms_rules[8]); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo questionnaire_form_label($cms_rules[9], array('class' => 'col-sm-3 control-label', 'recommended' => 'recommended')); ?>
                    <div class="col-sm-9">
                    	<?php echo questionnaire_form_textarea($cms_rules[9], $cms->company_clients, array('class' => 'form-control', 'rows' => 4)); ?>
                    	<?php echo questionnaire_help_block($cms_rules[9]); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo questionnaire_form_label($cms_rules[10], array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-9">
                    	<?php echo questionnaire_form_textarea($cms_rules[10], $cms->company_target_audience, array('class' => 'form-control', 'rows' => 4)); ?>
                    	<?php echo questionnaire_help_block($cms_rules[10]); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo questionnaire_form_label($cms_rules[11], array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-9">
                    	<?php echo questionnaire_form_textarea($cms_rules[11], $cms->company_competitive_edge, array('class' => 'form-control', 'rows' => 4)); ?>
                    	<?php echo questionnaire_help_block($cms_rules[11]); ?>
                    </div>
                </div>

                <div class="form-group" id="key-services">
                    <?php echo questionnaire_form_label($key_services_rules[0], array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-9">
	                    <div class="row">

							<div class="col-sm-5">
								<?php echo questionnaire_form_label($key_services_rules[2], array('class' => 'control-label')); ?>
								<?php echo form_input(array('name' => 'company_key_services_service', 'id' => 'company_key_services_service', 'class' => 'form-control')); ?>
								<?php echo form_hidden('company_key_services_id', 0); ?>
								<button type="button" id="add-key-service" class="btn btn-link"><span class="text-success"><span class="glyphicon glyphicon-ok-circle"></span> Add Key Service</span></button>
							</div>
	                    	<div class="col-sm-7">
	                    		<?php echo questionnaire_form_label($key_services_rules[3], array('class' => 'control-label')); ?>
								<?php echo form_textarea(array('name' => 'company_key_services_description', 'id' => 'company_key_services_description', 'class' => 'form-control', 'rows' => 4)); ?>
							</div>

	                    </div>
                    </div>
                </div>

                <section>
                    <div class="row">

						<table class="table table-condensed table-striped <?php echo ( ! $key_services) ? 'hidden' : ''; ?>" id="key-services-table" data-nextrow="<?php echo count($key_services); ?>">
                    		<thead>
                    			<tr><th></th><th>Product / Service</th><th>Description</th></tr>
                    		</thead>
                    		<tbody>
                    		<?php if($key_services): ?>
								<?php foreach($key_services as $row => $key_service): ?>
		                    		<tr>
										<td class="col-sm-3 text-right">
											<button type="button" class="btn btn-link btn-xs remove"><span class="text-danger"><span class="glyphicon glyphicon-remove-circle"></span> Remove</span></button>
											<?php echo form_hidden(sprintf($key_services_rules[1]['field'], $row), $key_service->key_services_id); ?>
										</td>
										<td class="col-sm-4">
											<?php echo $key_service->service; ?>
											<?php echo form_hidden(sprintf($key_services_rules[2]['field'], $row), $key_service->service); ?>
										</td>
				                    	<td class="col-sm-5">
				                    		<?php echo $key_service->description; ?>
											<?php echo form_hidden(sprintf($key_services_rules[3]['field'], $row), $key_service->description); ?>
										</td>
									</tr>
		                    	<?php endforeach; ?>
	                    	<?php endif; ?>
	                    	</tbody>
	                    </table>

                    </div>
                </section>

				<!-- Section 3 -->
                <h2 id="section-3" class="mt5">Look and Feel</h2>

                <div class="form-group">
                    <?php echo questionnaire_form_label($cms_rules[12], array('class' => 'col-sm-3 control-label', 'recommended' => 'recommended')); ?>
                    <div class="col-sm-9">

                    	<div class="row">
						<?php foreach($website_look_options as $chkbox_value => $label_text): ?>
							<div class="col-sm-4">

								<div class="checkbox">
								  <label class="control-label">
								  	<?php echo questionnaire_form_checkbox($cms_rules[12], $chkbox_value, $cms->website_look, array('id' => "website_look_{$chkbox_value}")); ?>
								  	<?php echo $label_text; ?>
								  </label>
								</div>

							</div>
						<?php endforeach; ?>
						</div>

						<div class="row">
							<div class="col-sm-12">

								<section class="mt1 <?php echo ( ! $cms->website_look_other) ? 'initially-hidden' : ''; ?>" id="website_look_other_text">
									<div class="input-group">
	      								<span class="input-group-addon"><span class="glyphicon glyphicon-edit"></span> <?php echo $cms_rules[13]['label']; ?></span>
	      								<?php echo questionnaire_form_input('text', $cms_rules[13], $cms->website_look_other, array('class' => 'form-control')); ?>
	    							</div>
    							</section>

							</div>
						</div>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo questionnaire_form_label($cms_rules[14], array('class' => 'col-sm-3 control-label')); ?>
                    <?php echo questionnaire_form_hidden($cms_rules[14], ''); ?>
                    <div class="col-sm-9">
                    	<ul class="list-group" id="website-function-items">
                    	<?php foreach($cms->website_function as $website_function): ?>
						  <li id="<?php echo $website_function['id']; ?>" class="list-group-item">
						  	<span class="ui-icon ui-icon-arrowthick-2-n-s"></span><?php echo $website_function['name']; ?>
						  </li>
						<?php endforeach; ?>
						</ul>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo questionnaire_form_label($cms_rules[15], array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-9">
                    	<?php echo questionnaire_form_textarea($cms_rules[15], $cms->website_colors, array('class' => 'form-control', 'rows' => 4)); ?>
                    	<?php echo questionnaire_help_block($cms_rules[15]); ?>
                    </div>
                </div>

				<div class="form-group">
                    <?php echo questionnaire_form_label($cms_rules[16], array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-9">
                    	<?php echo questionnaire_form_textarea($cms_rules[16], $cms->website_homepage, array('class' => 'form-control', 'rows' => 4)); ?>
                    	<?php echo questionnaire_help_block($cms_rules[16]); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo questionnaire_form_label($cms_rules[17], array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-9">
                    	<?php echo questionnaire_form_textarea($cms_rules[17], $cms->website_navigation, array('class' => 'form-control', 'rows' => 4)); ?>
                    	<?php echo questionnaire_help_block($cms_rules[17]); ?>
                    </div>
                </div>

				<!-- Section 4 -->
                <h2 id="section-4" class="mt5">Inspiration</h2>

                <div class="form-group">
                    <?php echo questionnaire_form_label($cms_rules[18], array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-9">
                    	<?php echo questionnaire_form_input('text', $cms_rules[18], $cms->current_website_url, array('class' => 'form-control')); ?>
                    	<?php echo questionnaire_help_block($cms_rules[18]); ?>
                    </div>
                </div>

                <div class="form-group <?php echo ($cms->current_website_url) ? '' : 'initially-hidden'; ?>" id="current_website_likes_holder">
                    <?php echo questionnaire_form_label($cms_rules[19], array('class' => 'col-sm-3 control-label', 'recommended' => 'recommended')); ?>
                    <div class="col-sm-9">
                    	<?php echo questionnaire_form_textarea($cms_rules[19], $cms->current_website_likes, array('class' => 'form-control', 'rows' => 3)); ?>
                    	<?php echo questionnaire_help_block($cms_rules[19]); ?>
                    </div>
                </div>

				<div class="form-group <?php echo ($cms->current_website_url) ? '' : 'initially-hidden'; ?>" id="current_website_dislikes_holder">
                    <?php echo questionnaire_form_label($cms_rules[20], array('class' => 'col-sm-3 control-label', 'recommended' => 'recommended')); ?>
                    <div class="col-sm-9">
                    	<?php echo questionnaire_form_textarea($cms_rules[20], $cms->current_website_dislikes, array('class' => 'form-control', 'rows' => 3)); ?>
                    	<?php echo questionnaire_help_block($cms_rules[20]); ?>
                    </div>
                </div>

                <div class="form-group" id="reference_websites">
                    <?php echo questionnaire_form_label($reference_websites_rules[0], array('class' => 'col-sm-3 control-label', 'recommended' => 'recommended')); ?>
                    <div class="col-sm-9">

	                    <div class="row">
							<div class="col-sm-12">
	                    		<?php echo questionnaire_form_label($reference_websites_rules[3], array('class' => 'control-label')); ?>
								<?php echo form_input(array('name' => 'company_reference_websites_url', 'id' => 'company_reference_websites_url', 'class' => 'form-control')); ?>
							</div>
	                    </div>

	                    <div class="row">
	                    	<div class="col-sm-5">
								<?php echo questionnaire_form_label($reference_websites_rules[2], array('class' => 'control-label')); ?>
								<?php echo form_input(array('name' => 'company_reference_websites_title', 'id' => 'company_reference_websites_title', 'class' => 'form-control')); ?>
	                    		<label class="control-label">
									<?php echo questionnaire_form_checkbox($reference_websites_rules[4], '1', array(), array('id' => 'company_reference_websites_competitor')); ?>
									<?php echo $reference_websites_rules[4]['label']; ?>
								</label>
								<?php echo form_hidden('company_reference_websites_id', 0); ?>
								<button type="button" id="add-reference-website" class="btn btn-link"><span class="text-success"><span class="glyphicon glyphicon-ok-circle"></span> Add Reference Website</span></button>
							</div>
	                    	<div class="col-sm-7">
	                    		<?php echo questionnaire_form_label($reference_websites_rules[5], array('class' => 'control-label')); ?>
								<?php echo form_textarea(array('name' => 'company_reference_websites_comments', 'id' => 'company_reference_websites_comments', 'class' => 'form-control', 'rows' => 4)); ?>
							</div>
	                    </div>

                    </div>
                </div>

                <section>
                    <div class="row">

						<table class="table table-condensed table-striped <?php echo ( ! $reference_websites) ? 'hidden' : ''; ?>" id="reference-websites-table" data-nextrow="<?php echo count($reference_websites); ?>">
                    		<thead>
                    			<tr><th></th><th>Website</th><th>View Site</th><th>Competitor</th><th>Comments</th></tr>
                    		</thead>
                    		<tbody>
                    		<?php if($reference_websites): ?>
								<?php foreach($reference_websites as $row => $reference_website): ?>
		                    		<tr>
										<td class="col-sm-3 text-right">
											<button type="button" class="btn btn-link btn-xs remove"><span class="text-danger"><span class="glyphicon glyphicon-remove-circle"></span> Remove</span></button>
											<?php echo form_hidden(sprintf($reference_websites_rules[1]['field'], $row), $reference_website->reference_websites_id); ?>
										</td>
										<td class="col-sm-2">
											<?php echo $reference_website->website_html; ?>
											<?php echo form_hidden(sprintf($reference_websites_rules[2]['field'], $row), $reference_website->title); ?>
										</td>
				                    	<td class="col-sm-2">
				                    		<?php echo $reference_website->view_site_html; ?>
											<?php echo form_hidden(sprintf($reference_websites_rules[3]['field'], $row), $reference_website->url); ?>
										</td>
				                    	<td class="col-sm-2">
				                    		<?php echo $reference_website->competitor_html; ?>
											<?php echo form_hidden(sprintf($reference_websites_rules[4]['field'], $row), $reference_website->competitor); ?>
										</td>
				                    	<td class="col-sm-3">
				                    		<?php echo $reference_website->comments_html; ?>
											<?php echo form_hidden(sprintf($reference_websites_rules[5]['field'], $row), $reference_website->comments); ?>
										</td>
									</tr>
		                    	<?php endforeach; ?>
	                    	<?php endif; ?>
	                    	</tbody>
	                    </table>

                    </div>
                </section>

				<!-- Section 5 -->
                <h2 id="section-5" class="mt5">Website Structure</h2>

                <div class="form-group">
                    <?php echo questionnaire_form_label($cms_rules[21], array('class' => 'col-sm-3 control-label', 'recommended' => 'recommended')); ?>
                    <div class="col-sm-9">

                    	<div class="row">
						<?php foreach($website_elements as $chkbox_value => $label_text): ?>
							<div class="col-sm-4">

								<div class="checkbox">
								  <label class="control-label">
								  	<?php echo questionnaire_form_checkbox($cms_rules[21], $chkbox_value, $cms->website_elements, array('id' => "website_elements_{$chkbox_value}")); ?>
								  	<?php echo $label_text; ?>
								  </label>
								</div>

							</div>
						<?php endforeach; ?>
						</div>

						<div class="row">
							<div class="col-sm-12">

								<section class="mt1 <?php echo ( ! $cms->website_elements_other) ? 'initially-hidden' : ''; ?>" id="website_elements_other_text">
									<div class="input-group">
	      								<span class="input-group-addon"><span class="glyphicon glyphicon-edit"></span> <?php echo $cms_rules[22]['label']; ?></span>
	      								<?php echo questionnaire_form_input('text', $cms_rules[22], $cms->website_elements_other, array('class' => 'form-control')); ?>
	    							</div>
    							</section>

							</div>
						</div>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo questionnaire_form_label($cms_rules[23], array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-9">

                    	<div class="row">
						<?php foreach($website_social_media as $chkbox_value => $label_text): ?>
							<div class="col-sm-4">
								<div class="checkbox">
								  <label class="control-label">
								  	<?php echo questionnaire_form_checkbox($cms_rules[23], $chkbox_value, $cms->website_social_media, array('id' => "website_social_media_{$chkbox_value}")); ?>
								  	<?php if($chkbox_value != 'other'): ?>
								  		<i class="fa fa-<?php echo $chkbox_value; ?>"></i>
								  	<?php endif; ?>
								  	<span class="text-info"><?php echo $label_text; ?></span>
								  </label>
								</div>
							</div>
						<?php endforeach; ?>
						</div>

						<div class="row">
							<div class="col-sm-12">

								<section class="mt1 <?php echo ( ! $cms->website_social_media_other) ? 'initially-hidden' : ''; ?>" id="website_social_media_other_text">
									<div class="input-group">
	      								<span class="input-group-addon"><span class="glyphicon glyphicon-edit"></span> <?php echo $cms_rules[24]['label']; ?></span>
	      								<?php echo questionnaire_form_input('text', $cms_rules[24], $cms->website_social_media_other, array('class' => 'form-control')); ?>
	    							</div>
    							</section>

							</div>
						</div>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo questionnaire_form_label($cms_rules[25], array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-9">
						<div class="radio">
						  <label><?php echo questionnaire_form_radio($cms_rules[25], 'no', ($cms->website_logo == 'no') ? true : false); ?>No</label>
						</div>
						<div class="radio">
						  <label><?php echo questionnaire_form_radio($cms_rules[25], 'yes', ($cms->website_logo == 'yes') ? true : false); ?>Yes</label>
						</div>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo questionnaire_form_label($cms_rules[26], array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-9 mt1">
                    	<button type="button" class="btn btn-info btn-lg" id="bigstock-button"><span class="glyphicon glyphicon-picture"></span> Select images</button>
                    </div>
                </div>

                <section>
                    <div class="row">

						<table class="table table-condensed table-striped <?php echo ( ! $website_images) ? 'hidden' : ''; ?>" id="website-images-table" data-nextrow="<?php echo count($website_images); ?>">
                    		<thead>
                    			<tr><th></th><th class="text-center">Thumbnail</th><th>Title</th></tr>
                    		</thead>
                    		<tbody>
                    		<?php if($website_images): ?>
								<?php foreach($website_images as $row => $website_image): ?>
		                    		<tr>
										<td class="col-sm-3 text-right">
											<button type="button" class="btn btn-link btn-xs"><span class="text-danger"><span class="glyphicon glyphicon-remove-circle"></span> Remove</span></button>
											<?php echo form_hidden(sprintf($website_images_rules[1]['field'], $row), $website_image->website_images_id); ?>
											<?php echo form_hidden(sprintf($website_images_rules[2]['field'], $row), $website_image->bigstock_id); ?>
										</td>
				                    	<td class="col-sm-4 text-center">
				                    		<img src="<?php echo $website_image->bigstock_thumb; ?>" class="img-thumbnail">
											<?php echo form_hidden(sprintf($website_images_rules[3]['field'], $row), $website_image->bigstock_thumb); ?>
										</td>
				                    	<td class="col-sm-7">
				                    		<span class="text-info"><?php echo $website_image->bigstock_title; ?></span>
											<?php echo form_hidden(sprintf($website_images_rules[4]['field'], $row), $website_image->bigstock_title); ?>
										</td>
									</tr>
		                    	<?php endforeach; ?>
	                    	<?php endif; ?>
	                    	</tbody>
	                    </table>

                    </div>
                </section>

				<!-- Section 6 -->
                <h2 id="section-6" class="mt5">Miscellanious</h2>

                <div class="form-group">
                    <?php echo questionnaire_form_label($cms_rules[27], array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-9">
                    	<?php echo questionnaire_form_textarea($cms_rules[27], $cms->your_additional_thoughs, array('class' => 'form-control', 'rows' => 4)); ?>
                    	<?php echo questionnaire_help_block($cms_rules[27]); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo questionnaire_form_label($cms_rules[28], array('class' => 'col-sm-3 control-label', 'recommended' => 'recommended')); ?>
                    <div class="col-sm-9">

                    	<div class="row">
						<?php foreach($os_platform as $chkbox_value => $label_text): ?>
							<div class="col-sm-4">

								<div class="checkbox">
								  <label class="control-label">
								  	<?php echo questionnaire_form_checkbox($cms_rules[28], $chkbox_value, $cms->your_operating_system_platform, array('id' => "your_operating_system_platform_{$chkbox_value}")); ?>
								  	<?php if($chkbox_value != 'other'): ?>
								  		<i class="fa fa-<?php echo $chkbox_value; ?>"></i>
								  	<?php endif; ?>
								  	<span class="text-info"><?php echo $label_text; ?></span>
								  </label>
								</div>

							</div>
						<?php endforeach; ?>
						</div>

						<div class="row">
							<div class="col-sm-12">

								<section class="mt1 <?php echo ( ! $cms->your_operating_system_platform_other) ? 'initially-hidden' : ''; ?>" id="your_operating_system_platform_other_text">
									<div class="input-group">
	      								<span class="input-group-addon"><span class="glyphicon glyphicon-edit"></span> <?php echo $cms_rules[29]['label']; ?></span>
	      								<?php echo questionnaire_form_input('text', $cms_rules[29], $cms->your_operating_system_platform_other, array('class' => 'form-control')); ?>
	    							</div>
    							</section>

							</div>
						</div>

                    </div>
                </div>

                <div class="form-group">
                    <?php echo questionnaire_form_label($cms_rules[30], array('class' => 'col-sm-3 control-label', 'recommended' => 'recommended')); ?>
                    <div class="col-sm-9">

                    	<div class="row">
						<?php foreach($mobile_os_platform as $chkbox_value => $label_text): ?>
							<div class="col-sm-4">

								<div class="checkbox">
								  <label class="control-label">
								  	<?php echo questionnaire_form_checkbox($cms_rules[30], $chkbox_value, $cms->your_mobile_operating_system_platform, array('id' => "your_mobile_operating_system_platform_{$chkbox_value}")); ?>
								  	<?php if($chkbox_value != 'other'): ?>
								  		<i class="fa fa-<?php echo $chkbox_value; ?>"></i>
								  	<?php endif; ?>
								  	<span class="text-info"><?php echo $label_text; ?></span>
								  </label>
								</div>

							</div>
						<?php endforeach; ?>
						</div>

						<div class="row">
							<div class="col-sm-12">

								<section class="mt1 <?php echo ( ! $cms->your_mobile_operating_system_platform_other) ? 'initially-hidden' : ''; ?>" id="your_mobile_operating_system_platform_other_text">
									<div class="input-group">
	      								<span class="input-group-addon"><span class="glyphicon glyphicon-edit"></span> <?php echo $cms_rules[31]['label']; ?></span>
	      								<?php echo questionnaire_form_input('text', $cms_rules[31], $cms->your_mobile_operating_system_platform_other, array('class' => 'form-control')); ?>
	    							</div>
    							</section>

							</div>
						</div>

                    </div>
                </div>

				<div class="form-group">
                    <?php echo questionnaire_form_label($cms_rules[32], array('class' => 'col-sm-3 control-label', 'recommended' => 'recommended')); ?>
                    <div class="col-sm-9">

                    	<div class="row">
						<?php foreach($web_browsers as $chkbox_value => $label_text): ?>
							<div class="col-sm-4">

								<div class="checkbox">
								  <label class="control-label">
								  	<?php echo questionnaire_form_checkbox($cms_rules[32], $chkbox_value, $cms->your_browser, array('id' => "your_browser_{$chkbox_value}")); ?>
								  	<?php if($chkbox_value != 'other'): ?>
								  		<img src="/assets/images/<?php echo $chkbox_value; ?>.png" alt="<?php echo $chkbox_value; ?>" />
								  	<?php endif; ?>
								  	<span class="text-info"><?php echo $label_text; ?></span>
								  </label>
								</div>

							</div>
						<?php endforeach; ?>
						</div>

						<div class="row">
							<div class="col-sm-12">

								<section class="mt1 <?php echo ( ! $cms->your_browser_ie) ? 'initially-hidden' : ''; ?>" id="your_browser_ie_text">
									<div class="input-group">
	      								<span class="input-group-addon"><span class="glyphicon glyphicon-edit"></span> <?php echo $cms_rules[33]['label']; ?></span>
	      								<?php echo questionnaire_form_input('text', $cms_rules[33], $cms->your_browser_ie, array('class' => 'form-control')); ?>
	    							</div>
    							</section>

							</div>
						</div>

						<div class="row">
							<div class="col-sm-12">

								<section class="mt1 <?php echo ( ! $cms->your_browser_other) ? 'initially-hidden' : ''; ?>" id="your_browser_other_text">
									<div class="input-group">
	      								<span class="input-group-addon"><span class="glyphicon glyphicon-edit"></span> <?php echo $cms_rules[34]['label']; ?></span>
	      								<?php echo questionnaire_form_input('text', $cms_rules[34], $cms->your_browser_other, array('class' => 'form-control')); ?>
	    							</div>
    							</section>

							</div>
						</div>

                    </div>
                </div>

				<!-- Form Submit -->
				<div class="row">
					<div class="col-sm-9 col-sm-offset-3">

						<div class="control mt3">
							<button type="button" id="cms_questions_submit" data-loading-text="Submitting..." class="btn btn-primary btn-lg" autocomplete="off"><span class="glyphicon glyphicon-ok"></span> Done!</button>
							<span class="help-block">Submit your answers to us.</span>
						</div>

					</div>
				</div>

			<?php echo form_close(); ?>

        </div>
    </div>

</div>

<!-- Bigstock dialog box -->
<div class="modal fade initially-hidden" id="search-form" tabindex="-1" role="dialog">
	<div class="modal-content">

		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<h4 class="modal-title">Find an Image</h4>
		</div>

		<div class="modal-body">
			<form class="form-horizontal well form-search">
				<div class="form-group">
					<div class="col-sm-8">
    					<input type="text" class="form-control span4 search-query" placeholder="Find the perfect image...">
    				</div>
    				<button type="button" class="btn btn-primary" id="search-button">Search</button>
  				</div>
			</form>

			<!-- this div will be populated with categories -->
			<div id="categories">
				<h4 class="modal-title">or Browse by Category</h4>
				<div class="well">
					<ul></ul>
				</div>
			</div>

			<!-- this div will be populated with search results -->
			<div class="well initially-hidden" id="results-holder">
				<ul class="thumbnails" id="results">
				</ul>
			</div>
		</div>

		<div class="modal-footer">
			<a href="" id="category-link" class="pull-left initially-hidden">&larr; browse by category</a>
			<a href="http://www.bigstockphoto.com"><img src="//www.bigstockphoto.com/images/bigstock-black-medium.png" alt="Bigstock"></a>
		</div>

    </div>
</div>

<!-- Bigstock search results item template -->
<ul class="item-template initially-hidden">
	<li>
		<a href="#" class="thumbnail"><img></a>
	</li>
</ul>

<!-- Bigstock image detail template -->
<div class="detail-template modal fade initially-hidden" tabindex="-1" role="dialog">
    <div class="modal-content">

		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<h4 class="modal-title"></h4>
		</div>

		<div class="modal-body text-center">
			<img>
		</div>

		<div class="modal-footer">
			<a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
			<a href="#" class="btn btn-primary">Select this image</a>
		</div>

	</div>
</div>
