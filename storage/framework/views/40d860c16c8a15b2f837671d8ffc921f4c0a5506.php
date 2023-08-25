<?php
	$is_mobile = isMobile();
?>
<div class="row">
	<div class="pos-form-actions">
		<div class="col-md-12">
			<?php if($is_mobile): ?>
				<div class="col-md-12 text-right">
					<b><?php echo app('translator')->get('sale.total_payable'); ?>:</b>
					<input type="hidden" name="final_total" 
												id="final_total_input" value=0>
					<span id="total_payable" class="text-success lead text-bold text-right">0</span>
				</div>
			<?php endif; ?>
			<button type="button" class="<?php if($is_mobile): ?> col-xs-6 <?php endif; ?> btn bg-info text-white btn-default btn-flat <?php if($pos_settings['disable_draft'] != 0): ?> hide <?php endif; ?>" id="pos-draft" <?php if(!empty($only_payment)): ?> disabled <?php endif; ?>><i class="fas fa-edit"></i> <?php echo app('translator')->get('sale.draft'); ?></button>
			<button type="button" class="btn btn-default bg-yellow btn-flat <?php if($is_mobile): ?> col-xs-6 <?php endif; ?>" id="pos-quotation" <?php if(!empty($only_payment)): ?> disabled <?php endif; ?>><i class="fas fa-edit"></i> <?php echo app('translator')->get('lang_v1.quotation'); ?></button>

			<?php if(empty($pos_settings['disable_suspend'])): ?>
				<button type="button" 
				class="<?php if($is_mobile): ?> col-xs-6 <?php endif; ?> btn bg-red btn-default btn-flat no-print pos-express-finalize" 
				data-pay_method="suspend"
				title="<?php echo app('translator')->get('lang_v1.tooltip_suspend'); ?>" <?php if(!empty($only_payment)): ?> disabled <?php endif; ?>>
				<i class="fas fa-pause" aria-hidden="true"></i>
				<?php echo app('translator')->get('lang_v1.suspend'); ?>
				</button>
			<?php endif; ?>

			<?php if(empty($pos_settings['disable_credit_sale_button'])): ?>
				<input type="hidden" name="is_credit_sale" value="0" id="is_credit_sale">
				<button type="button" 
				class="btn bg-purple btn-default btn-flat no-print pos-express-finalize <?php if($is_mobile): ?> col-xs-6 <?php endif; ?>" 
				data-pay_method="credit_sale"
				title="<?php echo app('translator')->get('lang_v1.tooltip_credit_sale'); ?>" <?php if(!empty($only_payment)): ?> disabled <?php endif; ?>>
					<i class="fas fa-check" aria-hidden="true"></i> <?php echo app('translator')->get('lang_v1.credit_sale'); ?>
				</button>
			<?php endif; ?>
			<button type="button" 
				class="btn bg-maroon btn-default btn-flat no-print <?php if(!empty($pos_settings['disable_suspend'])): ?> <?php endif; ?> pos-express-finalize <?php if(!array_key_exists('card', $payment_types)): ?> hide <?php endif; ?> <?php if($is_mobile): ?> col-xs-6 <?php endif; ?>" 
				data-pay_method="card"
				title="<?php echo app('translator')->get('lang_v1.tooltip_express_checkout_card'); ?>" >
				<i class="fas fa-credit-card" aria-hidden="true"></i> <?php echo app('translator')->get('lang_v1.express_checkout_card'); ?>
			</button>

			<button type="button" class="btn bg-navy btn-default <?php if(!$is_mobile): ?> <?php endif; ?> btn-flat no-print <?php if($pos_settings['disable_pay_checkout'] != 0): ?> hide <?php endif; ?> <?php if($is_mobile): ?> col-xs-6 <?php endif; ?>" id="pos-finalize" title="<?php echo app('translator')->get('lang_v1.tooltip_checkout_multi_pay'); ?>"><i class="fas fa-money-check-alt" aria-hidden="true"></i> <?php echo app('translator')->get('lang_v1.checkout_multi_pay'); ?> </button>

			<button type="button" class="btn btn-success <?php if(!$is_mobile): ?> <?php endif; ?> btn-flat no-print <?php if($pos_settings['disable_express_checkout'] != 0 || !array_key_exists('cash', $payment_types)): ?> hide <?php endif; ?> pos-express-finalize <?php if($is_mobile): ?> col-xs-6 <?php endif; ?>" data-pay_method="cash" title="<?php echo app('translator')->get('tooltip.express_checkout'); ?>"> <i class="fas fa-money-bill-alt" aria-hidden="true"></i> <?php echo app('translator')->get('lang_v1.express_checkout_cash'); ?></button>

			<?php if(empty($edit)): ?>
				<button type="button" class="btn btn-danger btn-flat <?php if($is_mobile): ?> col-xs-6 <?php else: ?> btn-xs <?php endif; ?>" id="pos-cancel"> <i class="fas fa-window-close"></i> <?php echo app('translator')->get('sale.cancel'); ?></button>
			<?php else: ?>
				<button type="button" class="btn btn-danger btn-flat hide <?php if($is_mobile): ?> col-xs-6 <?php else: ?> btn-xs <?php endif; ?>" id="pos-delete" <?php if(!empty($only_payment)): ?> disabled <?php endif; ?>> <i class="fas fa-trash-alt"></i> <?php echo app('translator')->get('messages.delete'); ?></button>
			<?php endif; ?>

			<?php if(!$is_mobile): ?>
			<div class="bg-navy pos-total text-white">
			<span class="text"><?php echo app('translator')->get('sale.total_payable'); ?></span>
			<input type="hidden" name="final_total" 
										id="final_total_input" value=0>
			<span id="total_payable" class="number">0</span>
			</div>
			<?php endif; ?>

			<?php if(!isset($pos_settings['hide_recent_trans']) || $pos_settings['hide_recent_trans'] == 0): ?>
			<button type="button" class="pull-right btn btn-primary btn-flat <?php if($is_mobile): ?> col-xs-6 <?php endif; ?>" data-toggle="modal" data-target="#recent_transactions_modal" id="recent-transactions"> <i class="fas fa-clock"></i> <?php echo app('translator')->get('lang_v1.recent_transactions'); ?></button>
			<?php endif; ?>

			
			
		</div>
	</div>
</div>
<?php if(isset($transaction)): ?>
	<?php echo $__env->make('sale_pos.partials.edit_discount_modal', ['sales_discount' => $transaction->discount_amount, 'discount_type' => $transaction->discount_type, 'rp_redeemed' => $transaction->rp_redeemed, 'rp_redeemed_amount' => $transaction->rp_redeemed_amount, 'max_available' => !empty($redeem_details['points']) ? $redeem_details['points'] : 0], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php else: ?>
	<?php echo $__env->make('sale_pos.partials.edit_discount_modal', ['sales_discount' => $business_details->default_sales_discount, 'discount_type' => 'percentage', 'rp_redeemed' => 0, 'rp_redeemed_amount' => 0, 'max_available' => 0], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>

<?php if(isset($transaction)): ?>
	<?php echo $__env->make('sale_pos.partials.edit_order_tax_modal', ['selected_tax' => $transaction->tax_id], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php else: ?>
	<?php echo $__env->make('sale_pos.partials.edit_order_tax_modal', ['selected_tax' => $business_details->default_sales_tax], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>

<?php echo $__env->make('sale_pos.partials.edit_shipping_modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp8.2\htdocs\UltimatePOS\resources\views/sale_pos/partials/pos_form_actions.blade.php ENDPATH**/ ?>