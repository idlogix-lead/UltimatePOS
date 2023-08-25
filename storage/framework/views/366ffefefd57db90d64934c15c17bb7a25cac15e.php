<table class='table table-condensed table-striped'>
	<tr>
	    <th><?php echo app('translator')->get('business.operations'); ?></th>
	    <th><?php echo app('translator')->get('business.keyboard_shortcut'); ?></th>
	</tr>

	<?php if($pos_settings['disable_express_checkout'] == 0): ?>
		<tr>
		    <td><?php echo app('translator')->get('sale.express_finalize'); ?>:</td>
		    <td>
			    <?php if(!empty($shortcuts["pos"]["express_checkout"])): ?>
			    	<?php echo e($shortcuts["pos"]["express_checkout"], false); ?>

			    <?php endif; ?>
		    </td>
		</tr>
	<?php endif; ?>

	<?php if($pos_settings['disable_pay_checkout'] == 0): ?>
		<tr>
		    <td><?php echo app('translator')->get('sale.finalize'); ?>:</td>
		    <td>
		    	<?php if(!empty($shortcuts["pos"]["pay_n_ckeckout"])): ?>
			    	<?php echo e($shortcuts["pos"]["pay_n_ckeckout"], false); ?>

			    <?php endif; ?>
		    </td>
		</tr>
	<?php endif; ?>

	<?php if($pos_settings['disable_draft'] == 0): ?>
		<tr>
		    <td><?php echo app('translator')->get('sale.draft'); ?>:</td>
		    <td>
		    	<?php if(!empty($shortcuts["pos"]["draft"])): ?>
			    	<?php echo e($shortcuts["pos"]["draft"], false); ?>

			    <?php endif; ?>
		    </td>
		</tr>
	<?php endif; ?>

	<tr>
	    <td><?php echo app('translator')->get('messages.cancel'); ?>:</td>
	    <td>
	    	<?php if(!empty($shortcuts["pos"]["cancel"])): ?>
		    	<?php echo e($shortcuts["pos"]["cancel"], false); ?>

		    <?php endif; ?>
	    </td>
	</tr>

	<?php if($pos_settings['disable_discount'] == 0): ?>
		<tr>
		    <td><?php echo app('translator')->get('sale.edit_discount'); ?>:</td>
		    <td>
		    	<?php if(!empty($shortcuts["pos"]["edit_discount"])): ?>
			    	<?php echo e($shortcuts["pos"]["edit_discount"], false); ?>

			    <?php endif; ?>
		    </td>
		</tr>
	<?php endif; ?>

	<?php if($pos_settings['disable_order_tax'] == 0): ?>
		<tr>
		    <td><?php echo app('translator')->get('sale.edit_order_tax'); ?>:</td>
		    <td>
		    	<?php if(!empty($shortcuts["pos"]["edit_order_tax"])): ?>
			    	<?php echo e($shortcuts["pos"]["edit_order_tax"], false); ?>

			    <?php endif; ?>
		    </td>
		</tr>
	<?php endif; ?>

	<?php if($pos_settings['disable_pay_checkout'] == 0): ?>
		<tr>
		    <td><?php echo app('translator')->get('sale.add_payment_row'); ?>:</td>
		    <td>
		    	<?php if(!empty($shortcuts["pos"]["add_payment_row"])): ?>
			    	<?php echo e($shortcuts["pos"]["add_payment_row"], false); ?>

			    <?php endif; ?>
		    </td>
		</tr>
	<?php endif; ?>

	<?php if($pos_settings['disable_pay_checkout'] == 0): ?>
		<tr>
		    <td><?php echo app('translator')->get('sale.finalize_payment'); ?>:</td>
		    <td>
		    	<?php if(!empty($shortcuts["pos"]["finalize_payment"])): ?>
			    	<?php echo e($shortcuts["pos"]["finalize_payment"], false); ?>

			    <?php endif; ?>
		    </td>
		</tr>
	<?php endif; ?>
	
	<tr>
	    <td><?php echo app('translator')->get('lang_v1.recent_product_quantity'); ?>:</td>
	    <td>
	    	<?php if(!empty($shortcuts["pos"]["recent_product_quantity"])): ?>
		    	<?php echo e($shortcuts["pos"]["recent_product_quantity"], false); ?>

		    <?php endif; ?>
	    </td>
	</tr>

	<tr>
	    <td><?php echo app('translator')->get('lang_v1.add_new_product'); ?>:</td>
	    <td>
	    	<?php if(!empty($shortcuts["pos"]["add_new_product"])): ?>
		    	<?php echo e($shortcuts["pos"]["add_new_product"], false); ?>

		    <?php endif; ?>
	    </td>
	</tr>
	
	<?php if(isset($pos_settings['enable_weighing_scale']) && $pos_settings['enable_weighing_scale'] == 1): ?>
		<tr>
		    <td><?php echo app('translator')->get('lang_v1.weighing_scale'); ?>:</td>
		    <td>
		    	<?php if(!empty($shortcuts["pos"]["weighing_scale"])): ?>
			    	<?php echo e($shortcuts["pos"]["weighing_scale"], false); ?>

			    <?php endif; ?>
		    </td>
		</tr>
	<?php endif; ?>
	
</table><?php /**PATH E:\xampp8.2\htdocs\UltimatePOS\resources\views/sale_pos/partials/keyboard_shortcuts_details.blade.php ENDPATH**/ ?>