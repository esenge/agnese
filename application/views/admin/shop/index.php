<section>
	<h2>Veikali</h2>
	<?php echo anchor('admin/shop/edit', '<i class="icon-plus"></i> Pievienot veikalu'); ?>
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Nosaukums</th>
				<th>Publicēšanas datums</th>
				<th>Labot</th>
				<th>Dzēst</th>
			</tr>
		</thead>
		<tbody>
<?php if(count($shops)): foreach($shops as $shop): ?>	
		<tr>
			<td><?php echo anchor('admin/shop/edit/' . $shop->id, $shop->title); ?></td>
			<td><?php echo $shop->pubdate; ?></td>
			<td><?php echo btn_edit('admin/shop/edit/' . $shop->id); ?></td>
			<td><?php echo btn_delete('admin/shop/delete/' . $shop->id); ?></td>
		</tr>
<?php endforeach; ?>
<?php else: ?>
		<tr>
			<td colspan="3">Neviena prece netika atrasta.</td>
		</tr>
<?php endif; ?>	
		</tbody>
	</table>
</section>