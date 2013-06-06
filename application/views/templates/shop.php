<?php  $langses = $this->session->userdata('lang');?>
<html>
<head>
	<title>Veikals</title>
	<meta charset="UTF-8">
</head>
<body>
	<div class="span9">
<?php if($pagination): ?>
			<section class="pagination"><?php echo $pagination; ?></section>
<?php endif; ?>
 			
 		</div>
	
	<div id="shops">
		<ul>
			<?php foreach ($shops as $shop): ?>
				<li>
					<?php echo form_open('shop/add');?>
					<div>
					<div class="title">
						<?php if ($langses =='english')
						{
							echo $shop->title_eng;
						}
						else echo $shop->title;
					?>
					</div>
					<?php if ($langses =='english'): ?>

					<div class="thumb">
						<a href="<?php echo base_url().'images/thumbs/'.$shop->thumbnail;?>" rel="lightbox" title="<?php echo $shop->body;?>LVL : <?php echo $shop->price;?>"><img src="<?php echo base_url().'images/' .$shop->thumbnail;?>"></a>
					</div>
				<?php else : ?>
				<div class="thumb">
					<a href="<?php echo base_url().'images/thumbs/'.$shop->thumbnail;?>" rel="lightbox" title="<?php echo $shop->body;?>LVL : <?php echo $shop->price;?>"><img src="<?php echo base_url().'images/' .$shop->thumbnail;?>"></a>
				</div>
			<?php endif;?>
					<div class="price">

						<?php if ($langses =='english')
						{
							echo "EUR : ".$shop->price_eng;
						}
						else echo "LVL : ".$shop->price;
						?>
					</div>
					<div class="body">
						<?php if ($langses =='english')
						{
							echo get_excerpt_shop_eng($shop);
						}
						else echo get_excerpt_shop($shop);
					?>
					</div>
				</li>	
			<?php endforeach;?>
		</ul>
	
	</div>
</body>
</html>