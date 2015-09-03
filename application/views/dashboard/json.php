<?php

	/* Set the mime-type and serve JSON data. */
	$this->output
		->set_content_type('application/json')
		->set_output($json_data);
