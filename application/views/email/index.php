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
				<i title="Delete" class="fa fa-tasks"></i> &nbsp;{title}
			</div>
		<?php
			if(!empty($email_list)){
		?>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover table_border_color" id="dataTables-example">
						<thead>
							<tr>
								<th></th>
								<th>Sender</th>
								<th>Subject</th>
								<th>Ticket No.</th>
								<th>Status</th>
								<th><center>Actions</center></th>
							</tr>
						</thead>
						<tbody>
							<?php 
								krsort($email_list);
								$i = 0;
								foreach ($email_list as $value) {$i++;
							?>
							<tr>
								<td><?php echo $i; ?></td>
								<td><?php echo $value['new']; ?>&nbsp; <?php echo $value['sender']; ?></td>
								<td>
									<a href="<?php echo base_url(); ?>email/view_detail/<?php echo $value['email_id']; ?>"><?php echo $value['show_subj_with']; ?></a>								
								</td>
								<td><?php echo $value['ticket_no']; ?></td>									 
								<td>									 
 									<center>
										<a class="tip" data-container="body" data-toggle="popover" data-placement="top" title="<?php if(isset($value['is_done'])){ if($value['is_done']==1){ ?> Done By: <?php echo $value['first_name']." ".$value['last_name']; }else{ ?> Receive By: <?php echo $value['first_name']." ".$value['last_name']; } } else {  } ?> " data-content="<?php if(isset($value['is_done'])){ if($value['is_done']==1){ echo "*** COMPLETELY DONE ***";} else { ?> Estimate Time:<?php echo $value['estimate_total_time']; ?> Minutes,   <?php echo $value['message']; } } else { echo 'No Response'; } ?>"><i title="Click to view status" class="fa fa-eye"></i></a>
									</center>
								</td>
								<td><center>
								<?php 
								if(isset($value['is_done'])){
									if($value['is_done']==1)
									{
								?>
									<a class="" href="#"> <i title="Done" class="fa fa-check-square-o"></i> </a>	
									<?php
									} else {
									?>	
										<a class="" data-target="#myModal" data-toggle="modal" href="<?php echo base_url()."cemail/response/".$value['email_id'];?>"> <i title="Processing" class="fa fa-refresh"></i> </a> |
										<a href="<?php echo base_url(); ?>email/done/<?php echo $value['email_id']; ?>"><i title="Do done" class="fa fa-check-square"></i></a>		
									<?php 
									}
								} else { 
								?>	
									<a class="" data-target="#myModal" data-toggle="modal" href="<?php echo base_url()."cemail/response/".$value['email_id'];?>"><i title="Not View" class="fa fa-envelope-o"></i></a>
								<?php } ?>
								</center></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>	
			<div class="panel-footer">
            </div>
		<?php
			}else{
			?>
				<div class="NoDataFound"><center>No Data Found</center></div>
			<?php
			}
		?>
		</div>
	</div>
</div>
<div id="pagin"><center><?php if(isset($links)){echo $links;} ?></center></div>

<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
	<div class="modal-dialog">
        <div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="false">&times</button>
				<h4 id="myModalLabel">Response From Cellex Support:</h4>
			</div>
			<div class="modal-body">
				Loading...
			</div>
			<div class="modal-footer">	
				<button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Close</button>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function(){ 
		var delay = 60000; //2 minutes counted in milliseconds.
		setTimeout("location.reload();",delay);
	});
</script>

<script>
    $(function () {
        $('.tip').popover();
    });

	// Hide popover by clicking on the outside.

     $('body').on('click', function (e) {
        //did not click a popover toggle, or icon in popover toggle, or popover
        if ($(e.target).data('toggle') !== 'popover'
            && $(e.target).parents('[data-toggle="popover"]').length === 0
            && $(e.target).parents('.popover.in').length === 0) { 
            $('[data-toggle="popover"]').popover('hide');
        }
    });
</script>

<!--------------Data Table ------>
    <script src="<?php echo base_url(); ?>assets/js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/plugins/dataTables/dataTables.bootstrap.js"></script>
        <script>
		$(document).ready(function() {
			$('#dataTables-example').dataTable({
		 		"aoColumnDefs": [
			        { 
			          "bSortable": false, 
			          "aTargets": [ -1,-2,-3 ] // <-- gets last column and turns off sorting
			        } 
			     ]
			});
		});
    </script>