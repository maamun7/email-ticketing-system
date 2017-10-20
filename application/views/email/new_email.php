<script src="<?php echo base_url(); ?>my-assets/js/json/contact_list.js.php" ></script>
<link href="<?php echo base_url(); ?>assets/js/plugins/text_editor/jquery-te-1.4.0.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>assets/js/plugins/text_editor/jquery-te-1.4.0.min.js"></script>

<div class="row">
	<div class="col-lg-12">
		  &nbsp;
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-info">
			<div class="panel-heading">				                       
                <button type="submit" id="send" class="btn btn-success">Send</button>
                <a href="<?php echo base_url(); ?>" class="btn btn-default">Cancel</a>
				<small class="pull-right" > <?php echo current_bd_data_time(); ?></small>
			</div>
			<div class="panel-body">
                 <form role="form" id="send_mail_form" action="{action}" method="POST">
                    <div class="col-lg-12"> 
                        <div class="">                            
                            <?php if (isset($error_to_email)) { ?>
                                <label><span class="red_color"><?php echo $error_to_email; ?></span></label>
                            <?php } ?>                 
                            <input type="text" name="to_email" value="<?php if (isset($to_email_value)) { echo $to_email_value; } ?>" id="to_email" class="emai_field" placeholder="To" >
                            <small class="pull-right" ><span class="cc">CC</span> &nbsp;<span class="bcc">BCC</span></small>  
                        </div>
                        <div class="cc-field">
                            <input name="cc_email" id="cc_email" value="<?php if (isset($cc_email_value)) { echo $cc_email_value; } ?>" class="emai_field" placeholder="CC">
                        </div>
                        <div class="bcc-field">
                            <input name="bcc_email" id="bcc_email" value="<?php if (isset($bcc_email_value)) { echo $bcc_email_value; } ?>" class="emai_field" placeholder="BCC">
                        </div>
                            <input name="email_subject" class="emai_subject" value="<?php if (isset($email_subject_value)) { echo $email_subject_value; } ?>" placeholder="Add Subject">                    
                    </div>
                    <div class="col-lg-12" style="height:440px">
                        <textarea name="message" class="txtEditor"><?php if (isset($message_value)) { echo $message_value; } ?></textarea>
                    </div>
                </form>                 
			</div>
			<div class="panel-footer">
                Panel Footer
            </div>
		</div>
	</div>
</div>
<!--<button class="status">Toggle jQTE</button>-->

<script>
    $('.txtEditor').jqte();
    
    /*
    var jqteStatus = true;
    $(".status").click(function()
    {
        jqteStatus = jqteStatus ? false : true;
        $('.jqte-test').jqte({"status" : jqteStatus})
    });
*/
$(".cc").click(function() {
  $(".cc-field").show( "slow" );
  $(".cc").hide();
});

$(".bcc").click(function() {
  $(".bcc-field").show( "slow" );
  $(".bcc").hide();
});

$("#send").click(function() {
  $("#send_mail_form").submit();
});

</script>
<link href="<?php echo base_url(); ?>assets/js/plugins/autocomplete/base/jquery.ui.all.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>assets/js/plugins/autocomplete/ui/jquery.ui.core.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/autocomplete/ui/jquery.ui.widget.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/autocomplete/ui/jquery.ui.position.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/autocomplete/ui/jquery.ui.menu.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/autocomplete/ui/jquery.ui.autocomplete.js"></script>