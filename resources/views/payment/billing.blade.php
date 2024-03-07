@extends('layouts.main')
@section('content')
    <div class="container-fluid">
        <div class="row py-3 text-light">
            <span class="col-3">
                <img src="{{$data->image}}" class="w-100">
            </span>
            <span class="col-5">
                <h1>{{$data->payment}}</h1>
                <h3>{{number_format($data->amount, 0, ',', '.')}}&nbsp;<i class="bi-box"></i></h3>
            </span>
            <div class="row justify-content-center">
                <div class="card">
                    <div class="card-header">
                        {{__('Confirm Your Identity')}}
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <label class="col-md-6 col-form-label">{{ __('Nama') }}</label>
                            <div class="col-md-6">
                                <input type="text"  class="form-control text-end" value="{{Auth::user()->name}}" disabled>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-md-6 col-form-label">{{ __('Jenis Transaksi') }}</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control text-end" value="{{__($data->payment.' ('.$data->amount.' )')}}" disabled>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-md-6 col-form-label">{{ __('Nominal') }}</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control text-end" value="Rp. {{number_format($data->price, 0, ',', '.')}}" disabled>
                            </div>
                        </div>
                        <hr>
                        <form action="{{url('/billing/'.$data->id)}}" method="post">
                            @csrf
                            <div class="row mb-3">
                                <label for="password" class="col-md-6 col-form-label text-md-end">{{ __('Confirm your password') }}</label>
    
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
    
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-6">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Confirm Payment') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>    
            </div> 
        </div>
    </div>
@endsection