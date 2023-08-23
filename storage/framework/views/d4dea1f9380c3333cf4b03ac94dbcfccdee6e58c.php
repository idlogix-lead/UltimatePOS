<div class="table-responsive cus_print">
    <h2 class="table_heading">Cost of Sales</h2>
    <table class="table table-bordered table-striped " id="cost_table_custom">
        <thead>
            
            <tr>
                <th>Category</th>
                <th><?php echo app('translator')->get('product.sub_category'); ?></th>
                <th>Amount</th>
            </tr>
        </thead>
        <?php if(isset($expenses)): ?>
            <tbody>
                <?php
                    global $total_cost;
                ?>
                <?php $__currentLoopData = $expenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($item["category"] == "Material Consumed"): ?>
                        <tr>
                            <td><?php echo e($item["category"], false); ?></td>
                            <td><?php echo e($item["sub_category"], false); ?></td>
                            <td><?php echo e(isset($symbol)?$symbol:"", false); ?>. <?php echo e(round($item["total_expense"],2), false); ?></td>
                        </tr>
                        <?php
                            $total_cost += $item["total_expense"];
                        ?>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        <?php endif; ?>
        <tfoot>
            <tr class="bg-gray font-17 footer-total">
                <td></td>
                <td><strong><?php echo app('translator')->get('sale.total'); ?>:</strong></td>
                <td class="cost_total"><?php echo e(isset($symbol)?$symbol.". ".round($total_cost,2):"", false); ?></td>
            </tr>
        </tfoot>
    </table>

</div>

<div class="table-responsive cus_print">
    <table class="table table-bordered table-striped" id="custom_gross_profit_table">
        <tfoot>
            <tr class="bg-gray profit font-14 footer-total">
                <td><span><?php echo e(__('lang_v1.gross_profit'), false); ?> (Sales Total - Cost of Sales Total):</span></td>
                <td class="gross_profit currency"><?php echo e(isset($symbol)?$symbol.". ".(round($total_revenue,2)-round($total_cost,2)):"", false); ?></td>
            </tr>
        </tfoot>
    </table>

</div>

<div class="table-responsive cus_print">
    <h2 class="table_heading">Expenses</h2> 
    <table class="table table-bordered table-striped mt-0" id="expense_table_custom">
        <thead>
            <tr>
                <th>Category</th>
                <th><?php echo app('translator')->get('product.sub_category'); ?></th>
                <th>Amount</th>
            </tr>
        </thead>
        <?php if(isset($expenses)): ?>
            <tbody>
                <?php
                    global $total_expense;
                ?>
                <?php $__currentLoopData = $expenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($item["category"] != "Material Consumed"): ?>
                        <tr>
                            <td><?php echo e($item["category"], false); ?></td>
                            <td><?php echo e($item["sub_category"], false); ?></td>
                            <td><?php echo e(isset($symbol)?$symbol:"", false); ?>. <?php echo e(round($item["total_expense"],2), false); ?></td>
                        </tr>
                        <?php
                            $total_expense += $item["total_expense"];
                        ?>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        <?php endif; ?>
        <tfoot>
            <tr class="bg-gray font-17 footer-total">
                <td></td>
                <td><strong><?php echo app('translator')->get('sale.total'); ?>:</strong></td>
                <td class="expense_total"><?php echo e(isset($symbol)?$symbol.". ".round($total_expense,2):"", false); ?></td>
            </tr>
        </tfoot>
    </table>

</div>
<?php /**PATH E:\xampp8.2\htdocs\UltimatePOS\resources\views/report/custom/partials/expense.blade.php ENDPATH**/ ?>