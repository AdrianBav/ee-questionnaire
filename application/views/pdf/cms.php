
<!-- Questionnaire Details -->
<h3 class="sub-header"><?php echo $questionnaire_details->company_reference; ?> <small><?php echo $questionnaire_details->project_type; ?> Questionnaire</small></h3>
<div>
	<p><strong>Issued By:</strong> <?php echo $questionnaire_details->issued_by_name; ?></p>
	<p><strong>Issued Date:</strong> <?php echo date('F j, Y', strtotime($questionnaire_details->issued_date)); ?></p>
	<p><strong>Returned Date:</strong> <?php echo date('F j, Y', strtotime($questionnaire_details->returned_date)); ?></p>
</div>
<br>

<!-- Main Answers -->
<div class="table-responsive">
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Question</th>
				<th>Answer</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($cms_answers as $cms_question => $cms_answer): ?>
			<tr>
				<td><?php echo $cms_question; ?></td>
				<td><?php echo $cms_answer; ?></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</div>


<!-- Key Services -->
<?php if ($key_services): ?>
<h4 class="sub-header">Key Services</h4>

<div class="table-responsive">
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Service</th>
				<th>Description</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($key_services as $key_service): ?>
			<tr>
				<td><?php echo $key_service->service; ?></td>
				<td><?php echo $key_service->description; ?></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</div>
<?php endif; ?>


<!-- Reference Websites -->
<?php if ($reference_websites): ?>
<h4 class="sub-header">Reference Websites</h4>

<div class="table-responsive">
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Website</th>
				<th>Competitor</th>
				<th>Comments</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($reference_websites as $reference_website): ?>
			<tr>
				<td><?php echo $reference_website->title; ?><br><?php echo $reference_website->url; ?></td>
				<td><?php echo $reference_website->competitor_html; ?></td>
				<td><?php echo $reference_website->comments; ?></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</div>
<?php endif; ?>


<!-- Website Images -->
<?php if ($website_images): ?>
<h4 class="sub-header">Website Images</h4>

<div class="table-responsive">
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Title</th>
				<th>Image</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($website_images as $website_image): ?>
			<tr>
				<td>
					<p><?php echo $website_image->bigstock_title; ?></p>
					<p>Bigstock Photo ID: <strong><?php echo $website_image->bigstock_id; ?></strong></p>
				</td>
				<td><img src="<?php echo $website_image->bigstock_thumb; ?>" alt="<?php echo $website_image->bigstock_id; ?>"></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
<?php endif; ?>
