<?php $this->load->view('admin/components/page_head'); ?>
<!-- paredzēts pie admin login lodziņa -->
<body style="background: #555;">
	<div class="modal show" role="dialog">
		<!-- subview tiek uzstādīts kontrolierī controllers/admin/user-->	
		<?php $this->load->view($subview); ?>
		<div class="modal-footer">
			&copy; <?php echo date('Y'); ?> <?php echo $meta_title; ?>
		</div>
	</div>
<?php $this->load->view('admin/components/page_tail'); ?>