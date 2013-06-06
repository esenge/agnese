<!-- Galvenā informācija -->
<?php  $langses = $this->session->userdata('lang');?>
 <div class="span9">


	 <div class="row">
		<?php if (count($articles)): foreach ($articles as $article): ?>
 			<article class="span9">
 				<?php if ($langses =='english'){
                echo get_excerpt_eng($article);
            }
        else echo get_excerpt($article);
        ?>

 			</article>
		<?php endforeach; endif; ?>
 	</div>
 </div>
 <!-- Sānjosla -->
 <div class="span3 sidebar">
 	<h2><?php echo $this->lang->line('last10'); ?></h2>
		<?php echo anchor($news_archive_link, $this->lang->line('news_article')); ?>
		<?php $articles10 = array_slice($articles10, 0); ?>
		<?php if ($langses =='english'){
            echo article_links_eng($articles10);
        }
        else echo article_links($articles10);
        ?>
 </div>