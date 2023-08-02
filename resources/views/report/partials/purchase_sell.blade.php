
<div class="row">
        <div class="col-xs-6">
            @component('components.widget', ['title' => __('purchase.purchases')])
                <table class="table table-striped">
                    <tr>
                        <th>{{ __('report.total_purchase') }}:</th>
                        <td>
                            <span class="total_purchase">
                                <i class="fas fa-sync fa-spin fa-fw"></i>
                                <span {{isset($api)?"":"hidden"}}>{{isset($symbol)?$symbol:null}} {{isset($api["purchase"]["total_purchase_exc_tax"])?round($api["purchase"]["total_purchase_exc_tax"],2):0}}</span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>{{ __('report.purchase_inc_tax') }}:</th>
                        <td>
                             <span class="purchase_inc_tax">
                                <i class="fas fa-sync fa-spin fa-fw"></i>
                                <span {{isset($api)?"":"hidden"}}>{{isset($symbol)?$symbol:null}} {{isset($api["purchase"]["total_purchase_inc_tax"])?round($api["purchase"]["total_purchase_inc_tax"],2):0}}</span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>{{ __('lang_v1.total_purchase_return_inc_tax') }}:</th>
                        <td>
                             <span class="purchase_return_inc_tax">
                                <i class="fas fa-sync fa-spin fa-fw"></i>
                                <span {{isset($api)?"":"hidden"}}>{{isset($symbol)?$symbol:null}} {{isset($api["total_purchase_return"])?round($api["total_purchase_return"],2):0}}</span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>{{ __('report.purchase_due') }}: @show_tooltip(__('tooltip.purchase_due'))</th>
                        <td>
                             <span class="purchase_due">
                                <i class="fas fa-sync fa-spin fa-fw"></i>
                                <span {{isset($api)?"":"hidden"}}>{{isset($symbol)?$symbol:null}} {{isset($api["purchase"]["purchase_due"])?round($api["purchase"]["purchase_due"],2):0}}</span>
                            </span>
                        </td>
                    </tr>
                </table>
            @endcomponent
        </div>

        <div class="col-xs-6">
            @component('components.widget', ['title' => __('sale.sells')])
                <table class="table table-striped">
                    <tr>
                        <th>{{ __('report.total_sell') }}:</th>
                        <td>
                            <span class="total_sell">
                                <i class="fas fa-sync fa-spin fa-fw"></i>
                                <span {{isset($api)?"":"hidden"}}>{{isset($symbol)?$symbol:null}} {{isset($api["sell"]["total_sell_exc_tax"])?round($api["sell"]["total_sell_exc_tax"],2):0}}</span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>{{ __('report.sell_inc_tax') }}:</th>
                        <td>
                             <span class="sell_inc_tax">
                                <i class="fas fa-sync fa-spin fa-fw"></i>
                                <span {{isset($api)?"":"hidden"}}>{{isset($symbol)?$symbol:null}} {{isset($api["sell"]["total_sell_inc_tax"])?round($api["sell"]["total_sell_inc_tax"],2):0}}</span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>{{ __('lang_v1.total_sell_return_inc_tax') }}:</th>
                        <td>
                             <span class="total_sell_return">
                                <i class="fas fa-sync fa-spin fa-fw"></i>
                                <span {{isset($api)?"":"hidden"}}>{{isset($symbol)?$symbol:null}} {{isset($api["total_sell_return"])?round($api["total_sell_return"],2):0}}</span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>{{ __('report.sell_due') }}: @show_tooltip(__('tooltip.sell_due'))</th>
                        <td>
                            <span class="sell_due">
                                <i class="fas fa-sync fa-spin fa-fw"></i>
                                <span {{isset($api)?"":"hidden"}}>{{isset($symbol)?$symbol:null}} {{isset($api["sell"]["invoice_due"])?round($api["sell"]["total_sell_inc_tax"],2):0}}</span>
                            </span>
                        </td>
                    </tr>
                </table>
            @endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            @component('components.widget')
                @slot('title')
                    {{ __('lang_v1.overall') }} 
                    ((@lang('business.sale') - @lang('lang_v1.sell_return')) - (@lang('lang_v1.purchase') - @lang('lang_v1.purchase_return')) ) 
                    @show_tooltip(__('tooltip.over_all_sell_purchase'))
                @endslot
                <h3 class="text-muted">
                    {{ __('report.sell_minus_purchase') }}: 
                    <span class="sell_minus_purchase">
                        <i class="fas fa-sync fa-spin fa-fw"></i>
                        <span {{isset($api)?"":"hidden"}}>{{isset($symbol)?$symbol:null}} {{isset($api["difference"]["total"])?round($api["difference"]["total"],2):0}}</span>
                    </span>
                </h3>

                <h3 class="text-muted">
                    {{ __('report.difference_due') }}: 
                    <span class="difference_due">
                        <i class="fas fa-sync fa-spin fa-fw"></i>
                        <span {{isset($api)?"":"hidden"}}>{{isset($symbol)?$symbol:null}} {{isset($api["difference"]["due"])?round($api["difference"]["due"],2):0}}</span>
                    </span>
                </h3>
            @endcomponent
        </div>
    </div>