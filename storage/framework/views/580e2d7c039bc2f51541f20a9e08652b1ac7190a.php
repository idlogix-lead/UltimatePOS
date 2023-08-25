<?php
	if (!empty($status) && $status == 'quotation') {
		$title = __('lang_v1.add_quotation');
	} else if (!empty($status) && $status == 'draft') {
		$title = __('lang_v1.add_draft');
	} else {
		$title = __('sale.add_sale');
	}

	if($sale_type == 'sales_order') {
		$title = __('lang_v1.sales_order');
	}
?>

<?php $__env->startSection('title', $title); ?>

<?php $__env->startSection('content'); ?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?php echo e($title, false); ?></h1>
</section>
<!-- Main content -->
<section class="content no-print">
<input type="hidden" id="amount_rounding_method" value="<?php echo e($pos_settings['amount_rounding_method'] ?? '', false); ?>">
<?php if(!empty($pos_settings['allow_overselling'])): ?>
	<input type="hidden" id="is_overselling_allowed">
<?php endif; ?>
<?php if(session('business.enable_rp') == 1): ?>
    <input type="hidden" id="reward_point_enabled">
<?php endif; ?>
<?php if(count($business_locations) > 0): ?>
<div class="row">
	<div class="col-sm-3">
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon">
					<i class="fa fa-map-marker"></i>
				</span>
			<?php echo Form::select('select_location_id', $business_locations, $default_location->id ?? null, ['class' => 'form-control input-sm',
			'id' => 'select_location_id', 
			'required', 'autofocus'], $bl_attributes); ?>

			<span class="input-group-addon">
					<?php
                if(session('business.enable_tooltip')){
                    echo '<i class="fa fa-info-circle text-info hover-q no-print " aria-hidden="true" 
                    data-container="body" data-toggle="popover" data-placement="auto bottom" 
                    data-content="' . __('tooltip.sale_location') . '" data-html="true" data-trigger="hover"></i>';
                }
                ?>
				</span> 
			</div>
		</div>
	</div>
</div>
<?php endif; ?>

<?php
	$custom_labels = json_decode(session('business.custom_labels'), true);
	$common_settings = session()->get('business.common_settings');
?>
<input type="hidden" id="item_addition_method" value="<?php echo e($business_details->item_addition_method, false); ?>">
	<?php echo Form::open(['url' => action([\App\Http\Controllers\SellPosController::class, 'store']), 'method' => 'post', 'id' => 'add_sell_form', 'files' => true ]); ?>

	 <?php if(!empty($sale_type)): ?>
	 	<input type="hidden" id="sale_type" name="type" value="<?php echo e($sale_type, false); ?>">
	 <?php endif; ?>
	<div class="row">
		<div class="col-md-12 col-sm-12">
			<?php $__env->startComponent('components.widget', ['class' => 'box-solid']); ?>
				<?php echo Form::hidden('location_id', !empty($default_location) ? $default_location->id : null , ['id' => 'location_id', 'data-receipt_printer_type' => !empty($default_location->receipt_printer_type) ? $default_location->receipt_printer_type : 'browser', 'data-default_payment_accounts' => !empty($default_location) ? $default_location->default_payment_accounts : '']); ?>


				<?php if(!empty($price_groups)): ?>
					<?php if(count($price_groups) > 1): ?>
						<div class="col-sm-4">
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
				<?php endif; ?>

				<?php echo Form::hidden('default_price_group', null, ['id' => 'default_price_group']); ?>


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
				
				<?php if(in_array('subscription', $enabled_modules)): ?>
					<div class="col-md-4 pull-right col-sm-6">
						<div class="checkbox">
							<label>
				              <?php echo Form::checkbox('is_recurring', 1, false, ['class' => 'input-icheck', 'id' => 'is_recurring']); ?> <?php echo app('translator')->get('lang_v1.subscribe'); ?>?
				            </label><button type="button" data-toggle="modal" data-target="#recurringInvoiceModal" class="btn btn-link"><i class="fa fa-external-link"></i></button><?php
                if(session('business.enable_tooltip')){
                    echo '<i class="fa fa-info-circle text-info hover-q no-print " aria-hidden="true" 
                    data-container="body" data-toggle="popover" data-placement="auto bottom" 
                    data-content="' . __('lang_v1.recurring_invoice_help') . '" data-html="true" data-trigger="hover"></i>';
                }
                ?>
						</div>
					</div>
				<?php endif; ?>
				<div class="clearfix"></div>
				<div class="<?php if(!empty($commission_agent)): ?> col-sm-3 <?php else: ?> col-sm-4 <?php endif; ?>">
					<div class="form-group">
						<?php echo Form::label('contact_id', __('contact.customer') . ':*'); ?>

						<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-user"></i>
							</span>
							<input type="hidden" id="default_customer_id" 
							value="<?php echo e($walk_in_customer['id'], false); ?>" >
							<input type="hidden" id="default_customer_name" 
							value="<?php echo e($walk_in_customer['name'], false); ?>" >
							<input type="hidden" id="default_customer_balance" value="<?php echo e($walk_in_customer['balance'] ?? '', false); ?>" >
							<input type="hidden" id="default_customer_address" value="<?php echo e($walk_in_customer['shipping_address'] ?? '', false); ?>" >
							<?php if(!empty($walk_in_customer['price_calculation_type']) && $walk_in_customer['price_calculation_type'] == 'selling_price_group'): ?>
								<input type="hidden" id="default_selling_price_group" 
							value="<?php echo e($walk_in_customer['selling_price_group_id'] ?? '', false); ?>" >
							<?php endif; ?>
							<?php echo Form::select('contact_id', 
								[], null, ['class' => 'form-control mousetrap', 'id' => 'customer_id', 'placeholder' => 'Enter Customer name / phone', 'required']); ?>

							<span class="input-group-btn">
								<button type="button" class="btn btn-default bg-white btn-flat add_new_customer" data-name=""><i class="fa fa-plus-circle text-primary fa-lg"></i></button>
							</span>
						</div>
						<small class="text-danger hide contact_due_text"><strong><?php echo app('translator')->get('account.customer_due'); ?>:</strong> <span></span></small>
					</div>
					<small>
					<strong>
						<?php echo app('translator')->get('lang_v1.billing_address'); ?>:
					</strong>
					<div id="billing_address_div">
						<?php echo $walk_in_customer['contact_address'] ?? ''; ?>

					</div>
					<br>
					<strong>
						<?php echo app('translator')->get('lang_v1.shipping_address'); ?>:
					</strong>
					<div id="shipping_address_div">
						<?php echo e($walk_in_customer['supplier_business_name'] ?? '', false); ?>,<br>
						<?php echo e($walk_in_customer['name'] ?? '', false); ?>,<br>
						<?php echo e($walk_in_customer['shipping_address'] ?? '', false); ?>

					</div>					
					</small>
				</div>

				<div class="col-md-3">
		          <div class="form-group">
		            <div class="multi-input">
		            <?php
						$is_pay_term_required = !empty($pos_settings['is_pay_term_required']);
					?>
		              <?php echo Form::label('pay_term_number', __('contact.pay_term') . ':'); ?> <?php
                if(session('business.enable_tooltip')){
                    echo '<i class="fa fa-info-circle text-info hover-q no-print " aria-hidden="true" 
                    data-container="body" data-toggle="popover" data-placement="auto bottom" 
                    data-content="' . __('tooltip.pay_term') . '" data-html="true" data-trigger="hover"></i>';
                }
                ?>
		              <br/>
		              <?php echo Form::number('pay_term_number', $walk_in_customer['pay_term_number'], ['class' => 'form-control width-40 pull-left', 'placeholder' => __('contact.pay_term'), 'required' => $is_pay_term_required]); ?>


		              <?php echo Form::select('pay_term_type', 
		              	['months' => __('lang_v1.months'), 
		              		'days' => __('lang_v1.days')], 
		              		$walk_in_customer['pay_term_type'], 
		              	['class' => 'form-control width-60 pull-left','placeholder' => __('messages.please_select'), 'required' => $is_pay_term_required]); ?>

		            </div>
		          </div>
		        </div>

				<?php if(!empty($commission_agent)): ?>
				<?php
					$is_commission_agent_required = !empty($pos_settings['is_commission_agent_required']);
				?>
				<div class="col-sm-3">
					<div class="form-group">
					<?php echo Form::label('commission_agent', __('lang_v1.commission_agent') . ':'); ?>

					<?php echo Form::select('commission_agent', 
								$commission_agent, null, ['class' => 'form-control select2', 'id' => 'commission_agent', 'required' => $is_commission_agent_required]); ?>

					</div>
				</div>
				<?php endif; ?>
				<div class="<?php if(!empty($commission_agent)): ?> col-sm-3 <?php else: ?> col-sm-4 <?php endif; ?>">
					<div class="form-group">
						<?php echo Form::label('transaction_date', __('sale.sale_date') . ':*'); ?>

						<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</span>
							<?php echo Form::text('transaction_date', $default_datetime, ['class' => 'form-control', 'readonly', 'required']); ?>

						</div>
					</div>
				</div>
				<?php if(!empty($status)): ?>
					<input type="hidden" name="status" id="status" value="<?php echo e($status, false); ?>">

					<?php if(in_array($status, ['draft', 'quotation'])): ?>
						<input type="hidden" id="disable_qty_alert">
					<?php endif; ?>
				<?php else: ?>
					<div class="<?php if(!empty($commission_agent)): ?> col-sm-3 <?php else: ?> col-sm-4 <?php endif; ?>">
						<div class="form-group">
							<?php echo Form::label('status', __('sale.status') . ':*'); ?>

							<?php echo Form::select('status', $statuses, null, ['class' => 'form-control select2', 'placeholder' => __('messages.please_select'), 'required']); ?>

						</div>
					</div>
				<?php endif; ?>
				<?php if($sale_type != 'sales_order'): ?>
					<div class="col-sm-3">
						<div class="form-group">
							<?php echo Form::label('invoice_scheme_id', __('invoice.invoice_scheme') . ':'); ?>

							<?php echo Form::select('invoice_scheme_id', $invoice_schemes, $default_invoice_schemes->id, ['class' => 'form-control select2', 'placeholder' => __('messages.please_select')]); ?>

						</div>
					</div>
				<?php endif; ?>
					<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit_invoice_number')): ?>
					<div class="col-sm-3">
						<div class="form-group">
							<?php echo Form::label('invoice_no', $sale_type == 'sales_order' ? __('restaurant.order_no') : __('sale.invoice_no') . ':'); ?>

							<?php echo Form::text('invoice_no', null, ['class' => 'form-control', 'placeholder' => $sale_type == 'sales_order' ? __('restaurant.order_no') : __('sale.invoice_no')]); ?>

							<p class="help-block"><?php echo app('translator')->get('lang_v1.keep_blank_to_autogenerate'); ?></p>
						</div>
					</div>
					<?php endif; ?>
				
				<?php
			        $custom_field_1_label = !empty($custom_labels['sell']['custom_field_1']) ? $custom_labels['sell']['custom_field_1'] : '';

			        $is_custom_field_1_required = !empty($custom_labels['sell']['is_custom_field_1_required']) && $custom_labels['sell']['is_custom_field_1_required'] == 1 ? true : false;

			        $custom_field_2_label = !empty($custom_labels['sell']['custom_field_2']) ? $custom_labels['sell']['custom_field_2'] : '';

			        $is_custom_field_2_required = !empty($custom_labels['sell']['is_custom_field_2_required']) && $custom_labels['sell']['is_custom_field_2_required'] == 1 ? true : false;

			        $custom_field_3_label = !empty($custom_labels['sell']['custom_field_3']) ? $custom_labels['sell']['custom_field_3'] : '';

			        $is_custom_field_3_required = !empty($custom_labels['sell']['is_custom_field_3_required']) && $custom_labels['sell']['is_custom_field_3_required'] == 1 ? true : false;

			        $custom_field_4_label = !empty($custom_labels['sell']['custom_field_4']) ? $custom_labels['sell']['custom_field_4'] : '';

			        $is_custom_field_4_required = !empty($custom_labels['sell']['is_custom_field_4_required']) && $custom_labels['sell']['is_custom_field_4_required'] == 1 ? true : false;
		        ?>
		        <?php if(!empty($custom_field_1_label)): ?>
		        	<?php
		        		$label_1 = $custom_field_1_label . ':';
		        		if($is_custom_field_1_required) {
		        			$label_1 .= '*';
		        		}
		        	?>

		        	<div class="col-md-4">
				        <div class="form-group">
				            <?php echo Form::label('custom_field_1', $label_1 ); ?>

				            <?php echo Form::text('custom_field_1', null, ['class' => 'form-control','placeholder' => $custom_field_1_label, 'required' => $is_custom_field_1_required]); ?>

				        </div>
				    </div>
		        <?php endif; ?>
		        <?php if(!empty($custom_field_2_label)): ?>
		        	<?php
		        		$label_2 = $custom_field_2_label . ':';
		        		if($is_custom_field_2_required) {
		        			$label_2 .= '*';
		        		}
		        	?>

		        	<div class="col-md-4">
				        <div class="form-group">
				            <?php echo Form::label('custom_field_2', $label_2 ); ?>

				            <?php echo Form::text('custom_field_2', null, ['class' => 'form-control','placeholder' => $custom_field_2_label, 'required' => $is_custom_field_2_required]); ?>

				        </div>
				    </div>
		        <?php endif; ?>
		        <?php if(!empty($custom_field_3_label)): ?>
		        	<?php
		        		$label_3 = $custom_field_3_label . ':';
		        		if($is_custom_field_3_required) {
		        			$label_3 .= '*';
		        		}
		        	?>

		        	<div class="col-md-4">
				        <div class="form-group">
				            <?php echo Form::label('custom_field_3', $label_3 ); ?>

				            <?php echo Form::text('custom_field_3', null, ['class' => 'form-control','placeholder' => $custom_field_3_label, 'required' => $is_custom_field_3_required]); ?>

				        </div>
				    </div>
		        <?php endif; ?>
		        <?php if(!empty($custom_field_4_label)): ?>
		        	<?php
		        		$label_4 = $custom_field_4_label . ':';
		        		if($is_custom_field_4_required) {
		        			$label_4 .= '*';
		        		}
		        	?>

		        	<div class="col-md-4">
				        <div class="form-group">
				            <?php echo Form::label('custom_field_4', $label_4 ); ?>

				            <?php echo Form::text('custom_field_4', null, ['class' => 'form-control','placeholder' => $custom_field_4_label, 'required' => $is_custom_field_4_required]); ?>

				        </div>
				    </div>
		        <?php endif; ?>
		        <div class="col-sm-3">
	                <div class="form-group">
	                    <?php echo Form::label('upload_document', __('purchase.attach_document') . ':'); ?>

	                    <?php echo Form::file('sell_document', ['id' => 'upload_document', 'accept' => implode(',', array_keys(config('constants.document_upload_mimes_types')))]); ?>

	                    <p class="help-block">
	                    	<?php echo app('translator')->get('purchase.max_file_size', ['size' => (config('constants.document_size_limit') / 1000000)]); ?>
	                    	<?php if ($__env->exists('components.document_help_text')) echo $__env->make('components.document_help_text', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	                    </p>
	                </div>
	            </div>
		        <div class="clearfix"></div>

		        <?php if((!empty($pos_settings['enable_sales_order']) && $sale_type != 'sales_order') || $is_order_request_enabled): ?>
					<div class="col-sm-3">
						<div class="form-group">
							<?php echo Form::label('sales_order_ids', __('lang_v1.sales_order').':'); ?>

							<?php echo Form::select('sales_order_ids[]', [], null, ['class' => 'form-control select2', 'multiple', 'id' => 'sales_order_ids']); ?>

						</div>
					</div>
					<div class="clearfix"></div>
				<?php endif; ?>
				<!-- Call restaurant module if defined -->
		        <?php if(in_array('tables' ,$enabled_modules) || in_array('service_staff' ,$enabled_modules)): ?>
		        	<span id="restaurant_module_span">
		        	</span>
		        <?php endif; ?>
			<?php echo $__env->renderComponent(); ?>

			<?php $__env->startComponent('components.widget', ['class' => 'box-solid']); ?>
				<div class="col-sm-10 col-sm-offset-1">
					<div class="form-group">
						<div class="input-group">
							<div class="input-group-btn">
								<button type="button" class="btn btn-default bg-white btn-flat" data-toggle="modal" data-target="#configure_search_modal" title="<?php echo e(__('lang_v1.configure_product_search'), false); ?>"><i class="fas fa-search-plus"></i></button>
							</div>
							<?php echo Form::text('search_product', null, ['class' => 'form-control mousetrap', 'id' => 'search_product', 'placeholder' => __('lang_v1.search_product_placeholder'),
							'disabled' => is_null($default_location)? true : false,
							'autofocus' => is_null($default_location)? false : true,
							]); ?>

							<span class="input-group-btn">
								<button type="button" class="btn btn-default bg-white btn-flat pos_add_quick_product" data-href="<?php echo e(action([\App\Http\Controllers\ProductController::class, 'quickAdd']), false); ?>" data-container=".quick_add_product_modal"><i class="fa fa-plus-circle text-primary fa-lg"></i></button>
							</span>
						</div>
					</div>
				</div>

				<div class="row col-sm-12 pos_product_div" style="min-height: 0">

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
					<div class="table-responsive">
					<table class="table table-condensed table-bordered table-striped table-responsive" id="pos_table">
						<thead>
							<tr>
								<th class="text-center">	
									<?php echo app('translator')->get('sale.product'); ?>
								</th>
								<th class="text-center">
									<?php echo app('translator')->get('sale.qty'); ?>
								</th>
								<?php if(!empty($pos_settings['inline_service_staff'])): ?>
									<th class="text-center">
										<?php echo app('translator')->get('restaurant.service_staff'); ?>
									</th>
								<?php endif; ?>
								<th class="<?php if(!auth()->user()->can('edit_product_price_from_sale_screen')): ?> hide <?php endif; ?>">
									<?php echo app('translator')->get('sale.unit_price'); ?>
								</th>
								<th class="<?php if(!auth()->user()->can('edit_product_discount_from_sale_screen')): ?> hide <?php endif; ?>">
									<?php echo app('translator')->get('receipt.discount'); ?>
								</th>
								<th class="text-center <?php echo e($hide_tax, false); ?>">
									<?php echo app('translator')->get('sale.tax'); ?>
								</th>
								<th class="text-center <?php echo e($hide_tax, false); ?>">
									<?php echo app('translator')->get('sale.price_inc_tax'); ?>
								</th>
								<?php if(!empty($common_settings['enable_product_warranty'])): ?>
									<th><?php echo app('translator')->get('lang_v1.warranty'); ?></th>
								<?php endif; ?>
								<th class="text-center">
									<?php echo app('translator')->get('sale.subtotal'); ?>
								</th>
								<th class="text-center"><i class="fas fa-times" aria-hidden="true"></i></th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
					</div>
					<div class="table-responsive">
					<table class="table table-condensed table-bordered table-striped">
						<tr>
							<td>
								<div class="pull-right">
								<b><?php echo app('translator')->get('sale.item'); ?>:</b> 
								<span class="total_quantity">0</span>
								&nbsp;&nbsp;&nbsp;&nbsp;
								<b><?php echo app('translator')->get('sale.total'); ?>: </b>
									<span class="price_total">0</span>
								</div>
							</td>
						</tr>
					</table>
					</div>
				</div>
			<?php echo $__env->renderComponent(); ?>
			<?php $__env->startComponent('components.widget', ['class' => 'box-solid']); ?>
				<div class="col-md-4  <?php if($sale_type == 'sales_order'): ?> hide <?php endif; ?>">
			        <div class="form-group">
			            <?php echo Form::label('discount_type', __('sale.discount_type') . ':*' ); ?>

			            <div class="input-group">
			                <span class="input-group-addon">
			                    <i class="fa fa-info"></i>
			                </span>
			                <?php echo Form::select('discount_type', ['fixed' => __('lang_v1.fixed'), 'percentage' => __('lang_v1.percentage')], 'fixed' , ['class' => 'form-control','placeholder' => __('messages.please_select'), 'required', 'data-default' => 'percentage']); ?>

			            </div>
			        </div>
			    </div>
			    <?php
			    	$max_discount = !is_null(auth()->user()->max_sales_discount_percent) ? auth()->user()->max_sales_discount_percent : '';

			    	//if sale discount is more than user max discount change it to max discount
			    	$sales_discount = $business_details->default_sales_discount;
			    	if($max_discount != '' && $sales_discount > $max_discount) $sales_discount = $max_discount;

			    	$default_sales_tax = $business_details->default_sales_tax;

			    	if($sale_type == 'sales_order') {
			    		$sales_discount = 0;
			    		$default_sales_tax = null;
			    	}
			    ?>
			    <div class="col-md-4 <?php if($sale_type == 'sales_order'): ?> hide <?php endif; ?>">
			        <div class="form-group">
			            <?php echo Form::label('discount_amount', __('sale.discount_amount') . ':*' ); ?>

			            <div class="input-group">
			                <span class="input-group-addon">
			                    <i class="fa fa-info"></i>
			                </span>
			                <?php echo Form::text('discount_amount', number_format($sales_discount, session('business.currency_precision', 2), session('currency')['decimal_separator'], session('currency')['thousand_separator']), ['class' => 'form-control input_number', 'data-default' => $sales_discount, 'data-max-discount' => $max_discount, 'data-max-discount-error_msg' => __('lang_v1.max_discount_error_msg', ['discount' => $max_discount != '' ? number_format($max_discount, session('business.currency_precision', 2), session('currency')['decimal_separator'], session('currency')['thousand_separator']) : '']) ]); ?>

			            </div>
			        </div>
			    </div>
			    <div class="col-md-4 <?php if($sale_type == 'sales_order'): ?> hide <?php endif; ?>"><br>
			    	<b><?php echo app('translator')->get( 'sale.discount_amount' ); ?>:</b>(-) 
					<span class="display_currency" id="total_discount">0</span>
			    </div>
			    <div class="clearfix"></div>
			    <div class="col-md-12 well well-sm bg-light-gray <?php if(session('business.enable_rp') != 1 || $sale_type == 'sales_order'): ?> hide <?php endif; ?>">
			    	<input type="hidden" name="rp_redeemed" id="rp_redeemed" value="0">
			    	<input type="hidden" name="rp_redeemed_amount" id="rp_redeemed_amount" value="0">
			    	<div class="col-md-12"><h4><?php echo e(session('business.rp_name'), false); ?></h4></div>
			    	<div class="col-md-4">
				        <div class="form-group">
				            <?php echo Form::label('rp_redeemed_modal', __('lang_v1.redeemed') . ':' ); ?>

				            <div class="input-group">
				                <span class="input-group-addon">
				                    <i class="fa fa-gift"></i>
				                </span>
				                <?php echo Form::number('rp_redeemed_modal', 0, ['class' => 'form-control direct_sell_rp_input', 'data-amount_per_unit_point' => session('business.redeem_amount_per_unit_rp'), 'min' => 0, 'data-max_points' => 0, 'data-min_order_total' => session('business.min_order_total_for_redeem') ]); ?>

				                <input type="hidden" id="rp_name" value="<?php echo e(session('business.rp_name'), false); ?>">
				            </div>
				        </div>
				    </div>
				    <div class="col-md-4">
				    	<p><strong><?php echo app('translator')->get('lang_v1.available'); ?>:</strong> <span id="available_rp">0</span></p>
				    </div>
				    <div class="col-md-4">
				    	<p><strong><?php echo app('translator')->get('lang_v1.redeemed_amount'); ?>:</strong> (-)<span id="rp_redeemed_amount_text">0</span></p>
				    </div>
			    </div>
			    <div class="clearfix"></div>
			    <div class="col-md-4  <?php if($sale_type == 'sales_order'): ?> hide <?php endif; ?>">
			    	<div class="form-group">
			            <?php echo Form::label('tax_rate_id', __('sale.order_tax') . ':*' ); ?>

			            <div class="input-group">
			                <span class="input-group-addon">
			                    <i class="fa fa-info"></i>
			                </span>
			                <?php echo Form::select('tax_rate_id', $taxes['tax_rates'], $default_sales_tax, ['placeholder' => __('messages.please_select'), 'class' => 'form-control', 'data-default'=> $default_sales_tax], $taxes['attributes']); ?>


							<input type="hidden" name="tax_calculation_amount" id="tax_calculation_amount" 
							value="<?php if(empty($edit)): ?> <?php echo e(number_format($business_details->tax_calculation_amount, session('business.currency_precision', 2), session('currency')['decimal_separator'], session('currency')['thousand_separator']), false); ?> <?php else: ?> <?php echo e(number_format($transaction->tax?->amount, session('business.currency_precision', 2), session('currency')['decimal_separator'], session('currency')['thousand_separator']), false); ?> <?php endif; ?>" data-default="<?php echo e($business_details->tax_calculation_amount, false); ?>">
			            </div>
			        </div>
			    </div>
			    <div class="col-md-4 col-md-offset-4  <?php if($sale_type == 'sales_order'): ?> hide <?php endif; ?>">
			    	<b><?php echo app('translator')->get( 'sale.order_tax' ); ?>:</b>(+) 
					<span class="display_currency" id="order_tax">0</span>
			    </div>				
				
			    <div class="col-md-12">
			    	<div class="form-group">
						<?php echo Form::label('sell_note',__('sale.sell_note')); ?>

						<?php echo Form::textarea('sale_note', null, ['class' => 'form-control', 'rows' => 3]); ?>

					</div>
			    </div>
				<input type="hidden" name="is_direct_sale" value="1">
			<?php echo $__env->renderComponent(); ?>
			<?php $__env->startComponent('components.widget', ['class' => 'box-solid']); ?>
			<div class="col-md-4">
				<div class="form-group">
		            <?php echo Form::label('shipping_details', __('sale.shipping_details')); ?>

		            <?php echo Form::textarea('shipping_details',null, ['class' => 'form-control','placeholder' => __('sale.shipping_details') ,'rows' => '3', 'cols'=>'30']); ?>

		        </div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
		            <?php echo Form::label('shipping_address', __('lang_v1.shipping_address')); ?>

		            <?php echo Form::textarea('shipping_address',null, ['class' => 'form-control','placeholder' => __('lang_v1.shipping_address') ,'rows' => '3', 'cols'=>'30']); ?>

		        </div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<?php echo Form::label('shipping_charges', __('sale.shipping_charges')); ?>

					<div class="input-group">
					<span class="input-group-addon">
					<i class="fa fa-info"></i>
					</span>
					<?php echo Form::text('shipping_charges',number_format(0.00, session('business.currency_precision', 2), session('currency')['decimal_separator'], session('currency')['thousand_separator']),['class'=>'form-control input_number','placeholder'=> __('sale.shipping_charges')]); ?>

					</div>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="col-md-4">
				<div class="form-group">
		            <?php echo Form::label('shipping_status', __('lang_v1.shipping_status')); ?>

		            <?php echo Form::select('shipping_status',$shipping_statuses, null, ['class' => 'form-control','placeholder' => __('messages.please_select')]); ?>

		        </div>
			</div>
			<div class="col-md-4">
		        <div class="form-group">
		            <?php echo Form::label('delivered_to', __('lang_v1.delivered_to') . ':' ); ?>

		            <?php echo Form::text('delivered_to', null, ['class' => 'form-control','placeholder' => __('lang_v1.delivered_to')]); ?>

		        </div>
		    </div>
		    <?php
		        $shipping_custom_label_1 = !empty($custom_labels['shipping']['custom_field_1']) ? $custom_labels['shipping']['custom_field_1'] : '';

		        $is_shipping_custom_field_1_required = !empty($custom_labels['shipping']['is_custom_field_1_required']) && $custom_labels['shipping']['is_custom_field_1_required'] == 1 ? true : false;

		        $shipping_custom_label_2 = !empty($custom_labels['shipping']['custom_field_2']) ? $custom_labels['shipping']['custom_field_2'] : '';

		        $is_shipping_custom_field_2_required = !empty($custom_labels['shipping']['is_custom_field_2_required']) && $custom_labels['shipping']['is_custom_field_2_required'] == 1 ? true : false;

		        $shipping_custom_label_3 = !empty($custom_labels['shipping']['custom_field_3']) ? $custom_labels['shipping']['custom_field_3'] : '';
		        
		        $is_shipping_custom_field_3_required = !empty($custom_labels['shipping']['is_custom_field_3_required']) && $custom_labels['shipping']['is_custom_field_3_required'] == 1 ? true : false;

		        $shipping_custom_label_4 = !empty($custom_labels['shipping']['custom_field_4']) ? $custom_labels['shipping']['custom_field_4'] : '';
		        
		        $is_shipping_custom_field_4_required = !empty($custom_labels['shipping']['is_custom_field_4_required']) && $custom_labels['shipping']['is_custom_field_4_required'] == 1 ? true : false;

		        $shipping_custom_label_5 = !empty($custom_labels['shipping']['custom_field_5']) ? $custom_labels['shipping']['custom_field_5'] : '';
		        
		        $is_shipping_custom_field_5_required = !empty($custom_labels['shipping']['is_custom_field_5_required']) && $custom_labels['shipping']['is_custom_field_5_required'] == 1 ? true : false;
	        ?>

	        <?php if(!empty($shipping_custom_label_1)): ?>
	        	<?php
	        		$label_1 = $shipping_custom_label_1 . ':';
	        		if($is_shipping_custom_field_1_required) {
	        			$label_1 .= '*';
	        		}
	        	?>

	        	<div class="col-md-4">
			        <div class="form-group">
			            <?php echo Form::label('shipping_custom_field_1', $label_1 ); ?>

			            <?php echo Form::text('shipping_custom_field_1', !empty($walk_in_customer['shipping_custom_field_details']['shipping_custom_field_1']) ? $walk_in_customer['shipping_custom_field_details']['shipping_custom_field_1'] : null, ['class' => 'form-control','placeholder' => $shipping_custom_label_1, 'required' => $is_shipping_custom_field_1_required]); ?>

			        </div>
			    </div>
	        <?php endif; ?>
	        <?php if(!empty($shipping_custom_label_2)): ?>
	        	<?php
	        		$label_2 = $shipping_custom_label_2 . ':';
	        		if($is_shipping_custom_field_2_required) {
	        			$label_2 .= '*';
	        		}
	        	?>

	        	<div class="col-md-4">
			        <div class="form-group">
			            <?php echo Form::label('shipping_custom_field_2', $label_2 ); ?>

			            <?php echo Form::text('shipping_custom_field_2', !empty($walk_in_customer['shipping_custom_field_details']['shipping_custom_field_2']) ? $walk_in_customer['shipping_custom_field_details']['shipping_custom_field_2'] : null, ['class' => 'form-control','placeholder' => $shipping_custom_label_2, 'required' => $is_shipping_custom_field_2_required]); ?>

			        </div>
			    </div>
	        <?php endif; ?>
	        <?php if(!empty($shipping_custom_label_3)): ?>
	        	<?php
	        		$label_3 = $shipping_custom_label_3 . ':';
	        		if($is_shipping_custom_field_3_required) {
	        			$label_3 .= '*';
	        		}
	        	?>

	        	<div class="col-md-4">
			        <div class="form-group">
			            <?php echo Form::label('shipping_custom_field_3', $label_3 ); ?>

			            <?php echo Form::text('shipping_custom_field_3', !empty($walk_in_customer['shipping_custom_field_details']['shipping_custom_field_3']) ? $walk_in_customer['shipping_custom_field_details']['shipping_custom_field_3'] : null, ['class' => 'form-control','placeholder' => $shipping_custom_label_3, 'required' => $is_shipping_custom_field_3_required]); ?>

			        </div>
			    </div>
	        <?php endif; ?>
	        <?php if(!empty($shipping_custom_label_4)): ?>
	        	<?php
	        		$label_4 = $shipping_custom_label_4 . ':';
	        		if($is_shipping_custom_field_4_required) {
	        			$label_4 .= '*';
	        		}
	        	?>

	        	<div class="col-md-4">
			        <div class="form-group">
			            <?php echo Form::label('shipping_custom_field_4', $label_4 ); ?>

			            <?php echo Form::text('shipping_custom_field_4', !empty($walk_in_customer['shipping_custom_field_details']['shipping_custom_field_4']) ? $walk_in_customer['shipping_custom_field_details']['shipping_custom_field_4'] : null, ['class' => 'form-control','placeholder' => $shipping_custom_label_4, 'required' => $is_shipping_custom_field_4_required]); ?>

			        </div>
			    </div>
	        <?php endif; ?>
	        <?php if(!empty($shipping_custom_label_5)): ?>
	        	<?php
	        		$label_5 = $shipping_custom_label_5 . ':';
	        		if($is_shipping_custom_field_5_required) {
	        			$label_5 .= '*';
	        		}
	        	?>

	        	<div class="col-md-4">
			        <div class="form-group">
			            <?php echo Form::label('shipping_custom_field_5', $label_5 ); ?>

			            <?php echo Form::text('shipping_custom_field_5', !empty($walk_in_customer['shipping_custom_field_details']['shipping_custom_field_5']) ? $walk_in_customer['shipping_custom_field_details']['shipping_custom_field_5'] : null, ['class' => 'form-control','placeholder' => $shipping_custom_label_5, 'required' => $is_shipping_custom_field_5_required]); ?>

			        </div>
			    </div>
	        <?php endif; ?>
	        <div class="col-md-4">
                <div class="form-group">
                    <?php echo Form::label('shipping_documents', __('lang_v1.shipping_documents') . ':'); ?>

                    <?php echo Form::file('shipping_documents[]', ['id' => 'shipping_documents', 'multiple', 'accept' => implode(',', array_keys(config('constants.document_upload_mimes_types')))]); ?>

                    <p class="help-block">
                    	<?php echo app('translator')->get('purchase.max_file_size', ['size' => (config('constants.document_size_limit') / 1000000)]); ?>
                    	<?php if ($__env->exists('components.document_help_text')) echo $__env->make('components.document_help_text', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </p>
                </div>
            </div>
	        <div class="clearfix"></div>
	        <div class="col-md-12 text-center">
				<button type="button" class="btn btn-primary btn-sm" id="toggle_additional_expense"> <i class="fas fa-plus"></i> <?php echo app('translator')->get('lang_v1.add_additional_expenses'); ?> <i class="fas fa-chevron-down"></i></button>
			</div>
			<div class="col-md-8 col-md-offset-4" id="additional_expenses_div" style="display: none;">
				<table class="table table-condensed">
					<thead>
						<tr>
							<th><?php echo app('translator')->get('lang_v1.additional_expense_name'); ?></th>
							<th><?php echo app('translator')->get('sale.amount'); ?></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<?php echo Form::text('additional_expense_key_1', null, ['class' => 'form-control', 'id' => 'additional_expense_key_1']); ?>

							</td>
							<td>
								<?php echo Form::text('additional_expense_value_1', 0, ['class' => 'form-control input_number', 'id' => 'additional_expense_value_1']); ?>

							</td>
						</tr>
						<tr>
							<td>
								<?php echo Form::text('additional_expense_key_2', null, ['class' => 'form-control', 'id' => 'additional_expense_key_2']); ?>

							</td>
							<td>
								<?php echo Form::text('additional_expense_value_2', 0, ['class' => 'form-control input_number', 'id' => 'additional_expense_value_2']); ?>

							</td>
						</tr>
						<tr>
							<td>
								<?php echo Form::text('additional_expense_key_3', null, ['class' => 'form-control', 'id' => 'additional_expense_key_3']); ?>

							</td>
							<td>
								<?php echo Form::text('additional_expense_value_3', 0, ['class' => 'form-control input_number', 'id' => 'additional_expense_value_3']); ?>

							</td>
						</tr>
						<tr>
							<td>
								<?php echo Form::text('additional_expense_key_4', null, ['class' => 'form-control', 'id' => 'additional_expense_key_4']); ?>

							</td>
							<td>
								<?php echo Form::text('additional_expense_value_4', 0, ['class' => 'form-control input_number', 'id' => 'additional_expense_value_4']); ?>

							</td>
						</tr>
					</tbody>
				</table>
			</div>
		    <div class="col-md-4 col-md-offset-8">
		    	<?php if(!empty($pos_settings['amount_rounding_method']) && $pos_settings['amount_rounding_method'] > 0): ?>
		    	<small id="round_off"><br>(<?php echo app('translator')->get('lang_v1.round_off'); ?>: <span id="round_off_text">0</span>)</small>
				<br/>
				<input type="hidden" name="round_off_amount" 
					id="round_off_amount" value=0>
				<?php endif; ?>
		    	<div><b><?php echo app('translator')->get('sale.total_payable'); ?>: </b>
					<input type="hidden" name="final_total" id="final_total_input">
					<span id="total_payable">0</span>
				</div>
		    </div>
			<?php echo $__env->renderComponent(); ?>
		</div>
	</div>
	<?php if(!empty($common_settings['is_enabled_export']) && $sale_type != 'sales_order'): ?>
		<?php $__env->startComponent('components.widget', ['class' => 'box-solid', 'title' => __('lang_v1.export')]); ?>
			<div class="col-md-12 mb-12">
                <div class="form-check">
                    <input type="checkbox" name="is_export" class="form-check-input" id="is_export" <?php if(!empty($walk_in_customer['is_export'])): ?> checked <?php endif; ?>>
                    <label class="form-check-label" for="is_export"><?php echo app('translator')->get('lang_v1.is_export'); ?></label>
                </div>
            </div>
	        <?php
	            $i = 1;
	        ?>
	        <?php for($i; $i <= 6 ; $i++): ?>
	            <div class="col-md-4 export_div" <?php if(empty($walk_in_customer['is_export'])): ?> style="display: none;" <?php endif; ?>>
	                <div class="form-group">
	                    <?php echo Form::label('export_custom_field_'.$i, __('lang_v1.export_custom_field'.$i).':'); ?>

	                    <?php echo Form::text('export_custom_fields_info['.'export_custom_field_'.$i.']', !empty($walk_in_customer['export_custom_field_'.$i]) ? $walk_in_customer['export_custom_field_'.$i] : null, ['class' => 'form-control','placeholder' => __('lang_v1.export_custom_field'.$i), 'id' => 'export_custom_field_'.$i]); ?>

	                </div>
	            </div>
	        <?php endfor; ?>
		<?php echo $__env->renderComponent(); ?>
	<?php endif; ?>
	<?php
		$is_enabled_download_pdf = config('constants.enable_download_pdf');
		$payment_body_id = 'payment_rows_div';
		if ($is_enabled_download_pdf) {
			$payment_body_id = '';
		}
	?>
	<?php if((empty($status) || (!in_array($status, ['quotation', 'draft'])) || $is_enabled_download_pdf) && $sale_type != 'sales_order'): ?>
		<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sell.payments')): ?>
			<?php $__env->startComponent('components.widget', ['class' => 'box-solid', 'id' => $payment_body_id, 'title' => __('purchase.add_payment')]); ?>
			<?php if($is_enabled_download_pdf): ?>
				<div class="well row">
					<div class="col-md-6">
						<div class="form-group">
							<?php echo Form::label("prefer_payment_method" , __('lang_v1.prefer_payment_method') . ':'); ?>

							<?php
                if(session('business.enable_tooltip')){
                    echo '<i class="fa fa-info-circle text-info hover-q no-print " aria-hidden="true" 
                    data-container="body" data-toggle="popover" data-placement="auto bottom" 
                    data-content="' . __('lang_v1.this_will_be_shown_in_pdf') . '" data-html="true" data-trigger="hover"></i>';
                }
                ?>
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fas fa-money-bill-alt"></i>
								</span>
								<?php echo Form::select("prefer_payment_method", $payment_types, 'cash', ['class' => 'form-control','style' => 'width:100%;']); ?>

							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<?php echo Form::label("prefer_payment_account" , __('lang_v1.prefer_payment_account') . ':'); ?>

							<?php
                if(session('business.enable_tooltip')){
                    echo '<i class="fa fa-info-circle text-info hover-q no-print " aria-hidden="true" 
                    data-container="body" data-toggle="popover" data-placement="auto bottom" 
                    data-content="' . __('lang_v1.this_will_be_shown_in_pdf') . '" data-html="true" data-trigger="hover"></i>';
                }
                ?>
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fas fa-money-bill-alt"></i>
								</span>
								<?php echo Form::select("prefer_payment_account", $accounts, null, ['class' => 'form-control','style' => 'width:100%;']); ?>

							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>
			<?php if(empty($status) || !in_array($status, ['quotation', 'draft'])): ?>
				<div class="payment_row" <?php if($is_enabled_download_pdf): ?> id="payment_rows_div" <?php endif; ?>>
					<div class="row">
						<div class="col-md-12 mb-12">
							<strong><?php echo app('translator')->get('lang_v1.advance_balance'); ?>:</strong> <span id="advance_balance_text"></span>
							<?php echo Form::hidden('advance_balance', null, ['id' => 'advance_balance', 'data-error-msg' => __('lang_v1.required_advance_balance_not_available')]); ?>

						</div>
					</div>
					<?php echo $__env->make('sale_pos.partials.payment_row_form', ['row_index' => 0, 'show_date' => true, 'show_denomination' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                <div class="payment_row">
					<div class="row">
						<div class="col-md-12">
			        		<hr>
			        		<strong>
			        			<?php echo app('translator')->get('lang_v1.change_return'); ?>:
			        		</strong>
			        		<br/>
			        		<span class="lead text-bold change_return_span">0</span>
			        		<?php echo Form::hidden("change_return", $change_return['amount'], ['class' => 'form-control change_return input_number', 'required', 'id' => "change_return"]); ?>

			        		<!-- <span class="lead text-bold total_quantity">0</span> -->
			        		<?php if(!empty($change_return['id'])): ?>
			            		<input type="hidden" name="change_return_id" 
			            		value="<?php echo e($change_return['id'], false); ?>">
			            	<?php endif; ?>
						</div>
					</div>
					<div class="row hide payment_row" id="change_return_payment_data">
						<div class="col-md-4">
							<div class="form-group">
								<?php echo Form::label("change_return_method" , __('lang_v1.change_return_payment_method') . ':*'); ?>

								<div class="input-group">
									<span class="input-group-addon">
										<i class="fas fa-money-bill-alt"></i>
									</span>
									<?php
										$_payment_method = empty($change_return['method']) && array_key_exists('cash', $payment_types) ? 'cash' : $change_return['method'];

										$_payment_types = $payment_types;
										if(isset($_payment_types['advance'])) {
											unset($_payment_types['advance']);
										}
									?>
									<?php echo Form::select("payment[change_return][method]", $_payment_types, $_payment_method, ['class' => 'form-control col-md-12 payment_types_dropdown', 'id' => 'change_return_method', 'style' => 'width:100%;']); ?>

								</div>
							</div>
						</div>
						<?php if(!empty($accounts)): ?>
						<div class="col-md-4">
							<div class="form-group">
								<?php echo Form::label("change_return_account" , __('lang_v1.change_return_payment_account') . ':'); ?>

								<div class="input-group">
									<span class="input-group-addon">
										<i class="fas fa-money-bill-alt"></i>
									</span>
									<?php echo Form::select("payment[change_return][account_id]", $accounts, !empty($change_return['account_id']) ? $change_return['account_id'] : '' , ['class' => 'form-control select2', 'id' => 'change_return_account', 'style' => 'width:100%;']); ?>

								</div>
							</div>
						</div>
						<?php endif; ?>
						<?php echo $__env->make('sale_pos.partials.payment_type_details', ['payment_line' => $change_return, 'row_index' => 'change_return'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
					</div>
					<hr>
					<div class="row">
						<div class="col-sm-12">
							<div class="pull-right"><strong><?php echo app('translator')->get('lang_v1.balance'); ?>:</strong> <span class="balance_due">0.00</span></div>
						</div>
					</div>
				</div>
			<?php endif; ?>
			<?php echo $__env->renderComponent(); ?>
		<?php endif; ?>
	<?php endif; ?>
	
	<div class="row">
		<?php echo Form::hidden('is_save_and_print', 0, ['id' => 'is_save_and_print']); ?>

		<div class="col-sm-12 text-center">
			<button type="button" id="submit-sell" class="btn btn-primary btn-big"><?php echo app('translator')->get('messages.save'); ?></button>
			<button type="button" id="save-and-print" class="btn btn-success btn-big"><?php echo app('translator')->get('lang_v1.save_and_print'); ?></button>
		</div>
	</div>
	
	<?php if(empty($pos_settings['disable_recurring_invoice'])): ?>
		<?php echo $__env->make('sale_pos.partials.recurring_invoice_modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php endif; ?>
	
	<?php echo Form::close(); ?>

</section>

<div class="modal fade contact_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
	<?php echo $__env->make('contact.create', ['quick_add' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>
<!-- /.content -->
<div class="modal fade register_details_modal" tabindex="-1" role="dialog" 
	aria-labelledby="gridSystemModalLabel">
</div>
<div class="modal fade close_register_modal" tabindex="-1" role="dialog" 
	aria-labelledby="gridSystemModalLabel">
</div>

<!-- quick product modal -->
<div class="modal fade quick_add_product_modal" tabindex="-1" role="dialog" aria-labelledby="modalTitle"></div>

<?php echo $__env->make('sale_pos.partials.configure_search_modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
	<script src="<?php echo e(asset('js/pos.js?v=' . $asset_v), false); ?>"></script>
	<script src="<?php echo e(asset('js/product.js?v=' . $asset_v), false); ?>"></script>
	<script src="<?php echo e(asset('js/opening_stock.js?v=' . $asset_v), false); ?>"></script>

	<!-- Call restaurant module if defined -->
    <?php if(in_array('tables' ,$enabled_modules) || in_array('modifiers' ,$enabled_modules) || in_array('service_staff' ,$enabled_modules)): ?>
    	<script src="<?php echo e(asset('js/restaurant.js?v=' . $asset_v), false); ?>"></script>
    <?php endif; ?>
    <script type="text/javascript">
    	$(document).ready( function() {
    		$('#status').change(function(){
    			if ($(this).val() == 'final') {
    				$('#payment_rows_div').removeClass('hide');
    			} else {
    				$('#payment_rows_div').addClass('hide');
    			}
    		});
    		$('.paid_on').datetimepicker({
                format: moment_date_format + ' ' + moment_time_format,
                ignoreReadonly: true,
            });

            $('#shipping_documents').fileinput({
		        showUpload: false,
		        showPreview: false,
		        browseLabel: LANG.file_browse_label,
		        removeLabel: LANG.remove,
		    });

		    $(document).on('change', '#prefer_payment_method', function(e) {
			    var default_accounts = $('select#select_location_id').length ? 
			                $('select#select_location_id')
			                .find(':selected')
			                .data('default_payment_accounts') : $('#location_id').data('default_payment_accounts');
			    var payment_type = $(this).val();
			    if (payment_type) {
			        var default_account = default_accounts && default_accounts[payment_type]['account'] ? 
			            default_accounts[payment_type]['account'] : '';
			        var account_dropdown = $('select#prefer_payment_account');
			        if (account_dropdown.length && default_accounts) {
			            account_dropdown.val(default_account);
			            account_dropdown.change();
			        }
			    }
			});

		    function setPreferredPaymentMethodDropdown() {
			    var payment_settings = $('#location_id').data('default_payment_accounts');
			    payment_settings = payment_settings ? payment_settings : [];
			    enabled_payment_types = [];
			    for (var key in payment_settings) {
			        if (payment_settings[key] && payment_settings[key]['is_enabled']) {
			            enabled_payment_types.push(key);
			        }
			    }
			    if (enabled_payment_types.length) {
			        $("#prefer_payment_method > option").each(function() {
		                if (enabled_payment_types.indexOf($(this).val()) != -1) {
		                    $(this).removeClass('hide');
		                } else {
		                    $(this).addClass('hide');
		                }
			        });
			    }
			}
			
			setPreferredPaymentMethodDropdown();

			$('#is_export').on('change', function () {
	            if ($(this).is(':checked')) {
	                $('div.export_div').show();
	            } else {
	                $('div.export_div').hide();
	            }
	        });

			if($('.payment_types_dropdown').length){
				$('.payment_types_dropdown').change();
			}

    	});
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp8.2\htdocs\UltimatePOS\resources\views/sell/create.blade.php ENDPATH**/ ?>