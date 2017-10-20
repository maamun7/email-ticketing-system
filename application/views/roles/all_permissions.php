<div class="col-lg-12">
    <!--input type="checkbox" name="group[]" value="{group_id}" {is_checked} /-->
    {groups}
    <div class="well col-lg-6"><h4>{group}</h4>
        <div class="thumbnail">
            {permisions}
                <label class="checkbox">
                    <input type="checkbox" name="permission_slug[]" value="{permission_alias}" {is_checked} /> {permission}
                </label>
            {/permisions}
        </div>
    </div>
    {/groups}
</div>