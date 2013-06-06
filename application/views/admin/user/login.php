<!-- login lodziņš -->
<div class="modal-header">
	<h3>Ieiet</h3>
	<p>Lūdzu, piesakies sistēmā ar saviem datiem.</p>
</div>
<div class="modal-body">
<?php echo validation_errors(); ?>
<?php echo form_open();?>
<table class="table">
	<tr>
		<td>E-pasts</td>
		<td><?php echo form_input('email'); ?></td>
	</tr>
	<tr>
		<td>Parole</td>
		<td><?php echo form_password('password'); ?></td>
	</tr>
	<tr>
		<td></td>
		<td><?php echo form_submit('submit', 'Ieiet', 'class="btn btn-primary"'); ?></td>
	</tr>
</table>
<?php echo form_close();?>
</div>