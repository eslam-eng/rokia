@extends('layouts.app')

@section('title',__('app.invoices.invoices'))
@section('content')
    {{--    breadcrumb --}}
    @include('layouts.components.breadcrumb',['title' => trans('app.invoices.invoice_page_title'),'first_list_item' => trans('app.invoices.invoices'),'last_list_item' => trans('app.invoices.all_invoices')])
    {{--    end breadcrumb --}}
    <!--Row-->
    <!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card custom-card">
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>@lang('app.therapists.name')</th>
                            <th>@lang('app.therapists.therapist_commission')</th>
                            <th>@lang('app.clients.name')</th>
                            <th>@lang('app.clients.phone')</th>
                            <th>@lang('app.invoices.invoice_items.type')</th>
                            <th>@lang('app.invoices.invoice_items.item_details')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($invoice->invoiceItems->isNotEmpty())
                            @foreach($invoice->invoiceItems as $invoiceItem)
                                <tr>
                                    <td>{{$invoice->therapist->name }}</td>
                                    <td>{{$invoiceItem->therapist_commission }}%</td>
                                    <td>{{$invoiceItem->client->name}}</td>
                                    <td>{{$invoiceItem->client->phone}}</td>
                                    <td>@include('components._datatable-badge',['text' => \App\Enums\InvoiceItemTypeEnum::from($invoiceItem->type)->getLabel(),'class' =>  'badge-success'])</td>
                                    <td>
                                        <table>
                                            <tr>
                                                @foreach($invoiceItem->details_object as $key => $value)
                                                    @if($key=='type' || $value == null) @continue @endif
                                                    <td class="bg-info-transparent">{{ucfirst($key)}}</td>
                                                    <td>{{ $value !== null ? $value : 'N/A' }}</td>
                                                @endforeach
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6">@lang('app.general.no_data_available')</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- End Row -->

@endsection

