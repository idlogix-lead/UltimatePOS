@include('cash_register.payment_details')
<hr>
@if(!empty($register_details->denominations))
    @php
    $total = 0;
    @endphp
    <div class="row">
    <div class="col-md-8 col-sm-12">
        <h3>@lang( 'lang_v1.cash_denominations' )</h3>
        <table class="table table-slim">
        <thead>
            <tr>
            <th width="20%" class="text-right">@lang('lang_v1.denomination')</th>
            <th width="20%">&nbsp;</th>
            <th width="20%" class="text-center">@lang('lang_v1.count')</th>
            <th width="20%">&nbsp;</th>
            <th width="20%" class="text-left">@lang('sale.subtotal')</th>
            </tr>
        </thead>
        <tbody>
            @foreach($register_details->denominations as $key => $value)
            <tr>
            <td class="text-right">{{$key}}</td>
            <td class="text-center">X</td>
            <td class="text-center">{{$value ?? 0}}</td>
            <td class="text-center">=</td>
            <td class="text-left">
                @format_currency($key * $value)
            </td>
            </tr>
            @php
            $total += ($key * $value);
            @endphp
            @endforeach
        </tbody>
        <tfoot>
            <tr>
            <th colspan="4" class="text-center">@lang('sale.total')</th>
            <td>@format_currency($total)</td>
            </tr>
        </tfoot>
        </table>
    </div>
    </div>
@endif

<div class="row">
    <div class="col-xs-6">
    <b>@lang('report.user'):</b> {{ $register_details->user_name}}<br>
    <b>@lang('business.email'):</b> {{ $register_details->email}}<br>
    <b>@lang('business.business_location'):</b> {{ $register_details->location_name}}<br>
    </div>
    @if(!empty($register_details->closing_note))
    <div class="col-xs-6">
        <strong>@lang('cash_register.closing_note'):</strong><br>
        {{$register_details->closing_note}}
    </div>
    @endif
</div>