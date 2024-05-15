@extends('layouts.main')
@section('content')
    <div class="d-flex conteiner justify-content-around py-5">
        <div class="card text-bg-secondary border col-8">
            <div class="card-header border-bottom">
                <label>{{__(Route::current()->getName())}}</label>
            </div>
            <div class="card-body">
                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between border-0 text-bg-secondary"><b>Nama Anda</b>
                    <span class="badge-pill">{{$user->name}}</span>    
                </li>
                <li class="list-group-item d-flex justify-content-between border-0 text-bg-secondary"><b>Username</b>
                    <span class="badge-pill">{{$user->username}}</span>    
                </li>
                <li class="list-group-item d-flex justify-content-between border-0 text-bg-secondary"><b>E-mail</b>
                    <span class="badge-pill">{{$user->email}}</span>    
                </li>
            </ul>
            @if(Auth::user()->role == 'admin' && Auth::user()->id != $user->id)
            <hr>
                <label><b>Admin Privilege</b></label>
                
            <ul class="list-group">
                <br>
                <li class="list-group-item d-flex justify-content-between border-0 text-bg-secondary row">
                    
                    <button type="button" class="btn btn-info col-3" data-bs-toggle="modal" data-bs-target="#suspend">
                        @if($user->suspension =='False')Suspend Account @else Appeal Ban @endif
                    </button>
                    
                    <!-- The Modal -->
                    <div class="modal" id="suspend">
                        <div class="modal-dialog">
                        <div class="modal-content text-bg-secondary">
                    
                            <!-- Modal Header -->
                            <div class="modal-header">
                            <h4 class="modal-title">Achtung!</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                    
                            <!-- Modal body -->
                            <div class="modal-body">
                            @if($user->suspension=='False')Are you sure you want to ban this account?@else Appeal the ban? @endif<br>
                            
                            </div>
                    
                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <button class="btn btn-primary" data-bs-dismiss="modal">No, I change my mind</button>
                                @if($user->suspension == 'False')
                                <form action="{{url('/user/suspend/'.$user->id)}}" method="POST">
                                    @csrf
                                            <button class="btn btn-danger"> Suspend Account </button>
                                            </form>
                                @else
                                <form action="{{url('/user/appeal/'.$user->id)}}" method="POST">
                                    @csrf
                                            <button class="btn btn-success"> Appeal Suspend </button>
                                            </form>
                                @endif
                            </div>
                    
                        </div>
                        </div>
                    </div>
                <a href="{{url('user/passchange/'.$user->id)}}" class="btn btn-primary col-3" > Change Password </a>
                <!-- Button to Open the Modal -->
                <button type="button" class="btn btn-danger col-3" data-bs-toggle="modal" data-bs-target="#myModal">
                    Delete Account
                </button>
                
                <!-- The Modal -->
                <div class="modal" id="myModal">
                    <div class="modal-dialog">
                    <div class="modal-content text-bg-secondary">
                
                        <!-- Modal Header -->
                        <div class="modal-header">
                        <h4 class="modal-title">Achtung!</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                
                        <!-- Modal body -->
                        <div class="modal-body">
                        Are you sure you want to delete this account?<br>
                        Your current action may not be reverted
                        </div>
                
                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button class="btn btn-primary" data-bs-dismiss="modal">No, I change my mind</button>
                            <form action="{{url('/user/delete/'.$user->id)}}" method="POST"><input type="hidden" name="_method" value="DELETE">
                                @csrf
                                        <button class="btn btn-danger"> Delete Account </button>
                                        </form>
                        </div>
                
                    </div>
                    </div>
                </div>
                </li>
            </ul>
            @else
            <hr>
                <label><b>Settings</b></label>
                
            <ul class="list-group">
                <br>
                <li class="list-group-item d-flex justify-content-between border-0 text-bg-secondary row">
                <a href="{{url('user/edit/'.$user->id)}}" class="btn btn-info col-3" style="color:white"> Edit Profile </a>
                <a href="{{url('user/passchange/'.$user->id)}}" class="btn btn-primary col-3" > Change Password </a>
                <!-- Button to Open the Modal -->
                <button type="button" class="btn btn-danger col-3" data-bs-toggle="modal" data-bs-target="#myModal">
                    Delete Account
                </button>
                
                <!-- The Modal -->
                <div class="modal" id="myModal">
                    <div class="modal-dialog">
                    <div class="modal-content text-bg-secondary">
                
                        <!-- Modal Header -->
                        <div class="modal-header">
                        <h4 class="modal-title">Achtung!</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                
                        <!-- Modal body -->
                        <div class="modal-body">
                        Are you sure you want to delete this account?<br>
                        Your current action may not be reverted
                        </div>
                
                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button class="btn btn-primary" data-bs-dismiss="modal">No, I change my mind</button>
                            <form action="{{url('/user/delete/'.$user->id)}}" method="POST"><input type="hidden" name="_method" value="DELETE">
                                @csrf
                                        <button class="btn btn-danger"> Delete Account </button>
                                        </form>
                        </div>
                
                    </div>
                    </div>
                </div>
                </li>
            </ul>
            @endif
            </div>
        </div>
    </div>
@endsection