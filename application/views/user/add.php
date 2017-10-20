<script src="<?php echo base_url(); ?>my-assets/js/admin_js/users.js" type="text/javascript"></script>
<div class="page-header"><h1>Add new user</h1></div>
<div class="row col-lg-12 well">
    <form class="form-horizontal" action="<?=base_url()?>cuser/insert_user" id="user" method="post"  name="user" enctype="multypart/formdata">
         <div class="col-lg-4">
            <legend>Basic info</legend>
            <div class="form-group">
                <label class="control-label" for="first_name">First name</label>
                <input type="text" placeholder="First name" class="form-control" id="first_name" name="first_name" value="" />
            </div>
            <div class="form-group">
                <label for="last_name">Last name</label>
                <input type="text" placeholder="Last name" class="form-control" id="last_name" name="last_name" value="" />
            </div>
            <div class="form-group">
                <label for="designation">Designation</label>
                <input type="text" placeholder="Designation" class="form-control" id="designation" name="designation" value="" />
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <textarea id="address" name="address" class="form-control" placeholder="Address"></textarea>
            </div>
        </div>
        <div class="col-lg-2"></div>
        <div class="col-lg-4">
            <legend>Login info</legend>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" placeholder="User's email address" class="form-control" id="email" name="email" value="" />
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" placeholder="Password" class="form-control" id="password" name="password" value="" />
            </div>
            <legend>System info</legend>
            <div class="form-group">
                <label for="">Can login</label>
                <div class="controls">
                    <input type="radio" class="" name="can_login" value="1" checked="checked">&nbsp; Yes.
                    <input type="radio" class="" name="can_login" value="0">&nbsp; No.
                </div>
            </div>
            <div class="form-group">
                <label for="is_active">Active status</label>
                <div class="controls" form-control>
                    <select id="is_active" name="is_active" class="form-control">
                        <option value="1">Active</option>
                        <option value="0">Deactive</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="role_id">Set role</label>
                <select id="role_id" name="role_id" class="form-control">
                    {roles}
                    <option value="{role_id}">{role}</option>
                    {/roles}
                </select>
            </div>
            <button type="submit" id="change-password" class="pull-right btn btn-primary" name="change-password"> Add User</button>
        </div>                 
        <div class="pull-right col-lg-8">
         </div>
    </form>
</div>