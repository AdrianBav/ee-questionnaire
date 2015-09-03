<div class="container">

    <div class="row">
    	<div class="col-xs-12">

		    <div class="page-header">
				<h1>Issue New Questionnaire <small>Email the client</small></h1>
		    </div>

    	</div>

        <div class="col-xs-4">

        	<?php echo validation_errors(); ?>

            <?php echo form_open('/dashboard/issue', array('role' => 'form')); ?>
                <div class="form-group">
                    <?php echo form_label('Company Name', 'companyReferenceField'); ?>
                    <?php echo form_input(array('type' => 'text', 'class' => 'form-control', 'name' => 'companyReferenceField', 'value' => set_value('companyReferenceField'), 'id' => 'companyReferenceField', 'placeholder' => 'Client Company Name')); ?>
                </div>

				<div class="form-group">
					<?php echo form_label('Project Type', 'projectTypeRadios'); ?>
					<div class="radio">
						<label><?php echo form_radio('projectTypeRadios', 'CMS', FALSE); ?>CMS</label>
					</div>
					<div class="radio">
						<label><?php echo form_radio('projectTypeRadios', 'ECOMMERCE', FALSE); ?>E-Commerce</label>
					</div>
				</div>

                <div class="form-group">
                    <?php echo form_label('Client Name', 'clientNameField'); ?>
                    <?php echo form_input(array('type' => 'text', 'class' => 'form-control', 'name' => 'clientNameField', 'value' => set_value('clientNameField'), 'id' => 'clientNameField', 'placeholder' => 'Client Name')); ?>
                </div>

                <div class="form-group">
                    <?php echo form_label('Client Email', 'clientEmailField'); ?>
                    <?php echo form_input(array('type' => 'text', 'class' => 'form-control', 'name' => 'clientEmailField', 'value' => set_value('clientEmailField'), 'id' => 'clientEmailField', 'placeholder' => 'Client Email')); ?>
                </div>

				<div class="control mt3">
                	<?php echo form_button(array('type' => 'submit', 'class' => 'btn btn-primary btn-lg', 'name' => 'issueButton', 'content' => '<span class="glyphicon glyphicon-send"></span> Issue to Client')); ?>
                </div>
            <?php echo form_close(); ?>

        </div>
    </div>

</div>