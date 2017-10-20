<?php
if(!empty($desti_rate_list)){
?>
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>#</th>
				<th><center>Destination Name</th>
				<th><center>Dollar Rate</center></th>
				<th><center>Prevoius Rate</center></th>
				<th><center>Current Rate</center></th>
			</tr>
		</thead>
		<tbody>
		<?php
		$i=0;
		foreach($desti_rate_list as $data){ $i++
		?>
			<tr>
				<td><?php echo $i; ?> </td>
				<td><center><?php echo $data['destination_name']; ?></center></td>
				<td><center><?php echo $data['dollar_rate']; ?></center></td>
				<td><center><?php echo $data['previous_rate']; ?></center></td>
				<td><center><?php echo $data['current_rate']; ?></center></td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
<?php
}else{
?>
	<div class="NoDataFound"><center>No Data Found</center></div>
<?php
}
?>