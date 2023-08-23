<!-- Edit discount Modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="recurringInvoiceModal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><?php echo app('translator')->get('lang_v1.subscribe'); ?> <?php if(!empty($transaction->subscription_no)): ?> - <?php echo e($transaction->subscription_no, false); ?> <?php endif; ?></h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-6">
				        <div class="form-group">
				        	<?php echo Form::label('recur_interval', __('lang_v1.subscription_interval') . ':*' ); ?>

				        	<div class="input-group">
				               <?php echo Form::number('recur_interval', !empty($transaction->recur_interval) ? $transaction->recur_interval : null, ['class' => 'form-control', 'required', 'style' => 'width: 50%;']); ?>

				               
				                <?php echo Form::select('recur_interval_type', ['days' => __('lang_v1.days'), 'months' => __('lang_v1.months'), 'years' => __('lang_v1.years')], !empty($transaction->recur_interval_type) ? $transaction->recur_interval_type : 'days', ['class' => 'form-control', 'required', 'style' => 'width: 50%;', 'id' => 'recur_interval_type']); ?>

				                
				            </div>
				        </div>
				    </div>

				    <div class="col-md-6">
				        <div class="form-group">
				        	<?php echo Form::label('recur_repetitions', __('lang_v1.no_of_repetitions') . ':' ); ?>

				        	<?php echo Form::number('recur_repetitions', !empty($transaction->recur_repetitions) ? $transaction->recur_repetitions : null, ['class' => 'form-control']); ?>

					        <p class="help-block"><?php echo app('translator')->get('lang_v1.recur_repetition_help'); ?></p>
				        </div>
				    </div>
				    <?php
				    	$repetitions = [];
				    	for ($i=1; $i <= 30; $i++) { 
				    		$repetitions[$i] = str_ordinal($i);
				        }
				    ?>
				    <div class="subscription_repeat_on_div col-md-6 <?php if(empty($transaction->recur_interval_type)): ?> hide <?php elseif(!empty($transaction->recur_interval_type) && $transaction->recur_interval_type != 'months'): ?> hide <?php endif; ?>">
				        <div class="form-group">
				        	<?php echo Form::label('subscription_repeat_on', __('lang_v1.repeat_on') . ':' ); ?>

				        	<?php echo Form::select('subscription_repeat_on', $repetitions, !empty($transaction->subscription_repeat_on) ? $transaction->subscription_repeat_on : null, ['class' => 'form-control', 'placeholder' => __('messages.please_select')]); ?>

				        </div>
				    </div>

				</div>
			</div>
			<div class="modal-footer">
			    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo app('translator')->get('messages.close'); ?></button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal --><?php /**PATH E:\xampp8.2\htdocs\UltimatePOS\resources\views/sale_pos/partials/recurring_invoice_modal.blade.php ENDPATH**/ ?>