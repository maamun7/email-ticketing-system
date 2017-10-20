<div class="page-header"><h1>Add new role</h1></div>
<div class="col-lg-12 ">
    <form action="<?=base_url()?>crole/add_role" id="add_role" method="post"  name="add_role" enctype="multypart/formdata">
        <div class="col-lg-6">
            <div class="form-group">
                <label class="form-label">Role name:</label>
                <input type="text" placeholder="Role name" class="form-control fifty-percent italic check" id="role_name" name="role_name" />
            </div>
        </div>
        <div class="col-lg-12">
        	<legend class="form-label">Set permissions</legend>
            <p class="col-lg-6">
            {permissions}
            </p>
            <div class="form-actions">
    			<input type="submit" id="add-role" class="btn btn-primary" name="add-role" value="Save" />
            </div>        
        </div>
    </form>
</div>

 