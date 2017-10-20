<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-info">
			<div class="panel-heading">
				<i title="Delete" class="fa fa-tasks"></i> Chapter List
			</div>
			<div class="panel-body">		
				<form class="pull-right form-inline" method="post" action="<?php echo base_url();?>admin/chapter/search_item" role="form" >				
					<div class="form-group">
						<div class="input-group">
							<div class="input-group-addon"><i class="fa fa-search"></i></div>
							<input class="form-control col-sm-6" type="text" name="key_word" placeholder="Enter keyword">
						</div>
					</div>
					<button type="submit" class="btn btn-success"> Go !</button>
				</form>
			</div>
			<?php
				if(!empty($chapter_lists)){
			?>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover" id="dataTables-example">
						<thead>
							<tr>
								<th>#</th>
								<th>Chapter Name</th>								
								<th>Subject Name</th>
								<th>Subcat. Name</th>
								<th><center>Ordering</center></th>
								<th><center>Status</center></th>
								<th><center>Actions</center></th>
							</tr>
						</thead>
						<tbody>
							{chapter_lists}
								<tr>
									<td>{sl}</td>			
									<td>{chapter_name}</td>			
									<td>{subject_name}</td>	
									<td>{sub_cat_name}</td>
									<td><center>{ordering}</center></td>	
									<td><center><i class="fa {sts_class} chapterStatusChange" name="{id}"></i></center></td>		
									<td>
										<center>
											<a href="<?php echo base_url(); ?>admin/chapter/edit/{id}"><i title="Edit" class="fa fa-edit"></i></a>&nbsp; | &nbsp;
											<span class="deleteChapter" name="{id}"><i title="Delete" class="fa fa-minus-circle"></i></span>
										</center>
									</td>
								</tr>
							{/chapter_lists}
						</tbody>
					</table>
				</div>				
				<?php if(isset($links)){ echo $links; } ?>      
			</div> 		
			<div class="panel-footer">
                &nbsp;
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

<span id="baseUrl" name="<?php echo base_url(); ?>"></span>
<script src="<?php echo base_url(); ?>my-assets/admin/js/chapter.js"></script>

