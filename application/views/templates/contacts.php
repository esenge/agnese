<!-- kontaktforma-->
<?php  $langses = $this->session->userdata('lang');?>
<?php if ($langses =='english'){
	echo "<h2>".$page->title_eng."</h2>";
	echo $page->body_eng;
}
else{
	echo "<h2>".$page->title."</h2>";
	echo $page->body;
}
?>
 <div>
<?php echo form_open('email/send'); ?>
	<?php 
		$name_data =array(
			'name'=> 'name',
			'id' =>'name',
			'value'=>set_value('name')
		);
	?>
	<p>
		<label for="name"><?php echo $this->lang->line('name'); ?> </label>
		<?php echo form_input($name_data);?>
	</p>
	<p>
		<label for="name"><?php echo $this->lang->line('email'); ?></label>
		<input type="text" name="email" id="email" value="<?php echo set_value('email');?>">
	</p>
	<p>
		<label for="name"><?php echo $this->lang->line('subject'); ?></label>
		<input type="text" name="subject" id="subject" value="<?php echo set_value('subject');?>">
	<p>
		<label for="name"><?php echo $this->lang->line('message'); ?></label>
		<textarea type="text" name="message" id="message" value="<?php echo set_value('message');?>"></textarea>
	</p>
	<p><?php echo form_submit('submit', $this->lang->line('send'))?></p>
	<?php echo form_close(); ?>
	<?php echo validation_errors(); ?>
 </div>

 