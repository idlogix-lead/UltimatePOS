@extends('layouts.app')
@section('title', __('expense.expenses'))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>@lang('expense.expenses')</h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            @component('components.filters', ['title' => __('report.filters')])
                @if(auth()->user()->can('all_expense.access'))
                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::label('location_id',  __('purchase.business_location') . ':') !!}
                            {!! Form::select('location_id', $business_locations, null, ['class' => 'form-control select2', 'style' => 'width:100%']); !!}
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            {!! Form::label('expense_for', __('expense.expense_for').':') !!}
                            {!! Form::select('expense_for', $users, null, ['class' => 'form-control select2', 'style' => 'width:100%']); !!}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::label('expense_contact_filter',  __('contact.contact') . ':') !!}
                            {!! Form::select('expense_contact_filter', $contacts, null, ['class' => 'form-control select2', 'style' => 'width:100%', 'placeholder' => __('lang_v1.all')]); !!}
                        </div>
                    </div>
                @endif
                <div class="col-md-3">
                    <div class="form-group">
                        {!! Form::label('expense_category_id',__('expense.expense_category').':') !!}
                        {!! Form::select('expense_category_id', $categories, null, ['placeholder' =>
                        __('report.all'), 'class' => 'form-control select2', 'style' => 'width:100%', 'id' => 'expense_category_id']); !!}
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        {!! Form::label('expense_sub_category_id_filter',__('product.sub_category').':') !!}
                        {!! Form::select('expense_sub_category_id_filter', $sub_categories, null, ['placeholder' =>
                        __('report.all'), 'class' => 'form-control select2', 'style' => 'width:100%', 'id' => 'expense_sub_category_id_filter']); !!}
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        {!! Form::label('expense_date_range', __('report.date_range') . ':') !!}
                        {!! Form::text('date_range', null, ['placeholder' => __('lang_v1.select_a_date_range'), 'class' => 'form-control', 'id' => 'expense_date_range', 'readonly']); !!}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        {!! Form::label('expense_payment_status',  __('purchase.payment_status') . ':') !!}
                        {!! Form::select('expense_payment_status', ['paid' => __('lang_v1.paid'), 'due' => __('lang_v1.due'), 'partial' => __('lang_v1.partial')], null, ['class' => 'form-control select2', 'style' => 'width:100%', 'placeholder' => __('lang_v1.all')]); !!}
                    </div>
                </div>
            @endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            @component('components.widget', ['class' => 'box-primary', 'title' => __('expense.all_expenses')])
                @can('expense.add')
                    @slot('tool')
                        <div class="box-tools">
                            <a class="btn btn-block btn-primary" href="{{action([\App\Http\Controllers\ExpenseController::class, 'create'])}}">
                            <i class="fa fa-plus"></i> @lang('messages.add')</a>
                        </div>
                    @endslot
                @endcan
                <div class="table-responsive">
                    @include("expense.partials.list")
                </div>
            @endcomponent
        </div>
    </div>

</section>
<!-- /.content -->
<!-- /.content -->
<div class="modal fade payment_modal" tabindex="-1" role="dialog" 
    aria-labelledby="gridSystemModalLabel">
</div>

<div class="modal fade edit_payment_modal" tabindex="-1" role="dialog" 
    aria-labelledby="gridSystemModalLabel">
</div>
@stop
@section('javascript')
 <script src="{{ asset('js/payment.js?v=' . $asset_v) }}"></script>
@endsection