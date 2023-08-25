<div class="row pos_form_totals">
	<div class="col-md-12">
		<table class="table table-condensed">
			<tr>
				<td><b><?php echo app('translator')->get('sale.item'); ?>:</b>&nbsp;
					<span class="total_quantity">0</span></td>
				<td>
					<b><?php echo app('translator')->get('sale.total'); ?>:</b> &nbsp;
					<span class="price_total">0</span>
				</td>
			</tr>
			<tr>
				<td>
					<b>
						<?php if($is_discount_enabled): ?>
							<?php echo app('translator')->get('sale.discount'); ?>
							<?php
                if(session('business.enable_tooltip')){
                    echo '<i class="fa fa-info-circle text-info hover-q no-print " aria-hidden="true" 
                    data-container="body" data-toggle="popover" data-placement="auto bottom" 
                    data-content="' . __('tooltip.sale_discount') . '" data-html="true" data-trigger="hover"></i>';
                }
                ?>
						<?php endif; ?>
						<?php if($is_rp_enabled): ?>
							<?php echo e(session('business.rp_name'), false); ?>

						<?php endif; ?>
						<?php if($is_discount_enabled): ?>
							(-):
							<?php if($edit_discount): ?>
							<i class="fas fa-edit cursor-pointer" id="pos-edit-discount" title="<?php echo app('translator')->get('sale.edit_discount'); ?>" aria-hidden="true" data-toggle="modal" data-target="#posEditDiscountModal"></i>
							<?php endif; ?>
						
							<span id="total_discount">0</span>
						<?php endif; ?>
							<input type="hidden" name="discount_type" id="discount_type" value="<?php if(empty($edit)): ?><?php echo e('percentage', false); ?><?php else: ?><?php echo e($transaction->discount_type, false); ?><?php endif; ?>" data-default="percentage">

							<input type="hidden" name="discount_amount" id="discount_amount" value="<?php if(empty($edit)): ?> <?php echo e(number_format($business_details->default_sales_discount, session('business.currency_precision', 2), session('currency')['decimal_separator'], session('currency')['thousand_separator']), false); ?> <?php else: ?> <?php echo e(number_format($transaction->discount_amount, session('business.currency_precision', 2), session('currency')['decimal_separator'], session('currency')['thousand_separator']), false); ?> <?php endif; ?>" data-default="<?php echo e($business_details->default_sales_discount, false); ?>">

							<input type="hidden" name="rp_redeemed" id="rp_redeemed" value="<?php if(empty($edit)): ?><?php echo e('0', false); ?><?php else: ?><?php echo e($transaction->rp_redeemed, false); ?><?php endif; ?>">

							<input type="hidden" name="rp_redeemed_amount" id="rp_redeemed_amount" value="<?php if(empty($edit)): ?><?php echo e('0', false); ?><?php else: ?> <?php echo e($transaction->rp_redeemed_amount, false); ?> <?php endif; ?>">

							</span>
					</b> 
				</td>
				<td class="<?php if($pos_settings['disable_order_tax'] != 0): ?> hide <?php endif; ?>">
					<span>
						<b><?php echo app('translator')->get('sale.order_tax'); ?>(+): <?php
                if(session('business.enable_tooltip')){
                    echo '<i class="fa fa-info-circle text-info hover-q no-print " aria-hidden="true" 
                    data-container="body" data-toggle="popover" data-placement="auto bottom" 
                    data-content="' . __('tooltip.sale_tax') . '" data-html="true" data-trigger="hover"></i>';
                }
                ?></b>
						<i class="fas fa-edit cursor-pointer" title="<?php echo app('translator')->get('sale.edit_order_tax'); ?>" aria-hidden="true" data-toggle="modal" data-target="#posEditOrderTaxModal" id="pos-edit-tax" ></i> 
						<span id="order_tax">
							<?php if(empty($edit)): ?>
								0
							<?php else: ?>
								<?php echo e($transaction->tax_amount, false); ?>

							<?php endif; ?>
						</span>

						<input type="hidden" name="tax_rate_id" 
							id="tax_rate_id" 
							value="<?php if(empty($edit)): ?> <?php echo e($business_details->default_sales_tax, false); ?> <?php else: ?> <?php echo e($transaction->tax_id, false); ?> <?php endif; ?>" 
							data-default="<?php echo e($business_details->default_sales_tax, false); ?>">

						<input type="hidden" name="tax_calculation_amount" id="tax_calculation_amount" 
							value="<?php if(empty($edit)): ?> <?php echo e(number_format($business_details->tax_calculation_amount, session('business.currency_precision', 2), session('currency')['decimal_separator'], session('currency')['thousand_separator']), false); ?> <?php else: ?> <?php echo e(number_format($transaction->tax?->amount, session('business.currency_precision', 2), session('currency')['decimal_separator'], session('currency')['thousand_separator']), false); ?> <?php endif; ?>" data-default="<?php echo e($business_details->tax_calculation_amount, false); ?>">

					</span>
				</td>
				<td>
					<span>

						<b><?php echo app('translator')->get('sale.shipping'); ?>(+): <?php
                if(session('business.enable_tooltip')){
                    echo '<i class="fa fa-info-circle text-info hover-q no-print " aria-hidden="true" 
                    data-container="body" data-toggle="popover" data-placement="auto bottom" 
                    data-content="' . __('tooltip.shipping') . '" data-html="true" data-trigger="hover"></i>';
                }
                ?></b> 
						<i class="fas fa-edit cursor-pointer"  title="<?php echo app('translator')->get('sale.shipping'); ?>" aria-hidden="true" data-toggle="modal" data-target="#posShippingModal"></i>
						<span id="shipping_charges_amount">0</span>
						<input type="hidden" name="shipping_details" id="shipping_details" value="<?php if(empty($edit)): ?><?php echo e('', false); ?><?php else: ?><?php echo e($transaction->shipping_details, false); ?><?php endif; ?>" data-default="">

						<input type="hidden" name="shipping_address" id="shipping_address" value="<?php if(empty($edit)): ?><?php echo e('', false); ?><?php else: ?><?php echo e($transaction->shipping_address, false); ?><?php endif; ?>">

						<input type="hidden" name="shipping_status" id="shipping_status" value="<?php if(empty($edit)): ?><?php echo e('', false); ?><?php else: ?><?php echo e($transaction->shipping_status, false); ?><?php endif; ?>">

						<input type="hidden" name="delivered_to" id="delivered_to" value="<?php if(empty($edit)): ?><?php echo e('', false); ?><?php else: ?><?php echo e($transaction->delivered_to, false); ?><?php endif; ?>">

						<input type="hidden" name="shipping_charges" id="shipping_charges" value="<?php if(empty($edit)): ?><?php echo e(number_format(0.00, session('business.currency_precision', 2), session('currency')['decimal_separator'], session('currency')['thousand_separator']), false); ?> <?php else: ?><?php echo e(number_format($transaction->shipping_charges, session('business.currency_precision', 2), session('currency')['decimal_separator'], session('currency')['thousand_separator']), false); ?> <?php endif; ?>" data-default="0.00">
					</span>
				</td>
				<?php if(in_array('types_of_service', $enabled_modules)): ?>
					<td class="col-sm-3 col-xs-6 d-inline-table">
						<b><?php echo app('translator')->get('lang_v1.packing_charge'); ?>(+):</b>
						<i class="fas fa-edit cursor-pointer service_modal_btn"></i> 
						<span id="packing_charge_text">
							0
						</span>
					</td>
				<?php endif; ?>
				<?php if(!empty($pos_settings['amount_rounding_method']) && $pos_settings['amount_rounding_method'] > 0): ?>
				<td>
					<b id="round_off"><?php echo app('translator')->get('lang_v1.round_off'); ?>:</b> <span id="round_off_text">0</span>								
					<input type="hidden" name="round_off_amount" id="round_off_amount" value=0>
				</td>
				<?php endif; ?>
			</tr>
		</table>
	</div>
</div><?php /**PATH E:\xampp8.2\htdocs\UltimatePOS\resources\views/sale_pos/partials/pos_form_totals.blade.php ENDPATH**/ ?>