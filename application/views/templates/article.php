<!-- galvenā daļa -->
<?php  $langses = $this->session->userdata('lang');?>
<div class="span9">
    <article>
        <h2><?php if ($langses =='english'){
                echo e($article->title_eng);
            }
        else echo e($article->title); ?></h2>

        <?php echo img(array('src' => 'images/'. $article->thumbnail)) ?>
        <p class="pubdate"><?php echo e($article->pubdate); ?></p>
        <?php if ($langses =='english'){
                echo ($article->body_eng);
            }
        else echo ($article->body); ?></h2>


<h3><cufon class="cufon cufon-canvas" alt="Pievienot komentāru" style="width: 40px; height: 20px;">
        <canvas width="55" height="20" style="width: 55px; height: 20px; top: 0px; left: -1px;"></canvas>
        <cufontext><?php echo $this->lang->line('comments'); ?></cufontext></cufon></h3>


<?php foreach ($result as $comment) :?>
    
      <?php  if ($article->slug == $comment->slug) { ?>
            <div>
                <p><?=$comment->username?>:<?=$comment->message?></p>
            </div>
        <?php } ?>

<?php endforeach;?>

<div class="submitComment" id="insertbeforMe">
    <h3><cufon class="cufon cufon-canvas" alt="Pievienot komentāru" style="width: 40px; height: 20px;">
        <canvas width="55" height="20" style="width: 55px; height: 20px; top: 0px; left: -1px;"></canvas>
        <cufontext><?php echo $this->lang->line('add_comment'); ?></cufontext></cufon></h3>



    <form method="POST" action="">
<p>
    <input type="text" name="username">
    <h3><cufon class="cufon cufon-canvas" alt="Tavs vārds" style="width: 35px; height: 14px;">
        <canvas width="45" height="14" style="width: 45px; height: 14px; top: 0px; left: -1px;"></canvas>
        <cufontext><?php echo $this->lang->line('name'); ?></cufontext></cufon></h3>
        
</p>
 <p>
    <input type="text" name="email">
    <h3><cufon class="cufon cufon-canvas" alt="Tavs e-pasts" style="width: 35px; height: 14px;">
        <canvas width="45" height="14" style="width: 45px; height: 14px; top: 0px; left: -1px;"></canvas>
        <cufontext><?php echo $this->lang->line('email'); ?></cufontext></cufon></h3>
    
</p>

 <p>
     <textarea name="message"></textarea>
</p>
<input type="hidden" value="<?=base_url()?>" id="baseurl">
<input type="submit" value="Iesniegt komentāru">
<input type="reset" value="Notīrīt">
    </form>
</div>

<script src="js/jquery-new.js"></script>    
<script src="js/comment.js"></script>

</article>
 </div>

 <!-- Sānjosla -->
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