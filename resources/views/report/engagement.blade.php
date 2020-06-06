@extends('layouts.new')

@push('style')

@endpush

@section('content')
  <div class="col-xs-12">
    <form class="form-inline" action="/engagement/report" method="get">
      <div class="form-group">
        <input type="text" class="form-control" placeholder="Customer Name" name="name" value="{{$params->get('name')}}">
      </div>
      <div class="form-group">
        <input type="text" class="form-control" placeholder="Phone Number" name="phone" value="{{$params->get('phone')}}">
      </div>
      <button type="submit" class="btn btn-success">
        <i class="fa fa-search"></i> Search
      </button>
      <a href="/engagement/report" class="btn btn-default">
        <i class="fa fa-close"></i> Clear
      </a>
      <a href="/engagement/export" class="btn btn-primary">
        <i class="fa fa-file-text"></i> Export
      </a>
    </form>
  </div>
  <div class="col-xs-12 table-responsive">
    <table class="table table-striped table-bordered">
      <thead>
        <tr>
          <th class="col-xs-1 text-center">SL</th>
          <th class="col-xs-2 text-center">Customer</th>
          <th class="col-xs-1 text-center">Cars</th>
          <th class="col-xs-2 text-center">{{ Carbon\Carbon::today()->format('j M') }}</th>
          <th class="col-xs-2 text-center">{{ Carbon\Carbon::yesterday()->format('j M') }}</th>
          <th class="col-xs-2 text-center">{{ Carbon\Carbon::today()->subDays(2)->format('j M') }}</th>
        </tr>
      </thead>
      <tbody>
        @php
          $start = ($items->perPage() * ($items->currentPage()-1)) + 1;
        @endphp
        @foreach ($items as $key => $item)
          @php
            $data = $item->getLatestActivity();
          @endphp
          <tr>
            <td class="text-center">{{ $start + $key }}</td>
            <td class="text-center">{{ $item->name }}</td>
            <td class="text-center">{{ $item->cars()->count() }}</td>
            <td class="text-center">
              <span class="text-success">open</span>-{{$data[0]['l']}} <br>
              <span class="text-primary">request</span>-{{$data[0]['r']}}
            </td>
            <td class="text-center">
              <span class="text-success">open</span>-{{$data[1]['l']}} <br>
              <span class="text-primary">request</span>-{{$data[1]['r']}}
            </td>
            <td class="text-center">
              <span class="text-success">open</span>-{{$data[2]['l']}} <br>
              <span class="text-primary">request</span>-{{$data[2]['r']}}
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
    {!! $items->links() !!}
  </div>
@endsection

@push('script')

@endpush
