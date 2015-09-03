<div class="container">

    <div class="row">
        <div class="col-xs-12">

		    <div class="page-header">
				<h1>eeQuestionnaire <small>Administrator Log in</small></h1>
		    </div>

        </div>
    </div>

    <div class="row">
        <div class="col-xs-4">

        	<?php echo validation_errors(); ?>

            <?php echo form_open('/', array('class' => 'form')); ?>
                <div class="form-group">
                    <?php echo form_label('Email', 'emailField'); ?>
                    <?php echo form_input(array('type' => 'email', 'class' => 'form-control', 'name' => 'emailField', 'value' => set_value('emailField'), 'id' => 'emailField', 'placeholder' => 'Your Email')); ?>
                </div>

                <div class="form-group">
                	<?php echo form_label('Password', 'passwordField'); ?>
                    <?php echo form_password(array('class' => 'form-control', 'name' => 'passwordField', 'value' => '', 'id' => 'passwordField', 'placeholder' => 'Your Password')); ?>
                </div>

				<div class="control mt3">
                	<?php echo form_button(array('type' => 'submit', 'class' => 'btn btn-primary btn-lg', 'name' => 'loginButton', 'content' => '<span class="glyphicon glyphicon-log-in"></span> Log in')); ?>
                </div>
            <?php echo form_close(); ?>

        </div>
    </div>

</div>