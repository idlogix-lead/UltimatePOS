@php
  $custom_labels = json_decode(auth()->user()->business->custom_labels, true);
  $product_custom_field1 = !empty($custom_labels['product']['custom_field_1']) ? $custom_labels['product']['custom_field_1'] : __('lang_v1.product_custom_field1');
  $product_custom_field2 = !empty($custom_labels['product']['custom_field_2']) ? $custom_labels['product']['custom_field_2'] : __('lang_v1.product_custom_field2');
  $product_custom_field3 = !empty($custom_labels['product']['custom_field_3']) ? $custom_labels['product']['custom_field_3'] : __('lang_v1.product_custom_field3');
  $product_custom_field4 = !empty($custom_labels['product']['custom_field_4']) ? $custom_labels['product']['custom_field_4'] : __('lang_v1.product_custom_field4');
@endphp
<table class="table table-bordered table-striped" id="stock_report_table">
    <thead>
        <tr>
            @if (!isset($products))
                <th>@lang('messages.action')</th>
            @endif
            <th>SKU</th>
            <th>@lang('business.product')</th>
            <th>@lang('lang_v1.variation')</th>
            <th>@lang('product.category')</th>
            <th>@lang('sale.location')</th>
            <th>@lang('purchase.unit_selling_price')</th>
            <th>@lang('report.current_stock')</th>
            @if(auth()->user()->hasPermissionTo('view_product_stock_value',"web" ) or auth()->user()->can('view_product_stock_value'))
            <th class="stock_price">@lang('lang_v1.total_stock_price') <br><small>(@lang('lang_v1.by_purchase_price'))</small></th>
            <th>@lang('lang_v1.total_stock_price') <br><small>(@lang('lang_v1.by_sale_price'))</small></th>
            <th>@lang('lang_v1.potential_profit')</th>
            @endif
            <th>@lang('report.total_unit_sold')</th>
            <th>@lang('lang_v1.total_unit_transfered')</th>
            <th>@lang('lang_v1.total_unit_adjusted')</th>
            @if (!isset($products))
            <th>{{$product_custom_field1}}</th>
            <th>{{$product_custom_field2}}</th>
            <th>{{$product_custom_field3}}</th>
            <th>{{$product_custom_field4}}</th>
            @endif
            @if($show_manufacturing_data)
                <th class="current_stock_mfg">@lang('manufacturing::lang.current_stock_mfg') @show_tooltip(__('manufacturing::lang.mfg_stock_tooltip'))</th>
            @endif
        </tr>
    </thead>
    @if(isset($products))
        <tbody>
            @php
                $footer_total_stock = 0;
                $footer_total_stock_price = 0;
                $footer_stock_value_by_sale_price = 0;
                $footer_potential_profit = 0;
                $footer_total_sold = 0;
                $footer_total_transfered = 0;
                $footer_total_adjusted = 0;
                // $footer_total_mfg_stock = 0;
            @endphp
            @foreach ($products as $row)
                @php
                    $stock = $row->stock ? $row->stock : 0;
                    $unit_selling_price = (float) $row->group_price > 0 ? $row->group_price : $row->unit_price;
                    $stock_price = $stock * $unit_selling_price;
                    $stock_price_by_sp = $stock * $unit_selling_price;
                    $potential_profit = (float) $stock_price_by_sp - (float) $row->stock_price;
                    if($row->enable_stock != 0){
                    $footer_total_stock += $row->stock;}

                    $footer_total_stock_price += $row->stock_price;
                    $footer_stock_value_by_sale_price += $stock_price;
                    $footer_potential_profit += $potential_profit;
                    $footer_total_sold += $row->total_sold;
                    $footer_total_transfered += $row->total_transfered;
                    $footer_total_adjusted += $row->total_adjusted;
                    // $footer_total_mfg_stock += 0;
                @endphp
                <tr>
                    <td>{{$row->sku}}</td>
                    <td>{{$row->product}}</td>
                    <td>
                        @php
                            $variation = '';
                            if ($row->type == 'variable') {
                                $variation .= $row->product_variation.'-'.$row->variation_name;
                            }
                            echo $variation;
                        @endphp
                    </td>
                    <td>{{$row->category_name}}</td>
                    <td>{{$row->location_name}}</td>
                    <td>{{$symbol}}.{{round($row->unit_price,2)}}</td>
                    <td>{{$row->enable_stock == 0?"--":$row->stock." ".$row->unit}}</td>
                    <td>{{$symbol}}.{{round($row->stock_price,2)}}</td>
                    <td>{{$symbol}}.{{round($stock_price,2)}}</td>
                    <td>{{$symbol}}.{{round($potential_profit,2)}}</td>
                    <td>{{$row->total_sold?round($row->total_sold,2):0}} {{$row->unit}}</td>
                    <td>{{$row->total_transfered?round($row->total_transfered,2):0}} {{$row->unit}}</td>
                    <td>{{$row->total_adjusted?round($row->total_adjusted,2):0}} {{$row->unit}}</td>
                </tr>
            @endforeach
        </tbody>
    @endif
    <tfoot>
        @if (!isset($products))
            <tr class="bg-gray font-17 text-center footer-total">
                <td colspan="7"><strong>@lang('sale.total'):</strong></td>
                <td class="footer_total_stock"></td>
                @can('view_product_stock_value')
                <td class="footer_total_stock_price"></td>
                <td class="footer_stock_value_by_sale_price"></td>
                <td class="footer_potential_profit"></td>
                @endcan
                <td class="footer_total_sold"></td>
                <td class="footer_total_transfered"></td>
                <td class="footer_total_adjusted"></td>
                <td colspan="4"></td>
                @if($show_manufacturing_data)
                    <td class="footer_total_mfg_stock"></td>
                @endif
            </tr>
        @else
            <tr class="bg-gray font-17 text-center footer-total">
                <td colspan="6"><strong>@lang('sale.total'):</strong></td>
                <td class="footer_total_stock">{{round($footer_total_stock,2)}}</td>
                {{-- <td class="footer_total_stock"></td> --}}
                @if(auth()->user()->hasPermissionTo('view_product_stock_value',"web" ) or auth()->user()->can('view_product_stock_value'))
                    <td class="footer_total_stock_price">{{$symbol}}.{{round($footer_total_stock_price,2)}}</td>
                    <td class="footer_stock_value_by_sale_price">{{$symbol}}.{{round($footer_stock_value_by_sale_price,2)}}</td>
                    <td class="footer_potential_profit">{{$symbol}}.{{round($footer_potential_profit,2)}}</td>
                @endif
                <td class="footer_total_sold">{{round($footer_total_sold,2)}}</td>
                <td class="footer_total_transfered">{{round($footer_total_transfered,2)}}</td>
                <td class="footer_total_adjusted">{{round($footer_total_adjusted,2)}}</td>
                {{-- <td class="footer_total_sold"></td>
                <td class="footer_total_transfered"></td>
                <td class="footer_total_adjusted"></td> --}}
                {{-- <td colspan="2"></td> --}}
                @if($show_manufacturing_data)
                    <td class="footer_total_mfg_stock">{{$symbol}}.{{round($footer_total_mfg_stock,2)}}</td>
                @endif
            </tr>
        @endif
    </tfoot>
</table>