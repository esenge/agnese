<?php $this->load->view('admin/components/page_head'); ?>
<body>
	<!-- navigācija admin panelī -->
    <div class="navbar navbar-static-top navbar-inverse">
	    <div class="navbar-inner">
		    <a class="brand" href="<?php echo site_url('admin/dashboard'); ?>"><?php echo $meta_title; ?></a>
		    <ul class="nav">

			    <li class="active"><a href="<?php echo site_url('admin/dashboard'); ?>">Informācijas panelis</a></li>
			    <li><?php echo anchor('admin/page', 'Lapas'); ?></li>
			    <li><?php echo anchor('admin/page/order', 'Lapu izkārtojums'); ?></li>
			    <li><?php echo anchor('admin/article', 'Raksti'); ?></li>
			    <li><?php echo anchor('admin/user', 'Lietotāji'); ?></li>
			    <li><?php echo anchor('admin/shop', 'Veikals'); ?></li>
		    </ul>
	    </div>
    </div>

	<div class="container">
		<div class="row">
			<!-- Priekš galvenā skata -->
			<div class="span9">
<!-- ielādē subviewu -->
<?php $this->load->view($subview); ?>
			</div>
			<!-- Sānjosla -->
			<div class="span3">
				<section>
					<?php echo('<i class="icon-user"></i>')?>
					<!-- attēlo lietotāja epastu, logout pogum i clase pievieno ikoniņas -->
					<?php echo mailto($this->session->userdata('email'),$this->session->userdata('email')); ?><br>
					<?php echo anchor('admin/user/logout', '<i class="icon-off"></i> iziet'); ?>
				</section>
			</div>
		</div>
	</div>

<?php $this->load->view('admin/components/page_tail'); ?>