<div class="page-header"><h2>Change password</h3></div>
<div class="">
    <form action="<?=base_url()?>user/change_password" id="change_password" method="post"  name="change_password" enctype="multypart/formdata">
        <div class="well row col-lg-12">
            <div class="control-group col-lg-6">
                <label class="">Email:</label>
                <input type="text" placeholder="E-mail" class="form-control" id="email" name="email" value="" />
                <br>
                <label class="">Old password:</label>
                <input type="password" placeholder="Old password" class="form-control" id="old_password" name="old_password" value="" />
            </div>
            <div class="control-group col-lg-6">
                <label>New password:</label>
                <input type="password" placeholder="New password" class="form-control" id="password" name="password" value="" />
                <br>
                <label>Retype new password:</label>
                <input type="password" placeholder="Retype new password" class="form-control" id="repassword" name="repassword" value="" />
                <br/>
                <button type="submit" id="change-password" class="pull-right btn btn-primary" name="change-password"> Change password </button>
            </div>            
        </div>
    </form>
</div>
