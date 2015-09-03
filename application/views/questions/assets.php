<div class="container">

    <div class="page-header">
		<h1>Project Assets</h1>
		<p>If you have a logo, any special graphics, documents, specific font, etc., please visit the project assets page to upload your document files to our servers.</p>
		<p class="mt3"><a href="questions" class="btn btn-default" role="button"><span class="glyphicon glyphicon-check"></span> Done</a></p>

		<!-- Display any messages -->
		<?php if (isset($message)): ?>
	    	<div class="alert alert-<?php echo $severity; ?> alert-dismissible" role="alert">
	    		<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	    		<?php echo $message; ?>
	    	</div>
	    <?php endif; ?>
    </div>

	<!-- Upload Assets -->
	<div class="panel panel-primary">

		<div class="panel-heading">
			<h3 class="panel-title">Upload Assets</h3>
		</div>

	  	<div class="panel-body">
			<?php echo validation_errors(); ?>

			<?php echo form_open_multipart('/go/assets', array('id' => 'project_assets_form', 'class' => 'form-horizontal', 'role' => 'form', 'data-toggle' => 'validator')); ?>

                <div class="form-group">
                    <?php echo questionnaire_form_label($project_assets_rules[0], array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-9">
                    	<?php echo questionnaire_form_input('text', $project_assets_rules[0], null, array('class' => 'form-control')); ?>
                    	<?php echo questionnaire_help_block($project_assets_rules[0]); ?>
                    </div>
                </div>

				<div class="form-group">
					<?php echo form_label("<abbr title='Required field'>*</abbr> {$project_assets_rules[1]['label']}", $project_assets_rules[1]['field'], array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-9">
                    	<?php echo questionnaire_form_input('file', $project_assets_rules[1], null, array('class' => 'form-control'), 'required'); ?>
                    	<?php echo questionnaire_help_block($project_assets_rules[1]); ?>
                    </div>
		  		</div>

                <div class="form-group">
                    <?php echo questionnaire_form_label($project_assets_rules[2], array('class' => 'col-sm-3 control-label')); ?>
                    <div class="col-sm-9">
                    	<?php echo questionnaire_form_textarea($project_assets_rules[2], null, array('class' => 'form-control', 'rows' => 4)); ?>
                    	<?php echo questionnaire_help_block($project_assets_rules[2]); ?>
                    </div>
                </div>

				<div class="form-group">
				    <div class="col-sm-offset-3 col-sm-9">
						<button type="submit" id="project_assets_submit" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-cloud-upload"></span> Upload</button>
				    </div>
				</div>

			<?php echo form_close(); ?>

	  	</div>
	</div>

	<!-- Display Assets -->
	<section>
		<div class="row">

			<table class="table table-condensed table-striped <?php echo ( ! $project_assets) ? 'hidden' : ''; ?>" id="project-assets-table" data-nextrow="<?php echo count($project_assets); ?>">
				<thead>
					<tr><th></th><th>Title</th><th>Filename</th><th>Comments</th></tr>
                </thead>
				<tbody>
				<?php if($project_assets): ?>
					<?php foreach($project_assets as $row => $project_asset): ?>
					<tr>
						<td class="col-sm-3 text-right">
							<button type="button" class="btn btn-link btn-xs remove" data-project-asset-id="<?php echo $project_asset->project_asset_id; ?>">
								<span class="text-danger"><span class="glyphicon glyphicon-remove-circle"></span> Remove</span>
							</button>
						</td>
						<td class="col-sm-3">
							<?php echo $project_asset->title; ?>
						</td>
                    	<td class="col-sm-3">
                    		<?php echo $project_asset->filename; ?>
						</td>
                    	<td class="col-sm-3">
                    		<?php echo $project_asset->comments; ?>
						</td>
					</tr>
					<?php endforeach; ?>
				<?php endif; ?>
				</tbody>
			</table>

		</div>
	</section>

</div>