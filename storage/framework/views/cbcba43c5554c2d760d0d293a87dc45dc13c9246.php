<table class="table table-bordered table-striped" id="product_sell_report_table">
    <thead>
        <tr>
            <th><?php echo app('translator')->get('sale.product'); ?></th>
            <th><?php echo app('translator')->get('product.sku'); ?></th>
            <?php if(!isset($data)): ?>
                <th id="psr_product_custom_field1"><?php echo e($product_custom_field1, false); ?></th>
                <th id="psr_product_custom_field2"><?php echo e($product_custom_field2, false); ?></th>
            <?php endif; ?>
            <th><?php echo app('translator')->get('sale.customer_name'); ?></th>
            <th><?php echo app('translator')->get('lang_v1.contact_id'); ?></th>
            <th><?php echo app('translator')->get('sale.invoice_no'); ?></th>
            <th><?php echo app('translator')->get('messages.date'); ?></th>
            <th><?php echo app('translator')->get('sale.qty'); ?></th>
            <th><?php echo app('translator')->get('sale.unit_price'); ?></th>
            <th><?php echo app('translator')->get('sale.discount'); ?></th>
            <th><?php echo app('translator')->get('sale.tax'); ?></th>
            <th><?php echo app('translator')->get('sale.price_inc_tax'); ?></th>
            <th><?php echo app('translator')->get('sale.total'); ?></th>
            <th><?php echo app('translator')->get('lang_v1.payment_method'); ?></th>
        </tr>
    </thead>
    <?php if(isset($data)): ?>
        <?php
            $tqty = 0;
            $total = 0;
            $tax_total = 0;
        ?>
        <tbody>
            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    // $tqty+=$row->sell_qty;
                    $total+=$row->subtotal;
                    $tax_total+=$row->tax;
                ?>
                <tr>
                    <td>
                        <?php
                            $product_name = $row->product_name;
                            if ($row->product_type == 'variable') {
                                $product_name .= ' - '.$row->product_variation.' - '.$row->variation_name;
                            }

                            echo $product_name;
                        ?>    
                    </td>
                    <td><?php echo e($row->sub_sku, false); ?></td>
                    <td><?php echo e($row->customer, false); ?></td>
                    <td><?php echo e($row->contact_id, false); ?></td>
                    <td><?php echo e($row->invoice_no, false); ?></td>
                    <td><?php echo e(date($format." h:m:s A",strtotime($row->transaction_date)), false); ?></td>
                    <td><?php echo e(round($row->sell_qty,2), false); ?> <?php echo e($row->unit, false); ?></td>
                    <td><?php echo e($symbol, false); ?>. <?php echo e(round($row->unit_price,2), false); ?></td>
                    <td>
                        <?php if($row->discount_type == "percentage"): ?>
                            <?php echo e(round($row->discount_amount,2), false); ?> %
                        <?php elseif($row->discount_type == "fixed"): ?>
                            <?php echo e($symbol, false); ?>. <?php echo e(round($row->discount_amount,2), false); ?>

                        <?php endif; ?>
                    </td>
                    <td><?php echo e($symbol, false); ?>. <?php echo e(round($row->tax,2), false); ?></td>
                    <td><?php echo e($symbol, false); ?>. <?php echo e(round($row->unit_sale_price,2), false); ?></td>
                    <td><?php echo e($symbol, false); ?>. <?php echo e(round($row->subtotal,2), false); ?></td>
                    <td>
                        <?php
                            $methods = array_unique($row->transaction->payment_lines->pluck('method')->toArray());
                            $count = count($methods);
                            $payment_method = '';
                            if ($count == 1) {
                                $payment_method = $payment_types[$methods[0]] ? $payment_types[$methods[0]]: '';
                            } elseif ($count > 1) {
                                $payment_method = __('lang_v1.checkout_multi_pay');
                            }
                            echo $payment_method ;
                        ?>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    <?php endif; ?>
    <tfoot>
        <tr class="bg-gray font-17 footer-total text-center">
            <td colspan="6"><strong><?php echo app('translator')->get('sale.total'); ?>:</strong></td>
            <td id="footer_total_sold"></td>
            <td></td>
            <td></td>
            <td id="footer_tax">
                <?php if(isset($data)): ?>
                    <?php echo e($symbol, false); ?>. <?php echo e(round($tax_total,2), false); ?>

                <?php endif; ?>
            </td>
            <td></td>
            <td><span class="display_currency" id="footer_subtotal" data-currency_symbol ="true">
                <?php if(isset($data)): ?>
                    <?php echo e($symbol, false); ?>. <?php echo e(round($total,2), false); ?>

                <?php endif; ?>
            </span></td>
            <td></td>
        </tr>
    </tfoot>
</table><?php /**PATH E:\xampp8.2\htdocs\UltimatePOS\resources\views/report/partials/product_sell_report_table.blade.php ENDPATH**/ ?>