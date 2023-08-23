<table class="table table-bordered table-striped" id="product_sell_report_table">
    <thead>
        <tr>
            <th>@lang('sale.product')</th>
            <th>@lang('product.sku')</th>
            @if (!isset($data))
                <th id="psr_product_custom_field1">{{$product_custom_field1}}</th>
                <th id="psr_product_custom_field2">{{$product_custom_field2}}</th>
            @endif
            <th>@lang('sale.customer_name')</th>
            <th>@lang('lang_v1.contact_id')</th>
            <th>@lang('sale.invoice_no')</th>
            <th>@lang('messages.date')</th>
            <th>@lang('sale.qty')</th>
            <th>@lang('sale.unit_price')</th>
            <th>@lang('sale.discount')</th>
            <th>@lang('sale.tax')</th>
            <th>@lang('sale.price_inc_tax')</th>
            <th>@lang('sale.total')</th>
            <th>@lang('lang_v1.payment_method')</th>
        </tr>
    </thead>
    @if (isset($data))
        @php
            $tqty = 0;
            $total = 0;
            $tax_total = 0;
        @endphp
        <tbody>
            @foreach ($data as $row)
                @php
                    // $tqty+=$row->sell_qty;
                    $total+=$row->subtotal;
                    $tax_total+=$row->tax;
                @endphp
                <tr>
                    <td>
                        @php
                            $product_name = $row->product_name;
                            if ($row->product_type == 'variable') {
                                $product_name .= ' - '.$row->product_variation.' - '.$row->variation_name;
                            }

                            echo $product_name;
                        @endphp    
                    </td>
                    <td>{{$row->sub_sku}}</td>
                    <td>{{$row->customer}}</td>
                    <td>{{$row->contact_id}}</td>
                    <td>{{$row->invoice_no}}</td>
                    <td>{{date($format." h:m:s A",strtotime($row->transaction_date))}}</td>
                    <td>{{round($row->sell_qty,2)}} {{$row->unit}}</td>
                    <td>{{$symbol}}. {{round($row->unit_price,2)}}</td>
                    <td>
                        @if($row->discount_type == "percentage")
                            {{round($row->discount_amount,2)}} %
                        @elseif($row->discount_type == "fixed")
                            {{$symbol}}. {{round($row->discount_amount,2)}}
                        @endif
                    </td>
                    <td>{{$symbol}}. {{round($row->tax,2)}}</td>
                    <td>{{$symbol}}. {{round($row->unit_sale_price,2)}}</td>
                    <td>{{$symbol}}. {{round($row->subtotal,2)}}</td>
                    <td>
                        @php
                            $methods = array_unique($row->transaction->payment_lines->pluck('method')->toArray());
                            $count = count($methods);
                            $payment_method = '';
                            if ($count == 1) {
                                $payment_method = $payment_types[$methods[0]] ? $payment_types[$methods[0]]: '';
                            } elseif ($count > 1) {
                                $payment_method = __('lang_v1.checkout_multi_pay');
                            }
                            echo $payment_method ;
                        @endphp
                    </td>
                </tr>
            @endforeach
        </tbody>
    @endif
    <tfoot>
        <tr class="bg-gray font-17 footer-total text-center">
            <td colspan="6"><strong>@lang('sale.total'):</strong></td>
            <td id="footer_total_sold"></td>
            <td></td>
            <td></td>
            <td id="footer_tax">
                @if (isset($data))
                    {{$symbol}}. {{round($tax_total,2)}}
                @endif
            </td>
            <td></td>
            <td><span class="display_currency" id="footer_subtotal" data-currency_symbol ="true">
                @if (isset($data))
                    {{$symbol}}. {{round($total,2)}}
                @endif
            </span></td>
            <td></td>
        </tr>
    </tfoot>
</table>