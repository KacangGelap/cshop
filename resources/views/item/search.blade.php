@extends('layouts.main')
@section('content')
<div class="container-fluid">
    <div class="card text-bg-secondary border">
        <div class="card-header border-bottom">
            <p>{{__(Route::current()->getName())}}</p>
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
                    <td>
                        <a class="btn btn-outline-info" href="{{url('user/'.$user->id)}}">{{__('Show')}}</a>
                        <a class="btn btn-outline-warning" href="{{url('user/edit/'.$user->id)}}">{{__('Edit')}}</a>
                        <a class="btn btn-outline-danger" href="{{url('user/delete/'.$user->id)}}">{{__('Remove')}}</a>
                        <form>
                            @csrf
                            <input class="visually-hidden">
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