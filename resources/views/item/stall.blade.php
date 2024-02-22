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
            <div class="pb-4">
                <a href="{{url('/stall/'.Auth::user()->id.'/create')}}" class="btn btn-outline-primary">Tambah Barang Anda</a>
            </div>
        </div>
        <div class="card-body row d-flex justify-content-around">
           
            @if (NULL != $current_items->first())
                @foreach($current_items as $item)
                <div class="card col-3 px-0 border-dark border-4">
                    <div class="card-header" style="background-image: url({{$item->foto1}});height:200px;background-size:cover;background-position:center" placeholder="{{$item->description}}">
                        @if($item->status == 'Tersedia')<button class="btn btn-primary" disabled>{{$item->status}}</button>@else<button class="btn btn-light text-muted" disabled>{{$item->status}}</button> @endif
                    </div>
                    <div class="card-body">
                        <h4 class="card-title">{{Str::limit($item->item_name, 27)}} </h4>
                        <h5>Rp. {{number_format($item->item_price, 0, ',', '.')}}</h5>
                        @if ($item->status == 'Tersedia')<p class="text-muted">{{$item->item_count}} produk tersisa</p> @endif
                    </div>
                    <div class="card-footer row">
                            
                        <div class="btn-group p-1">
                            <a href="{{url('stall/'.Auth::user()->id.'/edit/'.$item->id)}}" class="btn btn-success">Edit Barang</a>
                            <a href="{{url('stall/'.Auth::user()->id.'/'.$item->id)}}" class="btn btn-warning">Live View</a>    
                        </div>
                        <br>
                        <form action="{{ url( '/stall/'.Auth::user()->id.'/item/delete/'.$item->id ) }}" method="POST" class="p-1">
                                <input type="hidden" name="_method" value="DELETE">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger w-100">Hapus</button>
                        </form>
                    </div>               
                </div>
                
                @endforeach
            @else
                <div class="text-light text-center">Tidak ada barang nih di kios.</div>
            @endif    
        </div>
    </div>
</div>
@endsection