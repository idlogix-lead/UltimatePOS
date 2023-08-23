<div class="payment_details_div <?php if( $payment_line['method'] !== 'card' ): ?> <?php echo e('hide', false); ?> <?php endif; ?>" data-type="card" >
	<div class="col-md-4">
		<div class="form-group">
			<?php echo Form::label("card_number_$row_index", __('lang_v1.card_no')); ?>

			<?php echo Form::text("payment[$row_index][card_number]", $payment_line['card_number'], ['class' => 'form-control', 'placeholder' => __('lang_v1.card_no'), 'id' => "card_number_$row_index"]); ?>

		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<?php echo Form::label("card_holder_name_$row_index", __('lang_v1.card_holder_name')); ?>

			<?php echo Form::text("payment[$row_index][card_holder_name]", $payment_line['card_holder_name'], ['class' => 'form-control', 'placeholder' => __('lang_v1.card_holder_name'), 'id' => "card_holder_name_$row_index"]); ?>

		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<?php echo Form::label("card_transaction_number_$row_index",__('lang_v1.card_transaction_no')); ?>

			<?php echo Form::text("payment[$row_index][card_transaction_number]", $payment_line['card_transaction_number'], ['class' => 'form-control', 'placeholder' => __('lang_v1.card_transaction_no'), 'id' => "card_transaction_number_$row_index"]); ?>

		</div>
	</div>
	<div class="clearfix"></div>
	<div class="col-md-3">
		<div class="form-group">
			<?php echo Form::label("card_type_$row_index", __('lang_v1.card_type')); ?>

			<?php echo Form::select("payment[$row_index][card_type]", ['credit' => 'Credit Card', 'debit' => 'Debit Card','visa' => 'Visa', 'master' => 'MasterCard'], $payment_line['card_type'],['class' => 'form-control', 'id' => "card_type_$row_index" ]); ?>

		</div>
	</div>
	<div class="col-md-3">
		<div class="form-group">
			<?php echo Form::label("card_month_$row_index", __('lang_v1.month')); ?>

			<?php echo Form::text("payment[$row_index][card_month]", $payment_line['card_month'], ['class' => 'form-control', 'placeholder' => __('lang_v1.month'),
			'id' => "card_month_$row_index" ]); ?>

		</div>
	</div>
	<div class="col-md-3">
		<div class="form-group">
			<?php echo Form::label("card_year_$row_index", __('lang_v1.year')); ?>

			<?php echo Form::text("payment[$row_index][card_year]", $payment_line['card_year'], ['class' => 'form-control', 'placeholder' => __('lang_v1.year'), 'id' => "card_year_$row_index" ]); ?>

		</div>
	</div>
	<div class="col-md-3">
		<div class="form-group">
			<?php echo Form::label("card_security_$row_index",__('lang_v1.security_code')); ?>

			<?php echo Form::text("payment[$row_index][card_security]", $payment_line['card_security'], ['class' => 'form-control', 'placeholder' => __('lang_v1.security_code'), 'id' => "card_security_$row_index"]); ?>

		</div>
	</div>
	<div class="clearfix"></div>
</div>
<div class="payment_details_div <?php if( $payment_line['method'] !== 'cheque' ): ?> <?php echo e('hide', false); ?> <?php endif; ?>" data-type="cheque" >
	<div class="col-md-12">
		<div class="form-group">
			<?php echo Form::label("cheque_number_$row_index",__('lang_v1.cheque_no')); ?>

			<?php echo Form::text("payment[$row_index][cheque_number]", $payment_line['cheque_number'], ['class' => 'form-control', 'placeholder' => __('lang_v1.cheque_no'), 'id' => "cheque_number_$row_index"]); ?>

		</div>
	</div>
</div>
<div class="payment_details_div <?php if( $payment_line['method'] !== 'bank_transfer' ): ?> <?php echo e('hide', false); ?> <?php endif; ?>" data-type="bank_transfer" >
	<div class="col-md-12">
		<div class="form-group">
			<?php echo Form::label("bank_account_number_$row_index",__('lang_v1.bank_account_number')); ?>

			<?php echo Form::text( "payment[$row_index][bank_account_number]", $payment_line['bank_account_number'], ['class' => 'form-control', 'placeholder' => __('lang_v1.bank_account_number'), 'id' => "bank_account_number_$row_index"]); ?>

		</div>
	</div>
</div>

<?php for($i = 1; $i < 8; $i++): ?>
<div class="payment_details_div <?php if( $payment_line['method'] !== 'custom_pay_' . $i ): ?> <?php echo e('hide', false); ?> <?php endif; ?>" data-type="custom_pay_<?php echo e($i, false); ?>" >
	<div class="col-md-12">
		<div class="form-group">
			<?php echo Form::label("transaction_no_{$i}_{$row_index}", __('lang_v1.transaction_no')); ?>

			<?php echo Form::text("payment[$row_index][transaction_no_{$i}]", $payment_line['transaction_no'], ['class' => 'form-control', 'placeholder' => __('lang_v1.transaction_no'), 'id' => "transaction_no_{$i}_{$row_index}"]); ?>

		</div>
	</div>
</div>
<?php endfor; ?><?php /**PATH E:\xampp8.2\htdocs\UltimatePOS\resources\views/sale_pos/partials/payment_type_details.blade.php ENDPATH**/ ?>