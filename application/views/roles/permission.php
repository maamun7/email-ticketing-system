<div class="page-header"><h1>Assign permission to role: {role_name}</h1></div>
<form name="update_permission" id="update_permission" action="<?=base_url()?>crole/permission/{role_id}" method="post" class="form-horizontal">
    
    <div class="col-lg-12">
        <!--input type="checkbox" name="group[]" value="{group_id}" {is_checked} /-->
        {groups}
        <div class="well col-lg-6"><h4>{group}</h4>
            <div class="thumbnail">
                {permisions}
                    <label class="checkbox">
                        <input type="checkbox" name="permission_alias[]" value="{permission_alias}" {is_checked} /> {permission}
                    </label>
                {/permisions}
            </div>
        </div>
        {/groups}
    </div>
    <div class="form-actions">
        <input class="btn btn-primary" type="submit" name="update-permission" id="update-permission" value="Update permission" />
    </div>
</form>

    