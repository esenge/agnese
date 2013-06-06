<?php $this->load->view('components/page_head');?>

<?php
if(isset($_GET['language'])){
 	if($_GET['language']=='english'){
 		$this->lang->load('english', 'english');
 	}
 	else{
 		$this->lang->load('latvian', 'latvian');
 	}
 	 $this->session->set_userdata('lang', $_GET['language']);
 }
 else{
 	$langses = $this->session->userdata('lang');
 	if($langses){
 		$this->lang->load($langses, $langses); // Ja netiek padota valoda ,lieto sessijaa saglabato
 	}
 	else{
 		$this->lang->load('latvian', 'latvian'); // Ja sesija ir tuksha, lieto LV
 	}
 }
?>
<?php  $langses = $this->session->userdata('lang');?>
<body>
<div class="galvenais">
<div class="container">
	<section>
		<h1><?php $img = img('img/title.png'); echo anchor('', $img); ?></h1>
	</section>
	<div class="izvelne">
	<ul>
         <li><a href="<?php $en=img('img/en.png'); echo  'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?language=english';?>"><?php echo $en;?></a></li>
         <li><a href="<?php $lv=img('img/lv.png'); echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?language=latvian';?>"><?php echo $lv;?></a></li>
         <li><button type="button"class="button"><a href="http://localhost/agnese/login" class="link-class"><?php echo $this->lang->line('login'); ?></a></button></li>
         <li><button type="button"class="button"><a href="http://localhost/agnese/login/signup" class="link-class"><?php echo $this->lang->line('signup'); ?></a></button></li>  <!-- pārsūta lietotāju uz log in un signup formu -->
    </ul>
    </div>
	 <div class="navbar">
	 	<div class="navbar-inner">
	 		<div class="container">
	 			<?php if ($langses =='english'){
					echo get_menu_eng($menu);
				}
				else echo get_menu($menu);
				?>

	 		</div>
	 	</div>
	 </div>
 </div>
 <div class="container">
 	<div class="row">
 	<!-- main_layout ielādē visus skatus no templates mapes,padodod subview -->
<?php $this->load->view('templates/' . $subview); ?>
 	</div>
 	<footer>
 		<div class="futeris"><p>Agnese Skujiņa, kvalifikācijas darbs 2013</p></div>
 	</footer>
 </div>
<?php $this->load->view('components/page_tail');?>