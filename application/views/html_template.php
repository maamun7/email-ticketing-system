<!DOCTYPE html>
<html>
<head>
	<title><?php echo (isset($title)) ? $title :"Email Ticketing Systems" ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">	

    <script src="<?php echo base_url(); ?>assets/js/jquery-1.10.2.js"></script>
    
	<link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/css/plugins/morris/morris-0.4.3.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/css/plugins/timeline/timeline.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/css/sb-admin.css" rel="stylesheet">
	
	<link href="<?php echo base_url(); ?>my-assets/css/customize.css" rel="stylesheet">
</head>
<body>
	<script type="text/javascript">
        $('body').on('hidden', '.modal', function () {
          $(this).removeData('modal');
        });
    </script>
    <div id="wrapper">
		<?php $this->load->view('include/header'); ?>
		<div id="page-wrapper">
			{msg_content}
			{sub_menu}
			{content}
		</div> <!-- /#page-wrapper -->	
	</div><!-- end div #wrapper -->	
	<?php $this->load->view('include/footer'); ?>
	 <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
	
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script> 
    <script src="<?php echo base_url(); ?>assets/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/plugins/morris/raphael-2.1.0.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/plugins/morris/morris.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/sb-admin.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/demo/dashboard-demo.js"></script>

</body>
</html>