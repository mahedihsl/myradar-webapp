@extends('layouts.new')

@push('style')
  <style media="screen">
  .user-thumb {
      width: 45px;
      height: 45px;
      radius: 50%;
      margin: 10px auto;
  }
  .table > tbody > tr > td {
      vertical-align: middle;
  }
  .user-name {
      display: inline-block;
      margin-top: 12px;
  }
  .user-phone {
      display: block;
  }
  </style>
@endpush

@section('content')
  <div class="row">
    <div class="col-md-12 table-responsive">
      <table class="table table-hover table-striped">
        <thead>
          <tr>
            <th class="text-center col-xs-2">User Name</th>
            <th class="text-center col-xs-2">Phone No</th>
            <th class="text-center col-xs-2">Sender No</th>
            <th class="text-center col-xs-2">Bkash Trx ID</th>
            <th class="text-center col-xs-2">Car No</th>
            <th class="text-center col-xs-2">Amount</th>
          </tr>
        </thead>
        <tbody>
        @foreach ($all_successful_data as $successful_data)
          <tr>
            <th class="text-center col-xs-2">{{ $successful_data['user_name'] }}</th>
            <th class="text-center col-xs-2">{{ $successful_data['phone_no'] }}</th>
            <th class="text-center col-xs-2">{{ $successful_data['wallet_no'] }}</th>
            <th class="text-center col-xs-2">{{ $successful_data['trx_id'] }}</th>
            <th class="text-center col-xs-2">{{ $successful_data['car_no'] }}</th>
            <th class="text-center col-xs-2">{{ $successful_data['amount'] }}</th>
          </tr>
        @endforeach
        </tbody>
      </table>

    </div>
  </div>

  <div class="import-form">
    <form action="{{ URL::to('importExcel') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}<br/>
        <button class="btn btn-primary">Import Billing Info</button>
      </form>
    </div>

    <a class="btn btn-sm btn-default"href={{ asset('Files/import_file.xlsx') }}><i class="fa fa-download 2x"></i> Download Excel Template</a>
@endsection

@push('script')
<script type="text/javascript">
  $(function() {
    $('[data-toggle="datepicker"]').datepicker();

    $(".dev_check").change(function(){
      console.log(this);
    });

    $("#search_by").change(function(){
      $("#search_for").val('');
      if($(this).val()=='validity'){
        $("#search_for").prop("type", "date");
      } else {
        $("#search_for").prop("type", "text");
      }
    });
  });
</script>
@endpush
