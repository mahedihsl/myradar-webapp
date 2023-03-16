@extends('layouts.new')

@push('style')
<style>
  table {
    border-collapse: collapse;
    width: 100%;
  }

  th,
  td {
    padding: 10px;
    text-align: center;
  }

  th {
    background-color: #f2f2f2;
    font-weight: bold;
    text-transform: uppercase;
    font-size: 14px;
    letter-spacing: 1px;
    border: 1px solid #ddd;
  }

  th:first-child {
    border-top-left-radius: 5px;
    border-bottom-left-radius: 5px;
  }

  th:last-child {
    border-top-right-radius: 5px;
    border-bottom-right-radius: 5px;
  }

  tr:nth-child(even) {
    background-color: #f9f9f9;
  }

  tr:hover {
    background-color: #e3e3e3;
  }
</style>
@endpush

@section('content')

<div class="row">
  <div class="col-md-12 table-responsive">
    <table class="table table-hover table-striped">
      <thead>
        <tr>
          <th>Customer Name</th>
          <th>Customer Phone No</th>
          <th>bKash Wallet No</th>
          <th>Car No</th>
          <th>Amount (BDT)</th>
          <th>Pay Date</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($all_successful_data as $successful_data)
        <tr>
          <td>{{ $successful_data['user_name'] }}</td>
          <td>{{ $successful_data['phone_no'] }}</td>
          <td>{{ $successful_data['wallet_no'] }}</td>
          <td>{{ $successful_data['car_no'] }}</td>
          <td>{{ $successful_data['amount'] }}</td>
          <td>{{ date_format($successful_data['updated_at'], 'j M Y g:i A') }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
    <a class="btn btn-sm btn-default"href={{ asset('Files/import_file.xlsx') }}><i class="fa fa-download 2x"></i> Download Excel File</a>
@endsection

