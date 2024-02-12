@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if($message=Session::get('status'))
                    <div class="alert alert-danger">
                        <h2>{{$message}}</h2>
                    </div>
                    @endif
            <div class="card text-bg-secondary border" >
                <div class="card-header border-bottom" ><span style="float:right"><a href="{{ url()->previous() }}" class="text-white">&larr;Back</a></span>{{ __(Route::current()->getName()) }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ url('user/passchange/'.$user->id) }}" >
                        <input type="hidden" name="_method" value="PUT">
                       @csrf
                        <div class="form-group">
                            <label for="current" class="col-md-4 control-label">{{ __('current Password') }}</label>
                                <input id="current" type="password" class="form-control" name="current" autocomplete="current" placeholder="">

                                @error('current')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="form-group">
                            <label for="new" class="col-md-4 control-label">{{ __('New Password') }}</label>
                                <input id="new" type="password" class="form-control" name="new" autocomplete="new" placeholder="">

                                @error('new')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="form-group">
                            <label for="new-confirm" class="col-md-4 control-label">{{ __('Confirm Password') }}</label>
                                <input id="new-confirm" type="password" class="form-control" name="new_confirmation" autocomplete="new">
                        </div>
                        <hr>
                        <div class="d-flex justify-content-end">
                            
                                <button type="submit" class="btn btn-primary col-md-3">
                                    {{ __('Change Password') }}
                                </button>
                            
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
