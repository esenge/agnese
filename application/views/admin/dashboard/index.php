<h2>Pēdējie rediģētie raksti</h2>
<!-- ja ir tādi raksti, ja ir, tad ul tagi, katru rakstu ieliekot li tagā -->
<?php if(count($recent_articles)): ?>
	<ul>
		<?php foreach($recent_articles as $article): ?>
		<li>
			<?php echo anchor('admin/article/edit/' . $article->id, e($article->title)); ?> - <?php echo date('Y-m-d', strtotime(e($article->modified))); ?>
		</li>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>