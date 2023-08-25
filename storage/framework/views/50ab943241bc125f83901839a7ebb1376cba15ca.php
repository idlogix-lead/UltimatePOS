<div class="row">
	<div class="col-md-4">
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon">
					<i class="fa fa-user"></i>
				</span>
				<input type="hidden" id="default_customer_id" 
				value="<?php echo e($walk_in_customer['id'] ?? '', false); ?>" >
				<input type="hidden" id="default_customer_name" 
				value="<?php echo e($walk_in_customer['name'] ?? '', false); ?>" >
				<input type="hidden" id="default_customer_balance" 
				value="<?php echo e($walk_in_customer['balance'] ?? '', false); ?>" >
				<input type="hidden" id="default_customer_address" 
				value="<?php echo e($walk_in_customer['shipping_address'] ?? '', false); ?>" >
				<?php if(!empty($walk_in_customer['price_calculation_type']) && $walk_in_customer['price_calculation_type'] == 'selling_price_group'): ?>
					<input type="hidden" id="default_selling_price_group" 
				value="<?php echo e($walk_in_customer['selling_price_group_id'] ?? '', false); ?>" >
				<?php endif; ?>
				<?php echo Form::select('contact_id', 
					[], null, ['class' => 'form-control mousetrap', 'id' => 'customer_id', 'placeholder' => 'Enter Customer name / phone', 'required']); ?>

				<span class="input-group-btn">
					<button type="button" class="btn btn-default bg-white btn-flat add_new_customer" data-name=""  <?php if(!auth()->user()->can('customer.create')): ?> disabled <?php endif; ?>><i class="fa fa-plus-circle text-primary fa-lg"></i></button>
				</span>
			</div>
			<small class="text-danger hide contact_due_text"><strong><?php echo app('translator')->get('account.customer_due'); ?>:</strong> <span></span></small>
		</div>
	</div>
	<div class="col-md-8">
		<div class="form-group">
			<div class="input-group">
				<div class="input-group-btn">
					<button type="button" class="btn btn-default bg-white btn-flat" data-toggle="modal" data-target="#configure_search_modal" title="<?php echo e(__('lang_v1.configure_product_search'), false); ?>"><i class="fas fa-search-plus"></i></button>
				</div>
                
				<?php echo Form::text('search_product', null, ['class' => 'form-control', 'id' => 'search_product', 'placeholder' => __('lang_v1.search_product_placeholder'),
				'disabled' => is_null($default_location)? true : false,
				'autofocus' => is_null($default_location)? false : true,
				]); ?>

				<span class="input-group-btn">

					<!-- Show button for weighing scale modal -->
					<?php if(isset($pos_settings['enable_weighing_scale']) && $pos_settings['enable_weighing_scale'] == 1): ?>
						<button type="button" class="btn btn-default bg-white btn-flat" id="weighing_scale_btn" data-toggle="modal" data-target="#weighing_scale_modal" 
						title="<?php echo app('translator')->get('lang_v1.weighing_scale'); ?>"><i class="fa fa-digital-tachograph text-primary fa-lg"></i></button>
					<?php endif; ?>
					

					<button type="button" class="btn btn-default bg-white btn-flat pos_add_quick_product" data-href="<?php echo e(action([\App\Http\Controllers\ProductController::class, 'quickAdd']), false); ?>" data-container=".quick_add_product_modal"><i class="fa fa-plus-circle text-primary fa-lg"></i></button>
				</span>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<?php if(!empty($pos_settings['show_invoice_layout'])): ?>
	<div class="col-md-4">
		<div class="form-group">
		<?php echo Form::select('invoice_layout_id', 
					$invoice_layouts, $default_location->invoice_layout_id, ['class' => 'form-control select2', 'placeholder' => __('lang_v1.select_invoice_layout'), 'id' => 'invoice_layout_id']); ?>

		</div>
	</div>
	<?php endif; ?>
	<input type="hidden" name="pay_term_number" id="pay_term_number" value="<?php echo e($walk_in_customer['pay_term_number'] ?? '', false); ?>">
	<input type="hidden" name="pay_term_type" id="pay_term_type" value="<?php echo e($walk_in_customer['pay_term_type'] ?? '', false); ?>">
	
	<?php if(!empty($commission_agent)): ?>
		<?php
			$is_commission_agent_required = !empty($pos_settings['is_commission_agent_required']);
		?>
		<div class="col-md-4">
			<div class="form-group">
			<?php echo Form::select('commission_agent', 
						$commission_agent, null, ['class' => 'form-control select2', 'placeholder' => __('lang_v1.commission_agent'), 'id' => 'commission_agent', 'required' => $is_commission_agent_required]); ?>

			</div>
		</div>
	<?php endif; ?>
	<?php if(!empty($pos_settings['enable_transaction_date'])): ?>
		<div class="col-md-4 col-sm-6">
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon">
						<i class="fa fa-calendar"></i>
					</span>
					<?php echo Form::text('transaction_date', $default_datetime, ['class' => 'form-control', 'readonly', 'required', 'id' => 'transaction_date']); ?>

				</div>
			</div>
		</div>
	<?php endif; ?>
	<?php if(config('constants.enable_sell_in_diff_currency') == true): ?>
		<div class="col-md-4 col-sm-6">
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon">
						<i class="fas fa-exchange-alt"></i>
					</span>
					<?php echo Form::text('exchange_rate', config('constants.currency_exchange_rate'), ['class' => 'form-control input-sm input_number', 'placeholder' => __('lang_v1.currency_exchange_rate'), 'id' => 'exchange_rate']); ?>

				</div>
			</div>
		</div>
	<?php endif; ?>
	<?php if(!empty($price_groups) && count($price_groups) > 1): ?>
		<div class="col-md-4 col-sm-6">
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon">
						<i class="fas fa-money-bill-alt"></i>
					</span>
					<?php
						reset($price_groups);
						$selected_price_group = !empty($default_price_group_id) && array_key_exists($default_price_group_id, $price_groups) ? $default_price_group_id : null;
					?>
					<?php echo Form::hidden('hidden_price_group', key($price_groups), ['id' => 'hidden_price_group']); ?>

					<?php echo Form::select('price_group', $price_groups, $selected_price_group, ['class' => 'form-control select2', 'id' => 'price_group']); ?>

					<span class="input-group-addon">
						<?php
                if(session('business.enable_tooltip')){
                    echo '<i class="fa fa-info-circle text-info hover-q no-print " aria-hidden="true" 
                    data-container="body" data-toggle="popover" data-placement="auto bottom" 
                    data-content="' . __('lang_v1.price_group_help_text') . '" data-html="true" data-trigger="hover"></i>';
                }
                ?>
					</span> 
				</div>
			</div>
		</div>
	<?php else: ?>
		<?php
			reset($price_groups);
		?>
		<?php echo Form::hidden('price_group', key($price_groups), ['id' => 'price_group']); ?>

	<?php endif; ?>
	<?php if(!empty($default_price_group_id)): ?>
		<?php echo Form::hidden('default_price_group', $default_price_group_id, ['id' => 'default_price_group']); ?>

	<?php endif; ?>

	<?php if(in_array('types_of_service', $enabled_modules) && !empty($types_of_service)): ?>
		<div class="col-md-4 col-sm-6">
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon">
						<i class="fa fa-external-link-square-alt text-primary service_modal_btn"></i>
					</span>
					<?php echo Form::select('types_of_service_id', $types_of_service, null, ['class' => 'form-control', 'id' => 'types_of_service_id', 'style' => 'width: 100%;', 'placeholder' => __('lang_v1.select_types_of_service')]); ?>


					<?php echo Form::hidden('types_of_service_price_group', null, ['id' => 'types_of_service_price_group']); ?>


					<span class="input-group-addon">
						<?php
                if(session('business.enable_tooltip')){
                    echo '<i class="fa fa-info-circle text-info hover-q no-print " aria-hidden="true" 
                    data-container="body" data-toggle="popover" data-placement="auto bottom" 
                    data-content="' . __('lang_v1.types_of_service_help') . '" data-html="true" data-trigger="hover"></i>';
                }
                ?>
					</span> 
				</div>
				<small><p class="help-block hide" id="price_group_text"><?php echo app('translator')->get('lang_v1.price_group'); ?>: <span></span></p></small>
			</div>
		</div>
		<div class="modal fade types_of_service_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel"></div>
	<?php endif; ?>

	<?php if(!empty($pos_settings['show_invoice_scheme'])): ?>
		<?php
			$invoice_scheme_id = $default_invoice_schemes->id;
			if(!empty($default_location->invoice_scheme_id)) {
				$invoice_scheme_id = $default_location->invoice_scheme_id;
			}
		?>
		<div class="col-md-4 col-sm-6">
			<div class="form-group">
				<?php echo Form::select('invoice_scheme_id', $invoice_schemes, $invoice_scheme_id, 
					['class' => 'form-control', 'placeholder' => __('lang_v1.select_invoice_scheme'), 
					'id' => 'invoice_scheme_id']); ?>

			</div>
		</div>
	<?php endif; ?>
	<?php if(in_array('subscription', $enabled_modules)): ?>
		<div class="col-md-4 col-sm-6">
			<label>
              <?php echo Form::checkbox('is_recurring', 1, false, ['class' => 'input-icheck', 'id' => 'is_recurring']); ?> <?php echo app('translator')->get('lang_v1.subscribe'); ?>?
            </label><button type="button" data-toggle="modal" data-target="#recurringInvoiceModal" class="btn btn-link"><i class="fa fa-external-link-square-alt"></i></button><?php
                if(session('business.enable_tooltip')){
                    echo '<i class="fa fa-info-circle text-info hover-q no-print " aria-hidden="true" 
                    data-container="body" data-toggle="popover" data-placement="auto bottom" 
                    data-content="' . __('lang_v1.recurring_invoice_help') . '" data-html="true" data-trigger="hover"></i>';
                }
                ?>
		</div>
	<?php endif; ?>
	<!-- Call restaurant module if defined -->
    <?php if(in_array('tables' ,$enabled_modules) || in_array('service_staff' ,$enabled_modules)): ?>
    	<div class="clearfix"></div>
    	<span id="restaurant_module_span">
      		<div class="col-md-3"></div>
    	</span>
    <?php endif; ?>
    
</div>
<!-- include module fields -->
<?php if(!empty($pos_module_data)): ?>
    <?php $__currentLoopData = $pos_module_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if(!empty($value['view_path'])): ?>
            <?php if ($__env->exists($value['view_path'], ['view_data' => $value['view_data']])) echo $__env->make($value['view_path'], ['view_data' => $value['view_data']], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>
<div class="row">
	<div class="col-sm-12 pos_product_div">
		<input type="hidden" name="sell_price_tax" id="sell_price_tax" value="<?php echo e($business_details->sell_price_tax, false); ?>">

		<!-- Keeps count of product rows -->
		<input type="hidden" id="product_row_count" 
			value="0">
		<?php
			$hide_tax = '';
			if( session()->get('business.enable_inline_tax') == 0){
				$hide_tax = 'hide';
			}
		?>
		<table class="table table-condensed table-bordered table-striped table-responsive" id="pos_table">
			<thead>
				<tr>
					<th class="tex-center <?php if(!empty($pos_settings['inline_service_staff'])): ?> col-md-3 <?php else: ?> col-md-4 <?php endif; ?>">	
						<?php echo app('translator')->get('sale.product'); ?> <?php
                if(session('business.enable_tooltip')){
                    echo '<i class="fa fa-info-circle text-info hover-q no-print " aria-hidden="true" 
                    data-container="body" data-toggle="popover" data-placement="auto bottom" 
                    data-content="' . __('lang_v1.tooltip_sell_product_column') . '" data-html="true" data-trigger="hover"></i>';
                }
                ?>
					</th>
					<th class="text-center col-md-3">
						<?php echo app('translator')->get('sale.qty'); ?>
					</th>
					<?php if(!empty($pos_settings['inline_service_staff'])): ?>
						<th class="text-center col-md-2">
							<?php echo app('translator')->get('restaurant.service_staff'); ?>
						</th>
					<?php endif; ?>
					<th class="text-center col-md-2 <?php echo e($hide_tax, false); ?>">
						<?php echo app('translator')->get('sale.price_inc_tax'); ?>
					</th>
					<th class="text-center col-md-2">
						<?php echo app('translator')->get('sale.subtotal'); ?>
					</th>
					<th class="text-center"><i class="fas fa-times" aria-hidden="true"></i></th>
				</tr>
			</thead>
			<tbody></tbody>
		</table>
	</div>
</div><?php /**PATH E:\xampp8.2\htdocs\UltimatePOS\resources\views/sale_pos/partials/pos_form.blade.php ENDPATH**/ ?>