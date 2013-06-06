<?php $translated_text1 =$this->lang->line('add_article');?>
<?php $translated_text2 =$this->lang->line('news_article');?>
<script type="text/javascript"> // skripts, kas izmet upload faila direktoriju
             function getFilename()
             {
                 var thefile = document.getElementById('FILEZZZ');
                 var full_filename = thefile.value;
                 var filename = full_filename.split("\\");
                var bilde_vards = document.getElementById('bilde_name');
                 bilde_name.value=filename[filename.length-1];
                //alert(filename[filename.length-1]);
             }
</script>
<h3><?php echo empty($article->id) ? 'Pievienot rakstu' : 'Labot rakstu ' . $article->title; ?></h3>
<?php echo validation_errors(); ?>
<?php echo '<form action="http://localhost/agnese/admin/article/edit/'.$article->id.'" method="post" accept-charset="utf-8" enctype="multipart/form-data">'; ?>
<table class="table">
	<tr>
		<td>Publicēšanas datums</td>
		<td><?php echo form_input('pubdate', set_value('pubdate', $article->pubdate), 'class="datepicker"'); ?></td>
	</tr>
	<tr>
		<td>Nosaukums</td>
		<td><?php echo form_input('title', set_value('title', $article->title)); ?></td>
	</tr>
	<tr>
		<td>Nosaukums angliski</td>
		<td><?php echo form_input('title_eng', set_value('title_eng', $article->title_eng)); ?></td>
	</tr>
	<tr>
		<td>Īsvārds</td>
		<td><?php echo form_input('slug', set_value('slug', $article->slug)); ?></td>
	</tr>
	<tr>
		<td>Pamatteksts</td>
		<td><?php echo form_textarea('body', set_value('body', $article->body), 'class="tinymce"'); ?></td>
	</tr>
	<tr>
		<td>Pamatteksts angliski</td>
		<td><?php echo form_textarea('body_eng', set_value('body_eng', $article->body_eng), 'class="tinymce"'); ?></td>
	</tr>
	<tr>
		<td>Sīkattēls</td>
		<td><?php echo form_upload('userfile', set_value('thumbnail', $article->thumbnail), 'id="FILEZZZ" onchange="getFilename();"'); ?></td> <!-- // file upload lauks -->
		<input type="hidden" id="bilde_name" name="thumbnail">
	</tr>
	<tr>
		<td>Kategorija</td>
		<td>
			<?php echo form_dropdown('category',$options = array(
                  '0' => '-Izvēlies kategoriju -',
                  '10'  => 'Adīšana',
                  '11'    => 'Izšūšana',
                  '12'   => 'Šūšana',
                  '13' => 'Tamborēšana',
                  '14' => 'Pērļošana',
                  '15' => 'Citi',
                ),set_value('category',$article->category) );?>
		</td>
	</tr>
	<tr>
		<td></td>
		<td><?php echo form_submit('submit','Saglabāt', 'class="btn btn-primary"'); ?></td>
	</tr>
</table>
<?php echo form_close();?>

<!-- izmantojot twitter bootsrap css un js failus-->
<script>
$(function() {
	$('.datepicker').datepicker({ format : 'yyyy-mm-dd' });
});
</script>