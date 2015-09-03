<div class="container">

    <div class="page-header">
		<h1>Welcome <span class="text-info"><?php echo $client_name; ?>!</span></h1>

		<!-- Display any messages -->
		<?php if (isset($message)): ?>
	    	<div class="alert alert-<?php echo $severity; ?> alert-dismissible" role="alert">
	    		<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	    		<?php echo $message; ?>
	    	</div>
	    <?php endif; ?>
    </div>

    <div class="row">
        <div class="col-xs-6">

			<?php if ($progress == 100): ?>

				<div class="mt1">
					<p class="text-success"><strong>Questionnaire Complete!</strong></p>
					<p>
						Thank you for completing our Website Design Questionnaie.
						Your answers will provide us with a good understanding of how to approach the design of your website.
					</p>
				</div>

				<div class="mt5">
					<p><strong>Project Assets</strong></p>
					<p>
						If you have a logo, any special graphics, documents, specific font, etc.,
						please visit the project assets page to upload your document files to our servers.
					</p>
					<a href="/go/assets" class="btn btn-default btn-lg mt1"><span class="glyphicon glyphicon-folder-open"></span> Project Assets</a>
				</div>

			<?php elseif ($progress == 0): ?>

				<div class="mt1">
					<p>
						Please take a moment to answer as many of the questions as possible.<br>
						Your answers will provide us with a good understanding of how to approach the design of your website.
					</p>
					<a href="/questions/cms" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-pencil"></span> Start Questionnaire</a>
				</div>

			<?php else: ?>

				<p>You have completed <?php echo $progress; ?>% of the questionnaire.</p>

				<div class="progress">
					<div class="progress-bar <?php echo $bar_color; ?> progress-bar-striped" role="progressbar" aria-valuenow="<?php echo $progress; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $progress; ?>%;">
				    	<span class="sr-only"><?php echo $progress; ?>% Complete</span>
					</div>
				</div>

				<div class="mt5">
					<p>You can submit your answers at any time, but it is helpful to us if you provide as much information as you can.</p>
					<a href="/questions/cms" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-pencil"></span> Continue Questionnaire</a>
				</div>

				<div class="panel panel-success mt7">
					<div class="panel-body">
						<p>If you feel you have provided all the information you can, please send us your answers.</p>
						<div class="checkbox">
							<label>
								<input type="checkbox" id="complete-questionnaire-agree">
								I understand that once answers have been submitted they can not be changed.
							</label>
						</div>
						<button class="btn btn-success btn-lg" id="complete-questionnaire"><span class="glyphicon glyphicon-send"></span> Submit Answers</button>
					</div>
				</div>

			<?php endif; ?>

        </div>
    </div>

</div>