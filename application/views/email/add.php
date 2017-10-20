<h2>New Supplier</h2>
<div class="form-container">
    <form class="form-vertical" action="{action}" id="supplier" method="post"  name="insert_product" enctype="multypart/formdata">
        <div class="row-fluid">
			<table class="table table-condensed table-striped">
				<thead></thead>
				<tbody id="form-actions">
					<tr class="">						
						<td class="span2 text-right">
							Supplier Name
						</td>
						<td class="span4">
							<input type="text" tabindex="1" class="span9" name="supplier_name" value="<?php if (isset($supplier_name_value)) { echo $supplier_name_value; } ?>" placeholder="Enter Supplier Name" />
						</td>
						<td class="span2 text-right">
							<?php if (isset($error_supplier_name)) { ?>
	                        <span class="required"><?php echo $error_supplier_name; ?></span>
	                        <?php } ?>
						</td>
					</tr>
					<tr class="">						
						<td class="span2 text-right">
							Supplier Mobile No.
						</td>
						<td class="span4">
							<input type="text" tabindex="1" class="span9" name="supplier_mobile" value="<?php if (isset($supplier_mobile_value)) { echo $supplier_mobile_value; } ?>" placeholder="Enter Supplier mobile No." />
						</td>
						<td class="span2 text-right">
							<?php if (isset($error_supplier_mobile)) { ?>
	                        <span class="required"><?php echo $error_supplier_mobile; ?></span>
	                        <?php } ?>
						</td>
					</tr>
					<tr class="">						
						<td class="span2 text-right">
							Supplier Email.
						</td>
						<td class="span4">
							<input type="text" tabindex="1" class="span9" name="supplier_email" value="<?php if (isset($supplier_email_value)) { echo $supplier_email_value; } ?>" placeholder="Enter Supplier email" />
						</td>
						<td></td>
					</tr>
					<tr class="">						
						<td class="span2 text-right">
							Supplier Address
						</td>
						<td class="span4">
							<textarea class="span9" name="supplier_address" placeholder="Enter Supplier Address" /><?php if (isset($supplier_address_value)) { echo $supplier_address_value; } ?></textarea>
						</td>
						<td></td>
					</tr>
				</tbody>
			</table>
        </div>
        <div class="form-actions">
            <input type="submit" id="add-supplier" class="btn btn-primary btn-large" tabindex="5" name="add-supplier" value="Save" />
            <input type="submit" value="Save and add another one" name="add-supplier-another" tabindex="6" class="btn btn-large" id="add-supplier-another">
        </div>
    </form>
</div>
