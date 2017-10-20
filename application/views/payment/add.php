<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-info">
			<div class="panel-heading">
				Add New Chapter
				<small class="pull-right red_color">Star marks field are mandatory.</small>
			</div>
			<div class="panel-body">
				<div class="table-responsive">
			    	<form class="form-vertical" action="{action}" id="supplier" method="post"  name="insert_product" enctype="multypart/formdata">
						<table class="table table-condensed table-striped table-bordered table-hover">
							<thead></thead>
							<tbody id="form-actions">								
								<tr>						
									<td class="col-lg-3 text-right">
										Transaction Row <span class="red_color">*</span>
									</td>
									<td colspan="2" class="col-lg-4">
										<?php if (isset($error_transaction_data)) { ?>
				                        <span class="red_color"><?php echo $error_transaction_data; ?></span>
				                        <?php } ?>
										<textarea class="form-control" name="transaction_data" placeholder="Enter Transaction Row"></textarea>									
									</td>
								</tr>
								<tr> <td colspan="3"> </td> </tr>
								<tr>						
									<td class="col-lg-3"></td>
									<td class="col-lg-4">
										<input type="submit" id="add-chapter" class="btn btn-info btn-large" tabindex="5" name="add-chapter" value="Save" />
			           					<input type="submit" value="Save and add another one" name="add-chapter-chapter" tabindex="6" class="btn btn-primary btn-large" id="add-chapter-another">
			        				</td>						
									<td class="col-lg-4"></td>
								</tr>
							</tbody>
						</table>
			    	</form>		
				</div>
			</div>
		</div>
	</div>
</div>
<span id="baseUrl" name="<?php echo base_url(); ?>"></span>
<script src="<?php echo base_url(); ?>my-assets/admin/js/chapter.js"></script>
