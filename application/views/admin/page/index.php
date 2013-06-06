<section>
	<h2>Lapas</h2>
	<!-- links lai pievienotu lapu -->
	<?php echo anchor('admin/page/edit', '<i class="icon-plus"></i> Pievienot lapu'); ?>
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Nosaukums</th>
				<th>Vecāks</th>
				<th>Labot</th>
				<th>Dzēst</th>
			</tr>
		</thead>
		<tbody>
			<!-- ja ir lapas, attēlo to datus, uz kuriem ir linki -->
<?php if(count($pages)): foreach($pages as $page): ?>	
		<tr>
			<td><?php echo anchor('admin/page/edit/' . $page->id, $page->title); ?></td>
			<td><?php echo $page->parent_slug; ?></td>
			<td><?php echo btn_edit('admin/page/edit/' . $page->id); ?></td>
			<td><?php echo btn_delete('admin/page/delete/' . $page->id); ?></td>
		</tr>
<?php endforeach; ?>
<?php else: ?>
		<tr>
			<td colspan="3">Neviena lapa netika atrasta.</td>
		</tr>
<?php endif; ?>	
		</tbody>
	</table>
</section>