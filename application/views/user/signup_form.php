<link href="<?php echo site_url('css/styles.css'); ?>" rel="stylesheet">

<h1>Izveidot profilu</h1>

<fieldset>
	<legend>Personīgā informācija</legend>

	<?php 
		echo form_open('login/create_member');
		echo form_input('first_name', set_value('first_name', 'Vārds'));
		echo form_input('last_name', set_value('last_name', 'Uzvārds'));
		echo form_input('email_address', set_value('email_address', 'E-pasta adrese'));
	?>

</fieldset>

<fieldset>
	<legend>Pieteikšanās informācija</legend>

	<?php 
		echo form_input('username', set_value('username', 'Lietotājvārds'));
		echo form_input('password', set_value('password', 'Parole'));
		echo form_input('password2', set_value('passwor2', 'Paroles apstiprināšana'));

		echo form_submit('submit', 'Izveidot profilu');

	?>
	<?php echo validation_errors('<p class="error">') ?>

</fieldset>