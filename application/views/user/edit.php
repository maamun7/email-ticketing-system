<script src="<?php echo base_url(); ?>my-assets/js/admin_js/users.js" type="text/javascript"></script>
<div class="page-header"><h1>Edit User</h1></div>
<div class="row col-lg-12 well">
    <form class="form-horizontal" action="<?=base_url()?>cuser/user_update" id="user" method="post"  name="user" enctype="multypart/formdata">
         <div class="col-lg-4">
            <legend>Basic info</legend>
            <div class="form-group">
                <label for="first_name">First name</label>
                <input type="text" placeholder="First name" class="form-control" id="first_name" name="first_name" value="{first_name}" />
            </div>
            <div class="form-group">
                <label for="last_name">Last name</label>
                <input type="text" placeholder="Last name" class="form-control" id="last_name" name="last_name" value="{last_name}" />
            </div>
            <div class="form-group">
                <label for="designation">Designation</label>
                <input type="text" placeholder="Designation" class="form-control" id="designation" name="designation" value="{designition}" />
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <textarea id="address" name="address" class="form-control" placeholder="Address">{address}</textarea>
            </div>
        </div>
        <div class="col-lg-2"></div>
        <div class="col-lg-4">
            <legend>Login info</legend>
            <div class="form-group">
               <label class="control-label" for="email">Email</label>
               <input type="text" placeholder="User's email address" class="form-control" id="email" name="email" value="{email}" />
            </div>

            <legend>System info</legend>
            <div class="form-group">
                <label for="">Can login</label>
                <div class="controls">
                    <input type="radio" <?php if(isset($can_login) && $can_login ==1){echo 'checked="checked"';} ?> name="can_login" value="1" checked="checked">&nbsp; Yes.
                    <input type="radio" <?php if(isset($can_login) && $can_login ==0){echo 'checked="checked"';} ?> name="can_login" value="0">&nbsp; No.
                </div>
            </div>
            <div class="form-group">
                <label class="control-label" for="is_active">Active status</label>                
                <select id="is_active" name="is_active" class="form-control">
                    <option value="1" <?php if(isset($is_active) && $is_active ==1){echo "selected='selected'";} ?> >Active</option>
                    <option value="0" <?php if(isset($is_active) && $is_active ==0){echo "selected='selected'";} ?> >Deactive</option>
                </select>
            </div>
            <?php if(isset($user_type) && $user_type ==1){ ?>
            <div class="form-group">
                <label class="control-label" for="role_id">Set role</label>               
                <select id="role_id" name="role_id" class="form-control">
                    <option value="0" {selected} >Register User</option>
                </select>
            </div> 
            <?php }else{?>
            <div class="form-group">
                <label for="role_id">Set role</label>
                <select id="role_id" name="role_id" class="form-control">
                    {roles}
                    <option value="{role_id}" {selected} >{role}</option>
                    {/roles}
                </select>
                 <input type="hidden" name="user_id" value="{user_id}" />
            </div>
            <?php } ?>
            <button type="submit" id="change-password" class="pull-right btn btn-primary" name="change-password"> Save Changes</button>
        </div>
    </form>
</div>