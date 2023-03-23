@extends('layouts.bkash')

@section('content')
<div class="container">
    <br>
    <div style="display: flex; justify-content: flex-end; align-items: center;">
        <img src="/images/myradar-logo-blue.png" class="img-fluid mb-3" alt=/images/myradar-logo-blue.png">
    </div>

    <div class="row justify-content-center align-items-center">
        <div class="col-12 col-md-8 col-lg-6">
            <h2 class="text-center mb-3">myRADAR Bill Pay</h2>
            <form action="/bkash/pay" method="POST" id="bkashForm">
                {!! csrf_field() !!}
                <input type="hidden" id="user" name="user" value='{{ $user }}'>
                <div class="card mb-3">
                    <div class="card-body">
                        <p class="card-text">Mr. {{ $user->name }} Sir, Your total due bill
                            {{ number_format($total_due_bill) }} TK.</p>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-body">
                        <div>
                            <h4 class="card-title">Car Wise Due Bill</h4>
                        </div>

                        <?php $i=1; ?>

                        @foreach ($cars_bill_details as $car_bill_details)

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="cars[]"
                                value="{{ $car_bill_details['reg_no'] }}" checked>
                            <label class="form-check-label">{{ $car_bill_details['reg_no'] }}</label>
                            <input type="number" name="{{ $i }}" value="{{ $car_bill_details['bill'] }}"
                                class="form-control" style="width: 100px;">
                        </div>

                        <?php $i++; ?>
                        @endforeach
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Pay Now</button>
                </div>
            </form>
            <br>

            @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection