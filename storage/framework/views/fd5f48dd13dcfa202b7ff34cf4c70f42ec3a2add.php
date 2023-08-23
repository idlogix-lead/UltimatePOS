<div class="table-responsive">
    <table class="table table-bordered table-striped" id="netprofit">

        <tfoot>
            <tr class="bg-gray profit font-17 footer-total">
                <td><span>Total Discount:</span></td>
                <td class="discount_total currency"><?php echo e(isset($symbol)?$symbol.". ".round($discount_total,2):"", false); ?></td>
            </tr>
        </tfoot>
    </table>

</div>
<div class="table-responsive">
    <table class="table table-bordered table-striped" id="netprofit">

        <tfoot>
            <tr class="bg-gray profit font-17 footer-total">
                <td><span><?php echo e(__('report.net_profit'), false); ?> (<?php echo e(__('lang_v1.gross_profit'), false); ?> - <?php echo app('translator')->get('report.total_expense'); ?> - Total Discount):</span></td>
                <td class="net_total currency"><?php echo e(isset($symbol)?$symbol.". ".round(($total_revenue-$total_cost-$total_expense-$discount_total-$production_cost),2):"", false); ?></td>
            </tr>
        </tfoot>
    </table>

</div><?php /**PATH E:\xampp8.2\htdocs\UltimatePOS\resources\views/report/custom/partials/netprofit.blade.php ENDPATH**/ ?>