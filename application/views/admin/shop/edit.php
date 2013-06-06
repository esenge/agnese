<?php $translated_text1 =$this->lang->line('add_shop');?>
<?php $translated_text2 =$this->lang->line('news_shop');?>
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
<h3><?php echo empty($shop->id) ? 'Pievienot jaunu preci' : 'Labot preci ' . $shop->title; ?></h3>
<?php echo validation_errors(); ?>
<?php echo '<form action="http://localhost/agnese/admin/shop/edit/'.$shop->id.'" method="post" accept-charset="utf-8" enctype="multipart/form-data">'; ?>
<table class="table">
 <tr>
  <td>Publicēšanas datums</td>
  <td><?php echo form_input('pubdate', set_value('pubdate', $shop->pubdate), 'class="datepicker"'); ?></td>
 </tr>
 <tr>
  <td>Nosaukums</td>
  <td><?php echo form_input('title', set_value('title', $shop->title)); ?></td>
 </tr>
 <tr>
  <td>Nosaukums angliski</td>
  <td><?php echo form_input('title_eng', set_value('title_eng', $shop->title_eng)); ?></td>
 </tr>
 <tr>
  <td>Īsvārds</td>
  <td><?php echo form_input('slug', set_value('slug', $shop->slug)); ?></td>
 </tr>
 <tr>
  <td>Apraksts</td>
  <td><?php echo form_textarea('body', set_value('body', $shop->body), 'class="tinymce"'); ?></td>
 </tr>
 <tr>
  <td>Apraksts angliski</td>
  <td><?php echo form_textarea('body_eng', set_value('body_eng', $shop->body_eng), 'class="tinymce"'); ?></td>
 </tr>
 <tr>
  <td>Cena latos</td>
  <td><?php echo form_input('price', set_value('price', $shop->price)); ?></td>
 </tr>
 <tr>
  <td>Cena euro</td>
  <td><?php echo form_input('price_eng', set_value('price_eng', $shop->price_eng)); ?></td>
 </tr>
 <tr>
  <td>Sīkattēls</td>
  <td><?php echo form_upload('userfile', set_value('thumbnail', $shop->thumbnail), 'id="FILEZZZ" onchange="getFilename();"'); ?></td> <!-- // file upload lauks -->
  <input type="hidden" id="bilde_name" name="thumbnail">
 </tr>
 <tr>
  <td></td>
  <td><?php echo form_submit('submit','Saglabāt', 'class="btn btn-primary"'); ?></td>
 </tr>
</table>
<?php echo form_close();?>

<script>
$(function() {
 $('.datepicker').datepicker({ format : 'yyyy-mm-dd' });
});
</script>