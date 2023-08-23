<div class="table-responsive cus_print">
    <h2 class="table_heading">Revenue</h2> 
    <table class="table table-bordered table-striped" id="profit_by_products_table">
        <thead>
            
           <tr>
                
                <th>Description</th>
                <th>Amount</th>
            </tr>
        </thead>
        <?php if(isset($revenue)): ?>
            <?php
                global $total_revenue;
            ?>
            <tbody>
                <?php $__currentLoopData = $revenue; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($item["product"], false); ?></td>
                        <td><?php echo e(isset($symbol)?$symbol:"", false); ?>. <?php echo e(round($item["gross_profit"],2), false); ?></td>
                    </tr>
                    <?php
                        $total_revenue += $item["gross_profit"];
                    ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        <?php endif; ?>
        <tfoot>
            <tr class="bg-gray font-17 footer-total">
                <td><strong><?php echo app('translator')->get('sale.total'); ?>:</strong></td>
                <td class="sell_total"><?php echo e(isset($symbol)?$symbol.". ".round($total_revenue,2):"", false); ?></td>
            </tr>
        </tfoot>
    </table>

</div><?php /**PATH E:\xampp8.2\htdocs\UltimatePOS\resources\views/report/custom/partials/sell.blade.php ENDPATH**/ ?>