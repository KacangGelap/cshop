@extends('layouts.main')

@section('content')
{{-- <meta http-equiv="refresh" content="5"> --}}
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (session('status'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
