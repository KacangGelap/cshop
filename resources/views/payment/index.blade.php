@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card text-bg-dark">
            <div class="card-header">
                <h1> Your Balance : {{number_format(Auth::user()->ewallet, 0, ',', '.')}} &nbsp;<i class="bi-box"></i></h1>
            </div>
            <div class="row card-body justify-content-center">
                @foreach($data as $item)
                  
                    <div class="card col-3 border-4 border-dark py-0">
                        <a href="{{url('/billing/'.$item->id)}}" class="nav-link">
                        <div class="card-header" style="background-image: url({{$item->image}});height:200px;background-size:cover;background-position:center">
                        </div>
                        <div class="card-body">
                            <p class="card-title ">{{($item->payment)}} </p>
                            <h5>{{number_format($item->amount, 0, ',', '.')}} <i class="bi-box"></i></h5>      
                        </div>
                        
                        <div class="d-flex card-footer justify-content-center">
                              <button type="button" class="btn btn-primary fs-5">Rp. {{number_format($item->price, 0, ',', '.')}}</button>
                        </div>     
                    </a>
                    </div>
                   
                    @endforeach
            </div>
        </div>
    </div>
@endsection