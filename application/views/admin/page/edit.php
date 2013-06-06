<h3><?php echo empty($page->id) ? 'Pievienot jaunu lapu' : 'Labot lapu ' . $page->title; ?></h3>
<?php echo validation_errors(); ?>
<?php echo form_open(); ?>
<table class="table">
	<tr>
		<td>Vecāks</td>
		<td><?php echo form_dropdown('parent_id', $pages_no_parents, $this->input->post('parent_id') ? $this->input->post('parent_id') : $page->parent_id); ?></td>
	</tr>
	<tr>
		<td>Veidne</td>
		<td><?php echo form_dropdown('template', array('page' => 'Lapa', 'news_archive' => 'Rakstu arhīvs', 'homepage' => 'Sākumlapa', 'shop'=>'Veikals','contacts'=>'Kontakti'), $this->input->post('template') ? $this->input->post('template') : $page->template); ?></td>
	</tr>
	<tr>
		<td>Virsrakts latviski</td>
		<td><?php echo form_input('title', set_value('title', $page->title)); ?></td>
	</tr>
	<tr>
		<td>Virsraksts angliski</td>
		<td><?php echo form_input('title_eng', set_value('title_eng', $page->title_eng)); ?></td>
	</tr>
	<tr>
		<td>Īsvārds</td>
		<td><?php echo form_input('slug', set_value('slug', $page->slug)); ?></td>
	</tr>
	<tr>
		<td>Pamatteksts latviski</td>
		<td><?php echo form_textarea('body', set_value('body', $page->body), 'class="tinymce"'); ?></td>
	</tr>
	<tr>
		<td>Pamatteksts angliski</td>
		<td><?php echo form_textarea('body_eng', set_value('body_eng', $page->body_eng), 'class="tinymce"'); ?></td>
	</tr>
	<tr>
		<td></td>
		<td><?php echo form_submit('submit', 'Saglabāt', 'class="btn btn-primary"'); ?></td>
	</tr>
</table>
<?php echo form_close();?>
