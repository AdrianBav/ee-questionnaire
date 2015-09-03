<div class="container" id="questionnaire-page">

    <div class="row">
        <div class="col-xs-12">

			<!-- Questionnaire Info -->
			<div class="jumbotron questionnaire-info">
				<h1><?php echo $questionnaire_data->company_reference; ?> <small><?php echo $questionnaire_data->project_type; ?> project</small></h1>
				<h2>Client: <small><?php echo $questionnaire_data->client_name; ?> <span class="label label-info"><?php echo $questionnaire_data->client_email; ?></span></small></h2>
				<h3>Issued: <small><span class="issued-date"><?php echo $questionnaire_data->issued_date; ?></span></small></h3>
				<p class="mt3"><a href="/dashboard" class="btn btn-default btn-lg" role="button"><span class="glyphicon glyphicon-dashboard"></span> Back to Dashboard</a></p>
			</div>

			<!-- Display any messages -->
			<?php if (isset($message)): ?>
				<div class="alert alert-<?php echo $severity; ?> alert-dismissible" role="alert">
		    		<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		    		<?php echo $message; ?>
		    	</div>
		    <?php endif; ?>

			<?php if ($questionnaire_complete): ?>

				<!-- The questionnaire is complete -->

				<div class="panel panel-success">
					<div class="panel-heading">
						<h3 class="panel-title">Questionnaire Complete!</h3>
					</div>
					<div class="panel-body">
						<p class="text-success"><strong>COMPLETED:</strong> <span class="returned-date"><?php echo $questionnaire_data->returned_date; ?></span></p>
						<p class="text-success"><strong>LAST DOWNLOADED:</strong> <?php if($downloaded_date): ?><span class="downloaded-date"><?php echo $downloaded_date; ?></span> by <?php echo $downloaded_by; ?><?php else: ?>N/A<?php endif; ?></p>

						<button type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#answersModal">
						  <span class="glyphicon glyphicon-eye-open"></span> View Answers
						</button>

						<?php if ($pdf_exists): ?>
							<a href="/pdf/<?php echo $questionnaire_id; ?>" class="btn btn-danger btn-lg"><span class="glyphicon glyphicon-save"></span> Download PDF</a>
						<?php else: ?>
							<a href="/pdf/generate/<?php echo $questionnaire_id; ?>" class="btn btn-danger btn-lg"><span class="glyphicon glyphicon-cog"></span> Generate PDF</a>
						<?php endif; ?>
					</div>
				</div>

				<div class="row">
        			<div class="col-xs-12">

						<!-- Reference Websites -->
						<h3 class="sub-header">Reference Websites <small>All</small></h3>
						<?php echo $reference_websites_table; ?>

        			</div>
        			<div class="col-xs-12">

						<!-- Project Assets -->
						<h3 class="sub-header">Project Assets <small>All</small></h3>
						<?php echo $project_assets_table; ?>

        			</div>
				</div>

			<?php else: ?>

				<!-- The questionnaire is not complete -->

				<!-- Progress Bar -->
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title">Questionnaire In Progress</h3>
					</div>
					<div class="panel-body">

						<p class="text-info"><strong>PROGRESS:</strong></p>

						<div class="progress">
  							<div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="<?php echo $questionnaire_data->progress; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $questionnaire_data->progress; ?>%;">
								<?php echo $questionnaire_data->progress; ?>%
  							</div>
						</div>

					</div>
				</div>

				<!-- Reminders -->
				<div class="panel panel-warning">
					<div class="panel-heading">
						<h3 class="panel-title">Reminders</h3>
					</div>
					<div class="panel-body">

						<div class="row">
        					<div class="col-xs-6">

        						<p class="text-warning"><strong>Clients last activity:</strong> <span class="last-activity"><?php echo $questionnaire_data->last_activity; ?></span></p>
        						<p>Reminders are automatically e-mailed to the client by the system after 7 days without client activity.</p>
								<div class="toggle-switch toggle-switch-warning">
									<label>
										<input type="checkbox" checked>
										<div class="toggle-switch-inner"></div>
										<div class="toggle-switch-switch"><i class="fa fa-check"></i></div>
									</label>
								</div>

								<hr />

								<!-- Form to allow reminder email to be manually sent. -->
        						<p>Additionally, you can issue a reminder now!</p>

								<?php echo validation_errors(); ?>

								<?php echo form_open("/dashboard/q/{$questionnaire_id}", array('role' => 'form', 'id' => 'reminder-form')); ?>
									<div class="checkbox">
										<label>
									    	<?php echo form_checkbox('confirmField', 'yes', FALSE); ?> I understand that this action will e-mail a reminder to the client
										</label>
									</div>
									<?php echo form_button(array('type' => 'submit', 'class' => 'btn btn-warning', 'name' => 'issueButton', 'content' => '<span class="glyphicon glyphicon-send"></span> Issue Reminder')); ?>
								<?php echo form_close(); ?>

        					</div>

        					<div class="col-xs-6">
								<p class="text-warning"><strong>REMINDER HISTORY:</strong></p>
								<?php echo $reminders_table; ?>
        					</div>
						</div>

					</div>
				</div>

			<?php endif; ?>

        </div>
    </div>

</div>


<!-- Answers Modal -->
<div class="modal fade" id="answersModal" tabindex="-1" role="dialog" aria-labelledby="answersModalLabel" aria-hidden="true">
	<div class="modal-dialog">
	    <div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="answersModalLabel">View Questionnaire Answers</h4>
			</div>

			<div class="modal-body">
	        	<?php echo $questionnaire_answers; ?>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>

	    </div>
	</div>
</div>
