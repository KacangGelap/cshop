@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if($message=Session::get('Error'))
                    <div class="alert alert-danger">
                        <h2>{{$message}}</h2>
                    </div>
                    @endif
            <div class="card text-bg-secondary border" >
                <div class="card-header border-bottom" ><span style="float:right"><a href="{{ url()->previous() }}" class="text-white">&larr;Back</a></span>{{ __(Route::current()->getName()) }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ url('user/edit/'.$user->id) }}" >
                        <input type="hidden" name="_method" value="PUT">
                       @csrf

                       <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-12">
                                <input id="name" type="text" class="form-control border" name="name" value="{{ $user->name }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                            <label for="username" class="col-md-4 control-label">username</label>

                            <div class="col-md-12">
                                <input id="username" type="text" class="form-control border" name="username" value="{{ $user->username }}" required autofocus>

                                @if ($errors->has('username'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        @if (Auth::user()->role == 'admin')
                        <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
                            <label for="roles" class="col-md-4 control-label">roles</label>

                            <div class="col-md-12">
                                <select name="roles" id="roles" class="form-control border" >
                                    <option value="admin" >{{__('admin')}}</option>
                                    <option value="user" >{{__('user')}}</option>
                                    <option value="courier" >{{__('courier')}}</option>
                                </select>
                            </div>
                        </div>
                        @endif
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Email</label>

                            <div class="col-md-12">
                                <input id="email" type="email" class="form-control border" name="email" value="{{ $user->email }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-end">
                            
                                <button type="submit" class="btn btn-primary col-md-3">
                                    {{ __('Edit') }}
                                </button>
                            
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
