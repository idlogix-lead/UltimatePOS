<?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
	<div class="col-md-3 col-xs-4 product_list no-print">
		<div class="product_box" data-variation_id="<?php echo e($product->id, false); ?>" title="<?php echo e($product->name, false); ?> <?php if($product->type == 'variable'): ?>- <?php echo e($product->variation, false); ?> <?php endif; ?> <?php echo e('(' . $product->sub_sku . ')', false); ?> <?php if(!empty($show_prices)): ?> <?php echo app('translator')->get('lang_v1.default'); ?> - <?php 
            $formated_number = "";
            if (session("business.currency_symbol_placement") == "before") {
                $formated_number .= session("currency")["symbol"] . " ";
            } 
            $formated_number .= number_format((float) $product->selling_price, session("business.currency_precision", 2) , session("currency")["decimal_separator"], session("currency")["thousand_separator"]);

            if (session("business.currency_symbol_placement") == "after") {
                $formated_number .= " " . session("currency")["symbol"];
            }
            echo $formated_number; ?> <?php $__currentLoopData = $product->group_prices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group_price): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php if(array_key_exists($group_price->price_group_id, $allowed_group_prices)): ?> <?php echo e($allowed_group_prices[$group_price->price_group_id], false); ?> - <?php 
            $formated_number = "";
            if (session("business.currency_symbol_placement") == "before") {
                $formated_number .= session("currency")["symbol"] . " ";
            } 
            $formated_number .= number_format((float) $group_price->price_inc_tax, session("business.currency_precision", 2) , session("currency")["decimal_separator"], session("currency")["thousand_separator"]);

            if (session("business.currency_symbol_placement") == "after") {
                $formated_number .= " " . session("currency")["symbol"];
            }
            echo $formated_number; ?> <?php endif; ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> <?php endif; ?>">

		<div class="image-container" 
			style="background-image: url(
					<?php if(count($product->media) > 0): ?>
						<?php echo e($product->media->first()->display_url, false); ?>

					<?php elseif(!empty($product->product_image)): ?>
						<?php echo e(asset('/uploads/img/' . rawurlencode($product->product_image)), false); ?>

					<?php else: ?>
						<?php echo e(asset('/img/default.png'), false); ?>

					<?php endif; ?>
				);
			background-repeat: no-repeat; background-position: center;
			background-size: contain;">
			
		</div>

		<div class="text_div">
			<small class="text text-muted"><?php echo e($product->name, false); ?> 
			<?php if($product->type == 'variable'): ?>
				- <?php echo e($product->variation, false); ?>

			<?php endif; ?>
			</small>

			<small class="text-muted">
				(<?php echo e($product->sub_sku, false); ?>)
			</small>
		</div>
			
		</div>
	</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
	<input type="hidden" id="no_products_found">
	<div class="col-md-12">
		<h4 class="text-center">
			<?php echo app('translator')->get('lang_v1.no_products_to_display'); ?>
		</h4>
	</div>
<?php endif; ?><?php /**PATH E:\xampp8.2\htdocs\UltimatePOS\resources\views/sale_pos/partials/product_list.blade.php ENDPATH**/ ?>