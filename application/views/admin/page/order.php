	<h2>Lapu izkārtojums</h2>
	<p class="alert alert-info">Pavelc, lai pārkārtotu lapas, tad nospied 'Saglabāt'.</p>
	<div id="orderResult"></div>
	<input type="button" id="save" value="Saglabāt" class="btn btn-primary" />
</section>

<script>
$(function() {
	//pie lapas ielādes, nekādi parametri netiek padoti
	$.post('<?php echo site_url('admin/page/order_ajax'); ?>', {}, function(data){
		//ievieto rezultātus divā
		$('#orderResult').html(data);
	});
	//kad saglabāt ir nospiesta:
	$('#save').click(function(){
		oSortable = $('.sortable').nestedSortable('toArray');

		$('#orderResult').slideUp(function(){
			$.post('<?php echo site_url('admin/page/order_ajax'); ?>', { sortable: oSortable }, function(data){
				$('#orderResult').html(data);
				$('#orderResult').slideDown();
			});
		});
		
	});
});
</script>