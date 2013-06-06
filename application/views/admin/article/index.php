<section>
	<h2>Raksti</h2>
	<?php echo anchor('admin/article/edit', '<i class="icon-plus"></i> Pievienot rakstu '); ?>
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
<?php if(count($articles)): foreach($articles as $article): ?>	
		<tr>
			<td><?php echo anchor('admin/article/edit/' . $article->id, $article->title); ?></td>
			<td><?php echo $article->pubdate; ?></td>
			<td><?php echo btn_edit('admin/article/edit/' . $article->id); ?></td>
			<td><?php echo btn_delete('admin/article/delete/' . $article->id); ?></td>
		</tr>
<?php endforeach; ?>
<?php else: ?>
		<tr>
			<td colspan="3">Neviens raksts netika atrasts.</td>
		</tr>
<?php endif; ?>	
		</tbody>
	</table>
</section>