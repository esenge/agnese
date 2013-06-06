<section>
	<h2>Lietotāji - administratori</h2>
	<!-- links lai pievienotu lietotāju -->
	<?php echo anchor('admin/user/edit', '<i class="icon-plus"></i> Pievienot lietotāju'); ?>
	<table class="table table-striped">
		<thead>
			<tr>
				<th>E-pasts</th>
				<th>Labot</th>
				<th>Dzēst</th>
			</tr>
		</thead>
		<tbody>
<!-- ja ir lietotāji, attēlo to datus, uz kuriem ir linki -->
<?php if(count($users)): foreach($users as $user): ?>	
		<tr>
			<td><?php echo anchor('admin/user/edit/' . $user->id, $user->email); ?></td>
			<!-- ielādē cms_helper -->
			<td><?php echo btn_edit('admin/user/edit/' . $user->id); ?></td>
			<td><?php echo btn_delete('admin/user/delete/' . $user->id); ?></td>
		</tr>
<?php endforeach; ?>
<!-- ja nav, attiecīgais ziņojums -->
<?php else: ?>
		<tr>
			<td colspan="3">Netika atrasts neviens lietotājs.</td>
		</tr>
<?php endif; ?>	
		</tbody>
	</table>
</section>