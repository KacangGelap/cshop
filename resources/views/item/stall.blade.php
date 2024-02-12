@extends('layouts.main')
@section('content')
<div class="container-fluid">
    @if (session('sukses'))
        <div class="alert alert-success text-success" role="alert" >
            {{ session('sukses') }}
        </div>
    @elseif (session('gagal'))
        <div class="alert alert-danger" role="alert" >
            {{ session('gagal') }}
        </div>
    @endif
    <div class=" card text-bg-dark ">
        <div class="card-header">
            {{__(Route::current()->getName())}}
        </div>
        <div class="flex row card-body justify-content-center align-center">
            <div class="row pb-4">
                <a href="{{url('/stall/'.$user->id.'/create')}}" class="btn btn-outline-primary col-3">Tambah Barang Anda</a>
            </div>
            
            @foreach($current_items as $item)
            <div class="flex card col-6 m-5 justify-content-center">
                <div class="card-header">
                   
                        <div class="">{{$item->item->item_name}}</div>

                    <div class="col-3 offset-3 text-center"><p class=" text-bg-success form-control mb-0">{{$item->item->status}}</p></div>

                    
                </div>
                <div class="card-body">
                   
                        <h2 class="col-5">Rp. {{number_format($item->item->item_price, 0, ',', '.')}}</h2>
                        @if($item->status !=='lunas')
                        <a class="col-2 btn btn-primary" href="{{url('lunasin/'.$item->id)}}">tandai lunas</a>
                        @endif
                        <form action="{{ url( '/pemasukan/'.$item->nota_id.'/item/delete/'.$item->id ) }}" method="POST" class="row col-3" >
                            <input type="hidden" name="_method" value="DELETE">
                        @csrf
                        <button type="submit" class="btn btn-danger w-100">Hapus</button>
                            </div>
                        </form>

            </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection