@extends('layouts.main')
@section('content')
<div class="container-fluid">
    @if (session('sukses'))
        <div class="alert alert-success" role="alert">
            {{ session('sukses') }}
        </div>
    @elseif (session('gagal'))
        <div class="alert alert-danger" role="alert">
            {{ session('gagal') }}
        </div>
    @endif
    <div class="card text-bg-secondary border">
        <div class="card-header border-bottom">
            <label class="h4">{{__(Route::current()->getName().' : '.$query)}}</label>
            <div class="d-flex justify-content-between">
            <form class="d-flex" method="POST" action="{{ route('User Result') }} ">
                @csrf
                <input  type="text" name="query" id="query" value="{{old('query')}}" placeholder="Cari User ..">
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
            <a href="{{url('/user/create')}}" class="btn btn-primary ">Create User</a>
        </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
            <table class="table table-striped table-secondary table-hover">
                <thead class="bg-secondary">
                <tr>
                    <th>Name</th>
                    <th>Username</th>
                    <th>E-mail</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody class="bg-secondary">
                @foreach($user as $user)
                <tr>
                    <td>{{$user->name}}</td>
                    <td>{{$user->username}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->role}}</td>
                    <td class="d-flex justify-content-around">
                        <a class="btn btn-outline-info" href="{{url('profile/'.$user->id)}}">{{__('Show')}}</a>
                        <a class="btn btn-outline-warning" href="{{url('user/edit/'.$user->id)}}">{{__('Edit')}}</a>
                        <form class="d-flex" action="{{url('/user/delete/'.$user->id)}}" method="POST"><input type="hidden" name="_method" value="DELETE">
                            @csrf
                                    <button class="btn btn-outline-danger"> {{__('Delete')}} </button>
                                    </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
            </table>
        </div>
        </div>
    </div>
</div>
@endsection