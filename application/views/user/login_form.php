<link href="<?php echo site_url('css/styles.css'); ?>" rel="stylesheet">
<div id="login_form">
	<h1>Autentificēšanās forma!</h1>
	<?php 
	echo form_open('login/validate_credentials');
	echo form_input('username', 'Lietotājvārds');
	echo form_password('password', 'Parole');
	echo form_submit('submit', 'Ieiet');
	echo anchor('login/signup', 'Izveidot profilu');
	?>
</div>