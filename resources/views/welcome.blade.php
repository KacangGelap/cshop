@extends('layouts.app')
@section('content')
        <div class="h-100 text-center text-primary" style="background-image:url('{{asset('img/bg-welcome.jpg')}}'); background-size: cover;">
            <div class="container-fluid py-4" style="background-color:rgba(0,0,0,0.5); top:0;right:0;left:0;">
                <img src="{{asset('img/favicon.png')}}" class="d-block m-auto w-25">
                <h1 class="">{{config('app.name')}}</h1>
                <h5 class="">cyka blyat, just use our app to buy smthng</h5>
           </div>
        </div>
@endsection

