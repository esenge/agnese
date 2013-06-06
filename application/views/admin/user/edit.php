<!-- ļoti līdzīgs kā login formai -->
<!-- ja ir id, tad labot, ja nav, tad pievienot -->
<h3><?php echo empty($user->id) ? 'Pievienot lietotāju' : 'Labot lietotāju ' . $user->name; ?></h3>
<?php echo validation_errors(); ?>
<?php echo form_open(); ?>
<table class="table">
	<tr>
		<td>Vārds</td>
		<td><?php echo form_input('name', set_value('name', $user->name)); ?></td>
	</tr>
	<tr>
		<td>E-pasts</td>
		<td><?php echo form_input('email', set_value('email', $user->email)); ?></td>
	</tr>
	<tr>
		<td>Parole</td>
		<td><?php echo form_password('password'); ?></td>
	</tr>
	<tr>
		<td>Paroles apstiprināšana</td>
		<td><?php echo form_password('password_confirm'); ?></td>
	</tr>
	<tr>
		<td></td>
		<td><?php echo form_submit('submit', 'Saglabāt', 'class="btn btn-primary"'); ?></td>
	</tr>
</table>
<?php echo form_close();?>
