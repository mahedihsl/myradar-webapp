@php
   // dd($ipdata);
@endphp


@extends('layouts.new')

@push('style')

@endpush

@section('content')

<div class="row">
    <div class="col-md-12">
        @include('bkash.webhook.bkash_fillter',['data' => $params])
    </div>
</div>

<div class="row">
    <div class="col-md-12 table-responsive">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th class="col-xs-1 text-center">SL</th>         
                    <th class="col-xs-1 text-center">bKash Wallet No</th>
                    <th class="col-xs-1 text-center">Amount (BDT)</th>
                    <th class="col-xs-1 text-center">bKash trxID</th> 
                    <th class="col-xs-1 text-center">Pay Date</th>
                </tr>
            </thead>
            <tbody>
                @if ($ipdata->count())
                @php
                $start = ($ipdata->perPage() * ($ipdata->currentPage()-1)) + 1;
                @endphp

                @foreach ($ipdata as $key => $item)
                <tr>
                    <td class="text-center">{{$start +$key}}</td>
                    <td class="text-center">{{ $item->debitMSISDN }}</td>
                    <td class="text-center">{{ $item->amount }}</td>
                    <td class="text-center">{{ $item->trxID }}</td> 
                    <td class="text-center">{{ $item->created_at->format('j M Y g:i A') }}</td>
                </tr>

                @endforeach
                @endif
            </tbody>
        </table>
        @if ($ipdata->count())
        {!! $ipdata->links() !!}
        @endif
    </div>
</div>

@endsection