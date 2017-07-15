@extends('layouts.main')

@section('content')
<div id="main-content">
    <div class="content">
        <div class="title m-b-md">
            <a href="/" style="text-decoration: none">Car Wash</a>
        </div>

        <div class="washes">
            <h1 class="specialTitle">Transaction History</h1>
            <hr style="margin-bottom:25px;">
            @foreach($transactions as $transaction)
                <div class="row">
                    <div class="col s12 m6" style="margin:auto">
                        <div class="card blue-grey darken-1">
                            <div class="card-content white-text">
                                <span class="card-title">Wash on {{$transaction->created_at->format('M-d-Y')}}</span>
                                <ul>
                                    <li>Type: {{$transaction->vehicle()->first()->type}}</li>
                                    <li>Price: ${{$transaction->price}}</li>
                                    <li>Transaction ID: {{$transaction->id}}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection