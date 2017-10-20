<div class="row">
    <div class="col-lg-3">
    </div>
    <div class="col-lg-6">
        <form method="post" id="InfroText" class="contact" action="<?php echo base_url(); ?>email/do_response">
            <div class="form-group">
                <label>Estimate Time (in minute):</label>
                <input type="input" placeholder="Enter Time in Minute" name="estimate_time" value="<?php if(isset($response_edit_data[0]['estimate_time'])){echo $response_edit_data[0]['estimate_time']; }?>" class="form-control">
            </div>
            <div class="form-group">
                <label>Message:</label>
                <textarea class="form-control" name="message"  rows="3"> <?php if(isset($response_edit_data[0]['message'])){echo $response_edit_data[0]['message']; }?> </textarea>
            </div>            
            <input type="hidden" name="email_id" value="<?php if(isset($email_id)){echo $email_id; }?>">
            <input type="submit" id="" class="btn btn-primary" value="Save">
        </form>
	</div>
	<div class="col-lg-3">
    </div>
</div>

<script type="text/javascript">
	$(document).ready(function () {
		$('#InfroTextSubmit').click(function(){
			var email_id=$("input[name=id]").val();
			var estimate_time=$("input[name=estimate_time]").val();
			var message=$("textarea[name=message]").val();
			//alert(id);
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>email/do_response",
				data: 'email_id='+email_id+'&estimate_time='+estimate_time+'&message='+message,
				success: function(msg){
					$("#msg").html("Succesfyll Updated")
					$("#myModal").modal('hide');	
				},
				error: function(){
					alert("failure");
				}
			});
		});
	});
</script>