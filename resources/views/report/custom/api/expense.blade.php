<div class="table-responsive cus_print">
    <h2 class="table_heading">Expenses {{isset($cat_id)?" By Category":""}}</h2> 
    <table class="table table-bordered table-striped mt-0" id="expense_table_custom">
        <thead>
            <tr>
                <th>Category</th>
                <th>@lang('product.sub_category')</th>
                <th>Amount</th>
            </tr>
        </thead>
        @if(isset($expenses))
            <tbody>
                @php
                    global $total_expense;
                @endphp
                @foreach ($expenses as $item)
                        <tr>
                            <td>{{$item["category"]}}</td>
                            <td>{{$item["sub_category"]}}</td>
                            <td>{{isset($symbol)?$symbol:""}}. {{round($item["total_expense"],2)}}</td>
                        </tr>
                        @php
                            $total_expense += $item["total_expense"];
                        @endphp
                @endforeach
            </tbody>
        @endif
        <tfoot>
            <tr class="bg-gray font-17 footer-total">
                <td></td>
                <td><strong>@lang('sale.total'):</strong></td>
                <td class="expense_total">{{isset($symbol)?$symbol.". ".round($total_expense,2):""}}</td>
            </tr>
        </tfoot>
    </table>

</div>