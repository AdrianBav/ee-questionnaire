<div class="container">

	<div class="row">
		<div class="col-xs-12">

		    <div class="page-header">
				<h1>Dashboard</h1>
		    </div>

			<!-- Display any messages -->
			<?php if (isset($message)): ?>
		    	<div class="alert alert-<?php echo $severity; ?> alert-dismissible" role="alert">
		    		<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		    		<?php echo $message; ?>
		    	</div>
		    <?php endif; ?>

	    </div>
    </div>

    <div class="row">
    	<div class="col-xs-4">

			<!-- Dashboard Chart 1 -->
			<div class="chart-holder">
				<p class="text-info text-center">Project Type Distribution</p>
				<canvas id="dashboard-chart-1" />
			</div>

    	</div>

    	<div class="col-xs-4">

			<!-- Dashboard Chart 2 -->
			<div class="chart-holder">
				<p class="text-info text-center">Questionnaire Status</p>
				<canvas id="dashboard-chart-2" />
			</div>

    	</div>

    	<div class="col-xs-4">

			<!-- Dashboard Chart 3 -->
			<div class="chart-holder">
				<p class="text-info text-center">Reminders</p>
				<canvas id="dashboard-chart-3" />
			</div>

    	</div>
	</div>

    <div class="row mt5">
    	<div class="col-xs-6">

			<!-- Recently Returned -->
			<h3 class="sub-header">Recently Returned <small>Last 5</small></h3>
			<?php echo $recently_returned_table; ?>

    	</div>

    	<div class="col-xs-6">

    		<!-- Recently Viewed -->
			<h3 class="sub-header">Recently Viewed <small>Last 5</small></h3>
			<?php if ($recently_viewed_table): ?>
				<?php echo $recently_viewed_table; ?>
			<?php else: ?>
				<p class="text-muted">You have not viewed any questionnaires yet.</p>
			<?php endif; ?>

    	</div>
	</div>

    <div class="row mt1 mb4">
        <div class="col-xs-12">

			<!-- Full Table -->
			<h3 class="sub-header">Questionnaires <small>All</small></h3>
			<div class="table-responsive">
				<?php echo $questionnaires_table; ?>
			</div>

        </div>
    </div>

</div>