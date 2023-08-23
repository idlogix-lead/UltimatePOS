<div class="modal-dialog" role="document">
  <div class="modal-content">

    <?php echo Form::open(['url' => action([\App\Http\Controllers\CustomerGroupController::class, 'store']), 'method' => 'post', 'id' => 'customer_group_add_form' ]); ?>


    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title"><?php echo app('translator')->get( 'lang_v1.add_customer_group' ); ?></h4>
    </div>

    <div class="modal-body">
      <div class="form-group">
        <?php echo Form::label('name', __( 'lang_v1.customer_group_name' ) . ':*'); ?>

          <?php echo Form::text('name', null, ['class' => 'form-control', 'required', 'placeholder' => __( 'lang_v1.customer_group_name' ) ]); ?>

      </div>

      <div class="form-group">
            <?php echo Form::label('price_calculation_type', __( 'lang_v1.price_calculation_type' ) . ':'); ?>

            <?php echo Form::select('price_calculation_type',['percentage' => __('lang_v1.percentage'), 'selling_price_group' => __('lang_v1.selling_price_group')], 'percentage', ['class' => 'form-control']); ?>

      </div>

      <div class="form-group percentage-field">
        <?php echo Form::label('amount', __( 'lang_v1.calculation_percentage' ) . ':'); ?>

        <?php
                if(session('business.enable_tooltip')){
                    echo '<i class="fa fa-info-circle text-info hover-q no-print " aria-hidden="true" 
                    data-container="body" data-toggle="popover" data-placement="auto bottom" 
                    data-content="' . __('lang_v1.tooltip_calculation_percentage') . '" data-html="true" data-trigger="hover"></i>';
                }
                ?>
        <?php echo Form::text('amount', null, ['class' => 'form-control input_number','placeholder' => __( 'lang_v1.calculation_percentage')]); ?>

      </div>

      <div class="form-group selling_price_group-field hide">
            <?php echo Form::label('selling_price_group_id', __( 'lang_v1.selling_price_group' ) . ':'); ?>

            <?php echo Form::select('selling_price_group_id', $price_groups, null, ['class' => 'form-control']); ?>

      </div>

    </div>

    <div class="modal-footer">
      <button type="submit" class="btn btn-primary"><?php echo app('translator')->get( 'messages.save' ); ?></button>
      <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo app('translator')->get( 'messages.close' ); ?></button>
    </div>

    <?php echo Form::close(); ?>


  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog --><?php /**PATH E:\xampp8.2\htdocs\UltimatePOS\resources\views/customer_group/create.blade.php ENDPATH**/ ?>