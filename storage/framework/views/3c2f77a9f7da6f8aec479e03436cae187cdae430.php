<div class="modal fade" tabindex="-1" role="dialog" id="weighing_scale_modal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><?php echo app('translator')->get('lang_v1.weighing_scale'); ?></h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-xs-12">
				        <div class="form-group">
				            <?php echo Form::label('weighing_scale_barcode', __('lang_v1.weighing_scale_barcode') . ':' ); ?> <?php
                if(session('business.enable_tooltip')){
                    echo '<i class="fa fa-info-circle text-info hover-q no-print " aria-hidden="true" 
                    data-container="body" data-toggle="popover" data-placement="auto bottom" 
                    data-content="' . __('lang_v1.weighing_scale_barcode_help') . '" data-html="true" data-trigger="hover"></i>';
                }
                ?>
				            <?php echo Form::text('weighing_scale_barcode', null, ['class' => 'form-control']); ?>

				        </div>
				    </div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="weighing_scale_submit"><?php echo app('translator')->get('messages.submit'); ?></button>
			    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo app('translator')->get('messages.close'); ?></button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal --><?php /**PATH E:\xampp8.2\htdocs\UltimatePOS\resources\views/sale_pos/partials/weighing_scale_modal.blade.php ENDPATH**/ ?>