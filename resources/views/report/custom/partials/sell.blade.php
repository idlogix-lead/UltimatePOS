<div class="table-responsive cus_print">
    <h2 class="table_heading">Revenue</h2> 
    <table class="table table-bordered table-striped" id="profit_by_products_table">
        <thead>
            {{-- <tr>
                <th class="table_heading">Revenue</th>
            </tr> --}}
           <tr>
                {{-- <th>@lang('sale.product')</th> --}}
                <th>Description</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tfoot>
            <tr class="bg-gray font-17 footer-total">
                <td><strong>@lang('sale.total'):</strong></td>
                <td class="sell_total"></td>
            </tr>
        </tfoot>
    </table>

</div>