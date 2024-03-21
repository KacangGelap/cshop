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
    <div class="card text-bg-dark">
        <div class="card-header d-flex justify-content-between">
            {{__(Route::current()->getName())}}
        </div>
        <div class="card-body row">
           
            @if (NULL != $ship->first())
                @foreach($ship as $item)
                <div class="card col-md-3 px-0 border-dark border-4">
                    <div class="card-header" style="background-image: url({{$item->item->foto1}});height:200px;background-size:cover;background-position:center" placeholder="{{$item->description}}">
                        <button class="btn btn-primary" disabled>{{$item->status}}</button>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title h-50">{{Str::limit($item->item->item_name, 27)}} </h4>
                        <h5>Rp. {{number_format($item->total_price, 0, ',', '.')}}</h5>
                        @if ($item->status == 'Tersedia')<p class="text-muted">{{$item->item_count}} produk tersisa</p> @endif
                    </div>
                    <div class="card-footer row">
                        <form action="{{ url( '/stall/'.Auth::user()->id.'/item/delete/'.$item->id ) }}" method="POST" class="p-1">
                                <input type="hidden" name="_method" value="DELETE">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger w-100">Batalkan Pesanan</button>
                        </form>
                    </div>               
                </div>
                
                @endforeach
            @else
                <div class="text-light text-center">Tidak ada barang nih. Tambah pesanan yuk ! </div>
            @endif    
        </div>
    </div>
</div>
@endsection