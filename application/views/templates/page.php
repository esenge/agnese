<!-- galvenā daļa -->
<?php  $langses = $this->session->userdata('lang');?>
<div class="span9">

 	<article>

			<?php  if($page->slug=='adisana'){
						foreach ($articles as $article): ?>
							<article class="span9">
								<?php if($article->category == 10)
								if ($langses =='english'){
										echo get_excerpt_eng($article);
									}
									else echo get_excerpt($article);
									?>
							</article>
						<?php endforeach;  
					}
 					elseif ($page->slug=="izsusana") {
						foreach ($articles as $article): ?>
							<article class="span9">
								<?php if($article->category == 11)
								if ($langses =='english'){
										echo get_excerpt_eng($article);
									}
									else echo get_excerpt($article);
									?>
							</article>
						<?php endforeach;  
					}
 				 	elseif ($page->slug=="susana") {	
 				 		foreach ($articles as $article): ?>
 				 			<article class="span9">
 				 				<?php if($article->category == 12)
 				 				if ($langses =='english'){
										echo get_excerpt_eng($article);
									}
									else echo get_excerpt($article);
									?>
 				 		<?php endforeach;  
 				 	} 
 					elseif ($page->slug=="tamboresana") {
 				 		foreach ($articles as $article): ?>
 				 			<article class="span9">
 				 				<?php if($article->category == 13)
 				 				if ($langses =='english'){
										echo get_excerpt_eng($article);
									}
									else echo get_excerpt($article);
									?>
 				 			</article>
 				 		<?php endforeach;
 				 	} 
 				 	elseif ($page->slug=="perlosana") {
 				 		foreach ($articles as $article): ?>
 				 			<article class="span9">
 				 				<?php if($article->category == 14)
 				 				if ($langses =='english'){
										echo get_excerpt_eng($article);
									}
									else echo get_excerpt($article);
									?>
 				 			</article><?php
						endforeach;  
					} 
 				 	elseif ($page->slug=="citi") {
 				 		foreach ($articles as $article): ?>
 				 			<article class="span9">
 				 				<?php if($article->category == 15) if ($langses =='english'){
										echo get_excerpt_eng($article);
									}
									else echo get_excerpt($article);
									?>
 				 			</article><?php
						endforeach;
					}
			;?>
 	</article>
 </div>
 <!-- sānjosla -->
<div class="span3 sidebar">
 	<h2><?php echo $this->lang->line('last10'); ?></h2>
 	<?php $translated_text =$this->lang->line('news_article');?>
	<?php echo anchor($news_archive_link, $translated_text); ?>
	<?php $articles = array_slice($articles10, 0); ?>
	<?php if ($langses =='english'){
                echo article_links_eng($articles10);
            }
        	else echo article_links($articles10);
    ?>
 </div>

 