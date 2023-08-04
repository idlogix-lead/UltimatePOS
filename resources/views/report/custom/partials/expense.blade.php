

<div class="table-responsive cus_print">
    <h2>Expenses</h2>
    <table class="table table-bordered table-striped " id="expense_table_custom">
        <thead>
            <tr>
                <th>@lang('expense.expense_category')</th>
                <th>@lang('product.sub_category')</th>
                <th>@lang('sale.total_amount')</th>
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