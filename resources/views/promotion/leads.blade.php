@extends('layouts.new')

@section('title')
  Campaign Leads
@endsection

@section('content')
  <div class="row">
    <div class="col-xs-12">
      {!! $leads->links() !!}
      <table class="table table-responsive table-striped">
        <thead>
          <tr>
            <th class="col-xs-4">Name</th>
            <th class="col-xs-4">Phone Number</th>
            <th class="col-xs-4">Email</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($leads as $lead)
            <tr>
              <td>{{$lead->name}}</td>
              <td>{{$lead->phone}}</td>
              <td>{{$lead->email}}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
      {!! $leads->links() !!}
    </div>
  </div>
@endsection

@push('script')

@endpush
