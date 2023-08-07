<div class="table-responsive cus_print">
    <!-- <h2>Cost of Sales</h2> -->
    <table class="table table-bordered table-striped " id="cost_table_custom">
        <thead>
            <tr >
                <th   class="table_heading">Cost of Sales</th>
                
            </tr>
            <tr>
                <th>Category</th>
                <th>@lang('product.sub_category')</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tfoot>
            <tr class="bg-gray font-17 footer-total">
                <td></td>
                <td><strong>@lang('sale.total'):</strong></td>
                <td class="cost_total"></td>
            </tr>
        </tfoot>
    </table>

</div>

<div class="table-responsive cus_print">
    <table class="table table-bordered table-striped" id="custom_gross_profit_table">
        <tfoot>
            <tr class="bg-gray profit font-17 footer-total">
                <td><span>{{ __('lang_v1.gross_profit') }} (Sales Total - Cost of Sales Total):</span></td>
                <td class="gross_profit currency"></td>
            </tr>
        </tfoot>
    </table>

</div>

<div class="table-responsive cus_print">
    <!-- <h2>Expenses</h2> -->
    <table class="table table-bordered table-striped " id="expense_table_custom">
        <thead>
            <tr>
                <th  class="table_heading" >Expenses</th>
            </tr>
            <tr>
                <th>Category</th>
                <th>@lang('product.sub_category')</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tfoot>
            <tr class="bg-gray font-17 footer-total">
                <td></td>
                <td><strong>@lang('sale.total'):</strong></td>
                <td class="expense_total"></td>
            </tr>
        </tfoot>
    </table>

</div>
