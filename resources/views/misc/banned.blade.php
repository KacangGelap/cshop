@extends('layouts.app')
@section('content')
<div class="container-fluid min-vh-100">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card bg-dark text-white">
                <div class="card-body justify-content-center text-center">
                    <i class="fs-1 text-danger bi bi-ban"></i>
                    <h2>Sorry, Your account have been suspended</h2>
                    <hr>
                    <h5>We have received suspicious behaviour on your account.<br> to appeal your ban, contact the admin at <a href="mailto:12211030@student.itk.ac.id">11211030@student.itk.ac.id</a></h5>
                    <br><br>
                    <a class="btn btn-primary" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Return to menu') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                </div>
            </div>
        </div>
    </div>
    
        
    
    </div>
</div>
@endsection