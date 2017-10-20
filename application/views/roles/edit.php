<div class="page-header"><h1> Edit role: {role}</h1></div>
<div class="row col-lg-12 well">
    <form action="<?=base_url()?>crole/edit_role/{role_id}" id="edit_role" method="post"  name="edit_role" enctype="multypart/formdata">
        <div class="form-group">
        	<label class="">Role name:</label>
       	 	<input type="text" placeholder="Role name" class="form-control fifty-percent italic check" id="role_name" name="role_name" value="{role}" />
        </div>
        <button type="submit" id="change-password" class="btn btn-primary" name="change-password"> Add User</button>
 </form>
</div>