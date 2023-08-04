<div class="table-responsive cus_print">
    <h2>Sales</h2>
    <table class="table table-bordered table-striped" id="profit_by_products_table">
        <thead>
           <tr>
                <th>@lang('sale.product')</th>
                <th>@lang('sale.total')</th>
            </tr>
        </thead>
        <tfoot>
            <tr class="bg-gray font-17 footer-total">
                <td><strong>{{ __('lang_v1.gross_profit') }} (Total Sales - Total Sales Return):</strong></td>
                <td class="sell_total"></td>
            </tr>
        </tfoot>
    </table>

</div>