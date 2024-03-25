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
        <div class="card-body row d-flex justify-content-around">
           
            @if (NULL != $current_items->first())
                @foreach($current_items as $item)
                <div class="card col-3 px-0 border-dark border-4">
                    <a href="{{url('/item/'.$item->id)}}" class="open-modal-link" data-bs-target="{{url('/item/'.$item->id.'#myModal')}}">
                    <div class="card-header" style="background-image: url({{$item->item->foto1}});height:200px;background-size:cover;background-position:center" placeholder="{{$item->item->description}}">
                        @if($item->item->status == 'Tersedia')<button class="btn btn-primary" disabled>{{$item->item->status}}</button>@else<button class="btn btn-light text-muted" disabled>{{$item->item->status}}</button> @endif
                    </div>
                    </a>
                    <div class="card-body">
                        <h4 class="card-title">{{Str::limit($item->item->item_name, 27)}} </h4>
                            <input class="form-control" type="number" name="item_count" id="item_count" value="{{$item->item_count}}">
                        <h5>Rp. {{number_format(($item->item->item_price * $item->item_count), 0, ',', '.') }}</h5>
                    </div>
                    <div class="card-footer row">
                        <a class="btn btn-warning col-md-6 border-4 border-light" href="{{url('/checkout/'.Auth::user()->id.'/'.$item->id)}}">{{__('Checkout')}}</a>
                        <form class="col-md-6 mx-0" action="{{url('delete/'.$item->id)}}" method="POST"><input type="hidden" name="_method" value="DELETE">
                            @csrf
                                    <button class="btn btn-danger border-4 border-light w-100"> {{__('Delete')}} </button>
                                    </form>
                    </div>               
                </div>
                
                @endforeach
            @else
                <div class="text-light text-center mb-5">Tidak ada barang nih di Keranjang.</div>
            @endif    
        </div>
        <div class="card-footer row d-flex justify-content-around">
            <div class="text-light text-center pb-5">Produk yang mungkin anda suka</div>
            @foreach($items as $item)
                    @if($item->user_id != Auth::user()->id )
                    <div class="card col-lg-3 px-0 border-dark border-4">
                        <a href="{{url('/item/'.$item->id)}}">
                            <div class="card-header" style="background-image: url({{$item->foto1}});height:200px;background-size:cover;background-position:center" placeholder="{{$item->description}}">
                                @if($item->status == 'Tersedia')<button class="btn btn-primary" disabled>{{$item->status}}</button>@else<button class="btn btn-light text-muted" disabled>{{$item->status}}</button> @endif
                            </div>
                        </a>
                        <div class="card-body">
                            <h4 class="card-title h-50">{{Str::limit($item->item_name, 40)}} </h4>
                            <h5>Rp. {{number_format($item->item_price, 0, ',', '.')}}</h5>
                            @if ($item->status == 'Tersedia')<p class="text-muted">{{$item->item_count}} produk tersisa</p> @endif
                        </div>
                        <div class="card-footer row">
                        
                        </div>               
                    </div>
                    @endif
                    @endforeach
        </div>
    </div>
</div>
@endsection