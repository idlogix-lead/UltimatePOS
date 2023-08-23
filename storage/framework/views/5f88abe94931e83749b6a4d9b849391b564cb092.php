<div class="tab-pane" id="psr_by_brand_tab">
    <div class="table-responsive">
        <table class="table table-bordered table-striped" 
        id="product_sell_report_by_brand" style="width: 100%;">
            <thead>
                <tr>
                    <th><?php echo app('translator')->get('product.brand'); ?></th>
                    <th><?php echo app('translator')->get('report.current_stock'); ?></th>
                    <th><?php echo app('translator')->get('report.total_unit_sold'); ?></th>
                    <th><?php echo app('translator')->get('sale.total'); ?></th>
                </tr>
            </thead>
            <tfoot>
                <tr class="bg-gray font-17 footer-total text-center">
                    <td><strong><?php echo app('translator')->get('sale.total'); ?>:</strong></td>
                    <td id="footer_psr_by_brand_total_stock"></td>
                    <td id="footer_psr_by_brand_total_sold"></td>
                    <td><span class="display_currency" id="footer_psr_by_brand_total_sell" data-currency_symbol ="true"></span></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div><?php /**PATH E:\xampp8.2\htdocs\UltimatePOS\resources\views/report/partials/product_sell_report_by_brand.blade.php ENDPATH**/ ?>