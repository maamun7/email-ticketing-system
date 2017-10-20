<script src="<?php echo base_url(); ?>my-assets/js/admin_js/json/supplier.js.php" ></script>

<div class="row">
	<div class="col-lg-12">
		 <!-- <h1 class="page-header">Tables</h1> --> &nbsp;
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-info">
			<div class="panel-heading">
				<b>Subject:</b>&nbsp; {subject}
				<small class="pull-right" >{date}</small>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<div class="table-responsive">
					<blockquote class="blockquote">
					<ul>
						<li>From: <small>{from} - {from_email_id}</small></li>
						<li>Cc: <small>{cc_email_id}</small></li>
					</ul>
					</blockquote>
	                
					<div class="row">
  						<div class="col-md-12">
	                       {message}
	                    </div>
	                </div>
				</div>
				<div class="row">
					<div class="col-lg-4"></div>
					<div class="col-lg-4">
						<a href="<?php echo base_url(); ?>email/reply_to/{email_no}"><i class="fa fa-reply"></i> Reply</a>
					</div>
					<div class="col-lg-4">
						<a href="<?php echo base_url(); ?>email/reply_to_all/{email_no}"><i class="fa fa-reply-all"></i> Reply To All</a>
					</div>
					<div class="col-lg-4"></div>
				</div>
			</div>
			<div class="panel-footer">
                Panel Footer
            </div>
		</div>
	</div>
</div>