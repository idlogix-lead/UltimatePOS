<div class="row">
	<input type="hidden" class="payment_row_index" value="<?php echo e($row_index, false); ?>">
	<?php
		$col_class = 'col-md-6';
		if(!empty($accounts)){
			$col_class = 'col-md-4';
		}
		$readonly = $payment_line['method'] == 'advance' ? true : false;
	?>
	<div class="<?php echo e($col_class, false); ?>">
		<div class="form-group">
			<?php echo Form::label("amount_$row_index" ,__('sale.amount') . ':*'); ?>

			<div class="input-group">
				<span class="input-group-addon">
					<i class="fas fa-money-bill-alt"></i>
				</span>
				<?php echo Form::text("payment[$row_index][amount]", number_format($payment_line['amount'], session('business.currency_precision', 2), session('currency')['decimal_separator'], session('currency')['thousand_separator']), ['class' => 'form-control payment-amount input_number', 'required', 'id' => "amount_$row_index", 'placeholder' => __('sale.amount'), 'readonly' => $readonly]); ?>

			</div>
		</div>
	</div>
	<?php if(!empty($show_date)): ?>
	<div class="<?php echo e($col_class, false); ?>">
		<div class="form-group">
			<?php echo Form::label("paid_on_$row_index" , __('lang_v1.paid_on') . ':*'); ?>

			<div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </span>
              <?php echo Form::text("payment[$row_index][paid_on]", isset($payment_line['paid_on']) ? \Carbon::createFromTimestamp(strtotime($payment_line['paid_on']))->format(session('business.date_format') . ' ' . 'h:i A') : \Carbon::createFromTimestamp(strtotime('now'))->format(session('business.date_format') . ' ' . 'h:i A'), ['class' => 'form-control paid_on', 'readonly', 'required']); ?>

            </div>
		</div>
	</div>
	<?php endif; ?>
	<div class="<?php echo e($col_class, false); ?>">
		<div class="form-group">
			<?php echo Form::label("method_$row_index" , __('lang_v1.payment_method') . ':*'); ?>

			<div class="input-group">
				<span class="input-group-addon">
					<i class="fas fa-money-bill-alt"></i>
				</span>
				<?php
					$_payment_method = empty($payment_line['method']) && array_key_exists('cash', $payment_types) ? 'cash' : $payment_line['method'];
				?>
				<?php echo Form::select("payment[$row_index][method]", $payment_types, $_payment_method, ['class' => 'form-control col-md-12 payment_types_dropdown', 'required', 'id' => !$readonly ? "method_$row_index" : "method_advance_$row_index", 'style' => 'width:100%;', 'disabled' => $readonly]); ?>


				<?php if($readonly): ?>
					<?php echo Form::hidden("payment[$row_index][method]", $payment_line['method'], ['class' => 'payment_types_dropdown', 'required', 'id' => "method_$row_index"]); ?>

				<?php endif; ?>
			</div>
		</div>
	</div>

	<?php
            $pos_settings = !empty(session()->get('business.pos_settings')) ? json_decode(session()->get('business.pos_settings'), true) : [];
            $enable_cash_denomination_for_payment_methods = !empty($pos_settings['enable_cash_denomination_for_payment_methods']) ? $pos_settings['enable_cash_denomination_for_payment_methods'] : [];
        ?>

        <?php if(!empty($pos_settings['enable_cash_denomination_on']) && $pos_settings['enable_cash_denomination_on'] == 'all_screens' && !empty($show_denomination)): ?>
            <input type="hidden" class="enable_cash_denomination_for_payment_methods" value="<?php echo e(json_encode($enable_cash_denomination_for_payment_methods), false); ?>">
            <div class="clearfix"></div>
            <div class="col-md-12 cash_denomination_div <?php if(!in_array($payment_line['method'], $enable_cash_denomination_for_payment_methods)): ?> hide <?php endif; ?>">
                <hr>
                <strong><?php echo app('translator')->get( 'lang_v1.cash_denominations' ); ?></strong>
                  <?php if(!empty($pos_settings['cash_denominations'])): ?>
                    <table class="table table-slim">
                      <thead>
                        <tr>
                          <th width="20%" class="text-right"><?php echo app('translator')->get('lang_v1.denomination'); ?></th>
                          <th width="20%">&nbsp;</th>
                          <th width="20%" class="text-center"><?php echo app('translator')->get('lang_v1.count'); ?></th>
                          <th width="20%">&nbsp;</th>
                          <th width="20%" class="text-left"><?php echo app('translator')->get('sale.subtotal'); ?></th>
                        </tr>
                      </thead>
                      <tbody>
                      	<?php
                            $total = 0;
                        ?>
                        <?php $__currentLoopData = explode(',', $pos_settings['cash_denominations']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dnm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $count = 0;
                            $sub_total = 0;
                            if(!empty($payment_line['denominations'])){
	                            foreach($payment_line['denominations'] as $d) {
	                                if($d['amount'] == $dnm) {
	                                    $count = $d['total_count']; 
	                                    $sub_total = $d['total_count'] * $d['amount'];
	                                    $total += $sub_total;
	                                }
	                            }
	                        }
                        ?>
                        <tr>
                          <td class="text-right"><?php echo e($dnm, false); ?></td>
                          <td class="text-center" >X</td>
                          <td><?php echo Form::number("payment[$row_index][denominations][$dnm]", $count, ['class' => 'form-control cash_denomination input-sm', 'min' => 0, 'data-denomination' => $dnm, 'style' => 'width: 100px; margin:auto;' ]); ?></td>
                          <td class="text-center">=</td>
                          <td class="text-left">
                            <span class="denomination_subtotal"><?php echo e(number_format($sub_total, session('business.currency_precision', 2), session('currency')['decimal_separator'], session('currency')['thousand_separator']), false); ?></span>
                          </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </tbody>
                      <tfoot>
                        <tr>
                          <th colspan="4" class="text-center"><?php echo app('translator')->get('sale.total'); ?></th>
                          <td>
                            <span class="denomination_total"><?php echo e(number_format($total, session('business.currency_precision', 2), session('currency')['decimal_separator'], session('currency')['thousand_separator']), false); ?></span>
                            <input type="hidden" class="denomination_total_amount" value="<?php echo e($total, false); ?>">
                            <input type="hidden" class="is_strict" value="<?php echo e($pos_settings['cash_denomination_strict_check'] ?? '', false); ?>">
                          </td>
                        </tr>
                      </tfoot>
                    </table>
                    <p class="cash_denomination_error error hide"><?php echo app('translator')->get('lang_v1.cash_denomination_error'); ?></p>
                  <?php else: ?>
                    <p class="help-block"><?php echo app('translator')->get('lang_v1.denomination_add_help_text'); ?></p>
                  <?php endif; ?>
            </div>
            <div class="clearfix"></div>
        <?php endif; ?>
	<?php if(!empty($accounts)): ?>
		<div class="<?php echo e($col_class, false); ?>">
			<div class="form-group <?php if($readonly): ?> hide <?php endif; ?>">
				<?php echo Form::label("account_$row_index" , __('lang_v1.payment_account') . ':'); ?>

				<div class="input-group">
					<span class="input-group-addon">
						<i class="fas fa-money-bill-alt"></i>
					</span>
					<?php echo Form::select("payment[$row_index][account_id]", $accounts, !empty($payment_line['account_id']) ? $payment_line['account_id'] : '' , ['class' => 'form-control select2 account-dropdown', 'id' => !$readonly ? "account_$row_index" : "account_advance_$row_index", 'style' => 'width:100%;', 'disabled' => $readonly]); ?>

				</div>
			</div>
		</div>
	<?php endif; ?>
	<div class="clearfix"></div>
		<?php echo $__env->make('sale_pos.partials.payment_type_details', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<div class="col-md-12">
		<div class="form-group">
			<?php echo Form::label("note_$row_index", __('sale.payment_note') . ':'); ?>

			<?php echo Form::textarea("payment[$row_index][note]", $payment_line['note'], ['class' => 'form-control', 'rows' => 3, 'id' => "note_$row_index"]); ?>

		</div>
	</div>
</div><?php /**PATH E:\xampp8.2\htdocs\UltimatePOS\resources\views/sale_pos/partials/payment_row_form.blade.php ENDPATH**/ ?>