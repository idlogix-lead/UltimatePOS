<!-- Edit discount Modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="posEditDiscountModal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">
					<?php if($is_discount_enabled): ?>
						<?php echo app('translator')->get('sale.discount'); ?>
					<?php endif; ?>
					<?php if($is_rp_enabled): ?>
						<?php echo e(session('business.rp_name'), false); ?>

					<?php endif; ?>
				</h4>
			</div>
			<div class="modal-body">
				<div class="row <?php if(!$is_discount_enabled): ?> hide <?php endif; ?>">
					<div class="col-md-12">
						<h4 class="modal-title"><?php echo app('translator')->get('sale.edit_discount'); ?>:</h4>
					</div>
					<div class="col-md-6">
				        <div class="form-group">
				            <?php echo Form::label('discount_type_modal', __('sale.discount_type') . ':*' ); ?>

				            <div class="input-group">
				                <span class="input-group-addon">
				                    <i class="fa fa-info"></i>
				                </span>
				                <?php echo Form::select('discount_type_modal', ['fixed' => __('lang_v1.fixed'), 'percentage' => __('lang_v1.percentage')], $discount_type , ['class' => 'form-control','placeholder' => __('messages.please_select'), 'required']); ?>

				            </div>
				        </div>
				    </div>
				    <?php
				    	$max_discount = !is_null(auth()->user()->max_sales_discount_percent) ? auth()->user()->max_sales_discount_percent : '';

				    	//if sale discount is more than user max discount change it to max discount
				    	if($discount_type == 'percentage' && $max_discount != '' && $sales_discount > $max_discount) $sales_discount = $max_discount;
				    ?>
				    <div class="col-md-6">
				        <div class="form-group">
				            <?php echo Form::label('discount_amount_modal', __('sale.discount_amount') . ':*' ); ?>

				            <div class="input-group">
				                <span class="input-group-addon">
				                    <i class="fa fa-info"></i>
				                </span>
				                <?php echo Form::text('discount_amount_modal', number_format($sales_discount, session('business.currency_precision', 2), session('currency')['decimal_separator'], session('currency')['thousand_separator']), ['class' => 'form-control input_number', 'data-max-discount' => $max_discount, 'data-max-discount-error_msg' => __('lang_v1.max_discount_error_msg', ['discount' => $max_discount != '' ? number_format($max_discount, session('business.currency_precision', 2), session('currency')['decimal_separator'], session('currency')['thousand_separator']) : '']) ]); ?>

				            </div>
				        </div>
				    </div>
				</div>
				<br>
				<div class="row <?php if(!$is_rp_enabled): ?> hide <?php endif; ?>">
					<div class="well well-sm bg-light-gray col-md-12">
					<div class="col-md-12">
						<h4 class="modal-title"><?php echo e(session('business.rp_name'), false); ?>:</h4>
					</div>
					<div class="col-md-6">
				        <div class="form-group">
				            <?php echo Form::label('rp_redeemed_modal', __('lang_v1.redeemed') . ':' ); ?>

				            <div class="input-group">
				                <span class="input-group-addon">
				                    <i class="fa fa-gift"></i>
				                </span>
				                <?php echo Form::number('rp_redeemed_modal', $rp_redeemed, ['class' => 'form-control', 'data-amount_per_unit_point' => session('business.redeem_amount_per_unit_rp'), 'data-max_points' => $max_available, 'min' => 0, 'data-min_order_total' => session('business.min_order_total_for_redeem') ]); ?>

				                <input type="hidden" id="rp_name" value="<?php echo e(session('business.rp_name'), false); ?>">
				            </div>
				        </div>
				    </div>
				    <div class="col-md-6">
				    	<p><strong><?php echo app('translator')->get('lang_v1.available'); ?>:</strong> <span id="available_rp"><?php echo e($max_available, false); ?></span></p>
				    	<h5><strong><?php echo app('translator')->get('lang_v1.redeemed_amount'); ?>:</strong> <span id="rp_redeemed_amount_text"><?php echo e(number_format($rp_redeemed_amount, session('business.currency_precision', 2), session('currency')['decimal_separator'], session('currency')['thousand_separator']), false); ?></span></h5>
				    </div>
				    </div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="posEditDiscountModalUpdate"><?php echo app('translator')->get('messages.update'); ?></button>
			    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo app('translator')->get('messages.cancel'); ?></button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal --><?php /**PATH E:\xampp8.2\htdocs\UltimatePOS\resources\views/sale_pos/partials/edit_discount_modal.blade.php ENDPATH**/ ?>