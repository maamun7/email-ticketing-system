<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Ticketing | Admin Login</title>
    <!-- Core CSS - Include with every page -->
	<link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/css/sb-admin.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
				{msg_content}
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
						<center><h3 class="panel-title">Email Ticketing Admin Login</h3></center>
                    </div>
                    <div class="panel-body">
                        <form role="form" action="<?php echo base_url(); ?>cdashboard/do_login" method="post" id="login">
                            <fieldset>
								<div class="form-group input-group">
                                    <span class="input-group-addon"><i class="fa fa-envelope-o fa-fw"></i></span>
                                    <input type="text" class="form-control" name="username" placeholder="E-mail" type="email" autofocus>
                                </div>
                                <div class="form-group input-group">
                                    <span class="input-group-addon"><i class="fa fa-key fa-fw"></i> </span>
                                    <input class="form-control" placeholder="Password" name="password" type="password" autofocus>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                    </label>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <button type="submit" class="btn btn-lg btn-success btn-block">Login</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>	
    <script src="<?php echo base_url(); ?>assets/js/jquery-1.10.2.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>		
    <script src="<?php echo base_url(); ?>assets/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/sb-admin.js"></script>
</body>
</html>
