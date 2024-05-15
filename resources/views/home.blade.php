@extends('layouts.main')

@section('content')
{{-- <meta http-equiv="refresh" content="5"> --}}
<div class="container-fluid">
    <div class="row justify-content-center">
            @if (session('sukses'))
                <div class="alert alert-success" role="alert">
                    {{ session('sukses') }}
                </div>
            @endif
            @if (session('status'))
                <div class="alert alert-danger" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            @if(Auth::user()->role == 'user')
            <div class="card text-bg-dark">
                <div class="card-header"> </div>
                <div class="card-body justify-content-center">
                    @if($cart->count() > 0)<div class="alert alert-warning text-center">anda mempunyai barang di keranjang.<a href="{{url('/cart/'.Auth::user()->id)}}">Lihat Disini</a></div>@endif
                    {{-- 3 panel --}}
                    <div class="row justify-content-center text-center alert bg-secondary mx-auto">

                        <span class="alert alert-primary mx-2 position-relative col-md-3">
                            <a href="{{url('/user/'.Auth::user()->id.'/wallet')}}" class="nav-link">
                                <i class="fs-3 bi-box"></i><p>{{number_format(Auth::user()->ewallet, 0, ',', '.')}}<br>CubeCoins</p>
                            </a>
                            @if (Auth::user()->ewallet < 10000)<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning">&nbsp;</span>@endif
                        </span>

                        <span class="alert alert-primary mx-2 position-relative col-md-3">
                            <a href="{{url('/cart/'.Auth::user()->id)}}" class="nav-link">
                                <i class="fs-3 bi-cart"></i><p>{{$cart->count()}}<br>Items in cart</p>
                            </a>

                            @if ($cart->count() > 0)<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">&nbsp;</span>@endif
                        </span>
                        <span class="alert alert-primary mx-2 position-relative col-md-3">
                            <a href="{{url('shipment/'.Auth::user()->id)}}" class="nav-link">
                                <i class="fs-3 bi-truck"></i><p>{{$ship->where('user_id',Auth::user()->id)->count()}}<br>Your Orders</p>
                            </a>
                        </span>
                        <hr>
                        {{-- categories --}}
                        <div class="row justify-content-center">
                            <a class="btn alert alert-danger col-md-2 border-5 border-secondary" href="{{url('/category/'.$category->find(1)->id)}}"><i class="fs-3 bi-plug"></i><br>{{$category->find(1)->categories}}</a>
                            <a class="btn alert alert-warning col-md-2 border-5 border-secondary" href="{{url('/category/'.$category->find(2)->id)}}"><i class="fs-3 bi-display"></i><br>{{$category->find(2)->categories}}</a>
                            <a class="btn alert alert-success col-md-2 border-5 border-secondary" href="{{url('/category/'.$category->find(3)->id)}}"><i class="fs-3 bi-phone"></i><br>{{$category->find(3)->categories}}</a>
                            <a class="btn alert alert-info col-md-2 border-5 border-secondary" href="{{url('/category/'.$category->find(4)->id)}}"><i class="fs-3 bi-house-up"></i><br>{{$category->find(4)->categories}}</a>
                            <a class="btn alert alert-dark col-md-2 border-5 border-secondary" href="{{url('/category/'.$category->find(5)->id)}}"><i class="fs-3 bi-bicycle"></i><br>{{$category->find(5)->categories}}</a>
                            <a class="btn alert alert-light col-md-2 border-5 border-secondary" href="{{url('/category/'.$category->find(6)->id)}}"><i class="fs-3 bi-gender-ambiguous"></i><br>{{$category->find(6)->categories}}</a>
                            {{-- <a class="btn alert alert-success col-md-2" href=""><i class="fs-3 bi-display"></i><br>{{$category->find(2)->categories}}</a>
                            <a class="btn alert alert-success col-md-2" href=""><i class="fs-3 bi-display"></i><br>{{$category->find(2)->categories}}</a> --}}
                        </div>
                    </div>
                    
                </div>
                {{-- browse other product --}}
                <div class="card-footer row d-flex">
                    <div class="text-light text-center pb-5">Jelajahi produk lainnya</div>
                    @foreach($item as $item)
                    @if($item->user_id != Auth::user()->id )
                    <div class="card col-md-3 px-0 border-dark border-4" loading="lazy">
                        <a href="{{url('/item/'.$item->id)}}">
                        <div class="card-header" style="background-image: url({{$item->foto1}});height:200px;background-size:cover;background-position:center" placeholder="{{$item->description}}">
                            @if($item->status == 'Tersedia')<button class="btn btn-primary" disabled>{{$item->status}}</button>@else<button class="btn btn-light text-muted" disabled>{{$item->status}}</button> @endif
                        </div></a>
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
            @elseif(Auth::user()->role == 'admin')
            <div class="card text-bg-dark">
                <div class="card-header">
                    {{__('Welcome '.Auth::user()->name.'!')}}
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                            {{__('Contoh blablabla')}} &nbsp;<a href="">blablabla</a>
                    </div>
                </div>
            </div>
            @elseif(Auth::user()->role == 'courier')
            <div class="card text-bg-dark">
                <div class="card-header">
                    {{__('Welcome '.Auth::user()->name.'!, silahakan pilih orderan')}}
                </div>
                <div class="card-body">
                    @if($pending->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-secondary table-hover">
                            <thead class="bg-secondary">
                            <tr>
                                <th>ID pesanan</th>
                                <th>Tanggal</th>
                                <th>Alamat [Pembeli]</th>
                                <th>[Jumlah] Barang</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody class="bg-secondary">
                            @foreach($pending as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>{{$item->created_at}}</td>
                                <td>{{$item->user->alamat}}<br>[ {{$item->user->name}} ]</td>
                                <td>[ {{$item->item_count}} ]<br>{{$item->item->item_name}}</td>
                                <td class="text-danger">{{$item->status}}</td>
                                <td>
                                    
                                    <form action="{{ url( 'courier/accept/'.$item->id ) }}" method="POST" class="p-1">
                                        <input type="hidden" name="_method" value="PUT">
                                        @csrf
                                        <button type="submit" class="btn btn-primary w-100">Terima Pesanan</button>
                                    </form>
                                    
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center">Tidak ada barang yang menunggu pengiriman</div>
                    @endif
                </div>
            </div>
            @endif

    </div>
</div>
@endsection
