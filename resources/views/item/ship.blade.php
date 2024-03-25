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
            <div class="btn-group mb-3" role="group" aria-label="Basic radio toggle button group">
                <button type="button" class="btn btn-secondary active" onclick="showItem('a');toggleActive(this)">Dikemas</button>
                <button type="button" class="btn btn-secondary" onclick="showItem('b');toggleActive(this)">Dikirim</button>
                <button type="button" class="btn btn-secondary" onclick="showItem('c');toggleActive(this)">Selesai</button>
                <button type="button" class="btn btn-secondary" onclick="showItem('d');toggleActive(this)">Dibatalkan</button>
              </div>
            @if (NULL != $ship->first())
                @foreach($ship as $item)
                <div class="card col-lg-3 px-0 border-dark border-4"  id="@if($item->status == 'menunggu penjual'){{__('a')}}@elseif($item->status == 'diproses penjual' || $item->status == 'menunggu kurir' || $item->status == 'sedang dikirim' || $item->status == 'sampai di tujuan'){{__('b')}}@elseif($item->status == 'diterima pembeli' ||$item->status == 'dikomplain'){{__('c')}}@elseif($item->status == 'dikirim balik' ||$item->status == 'transaksi gagal'){{__('d')}}@endif" style="{{$item->status == 'menunggu penjual' ? 'display:block' : 'display:none'}}">
                    <div class="card-header" style="background-image: url({{$item->item->foto1}});height:200px;background-size:cover;background-position:center" placeholder="{{$item->description}}">
                        @if($item->status == 'menunggu penjual')<button class="btn btn-primary" disabled>
                        @elseif($item->status == 'diproses penjual' || $item->status == 'menunggu kurir' || $item->status == 'sedang dikirim' || $item->status == 'sampai di tujuan')<button class="btn btn-success" disabled>
                        @elseif($item->status == 'diterima pembeli' ||$item->status == 'dikomplain')<button class="btn btn-warning" disabled>
                        @elseif($item->status == 'dikirim balik' ||$item->status == 'transaksi gagal')<button class="btn btn-secondary" disabled>
                        @endif
                        {{$item->status}}</button>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title">{{Str::limit($item->item->item_name, 27)}} </h4>
                        <h5>Rp. {{number_format($item->total_price, 0, ',', '.')}}</h5>
                        <p class="text-muted">total unit : {{$item->item_count}}</p>
                        <span class=""><a href="{{ url( 'shipment/'.Auth::user()->id.'/track/'.$item->id ) }}" class="text-success">{{$item->track->last()->status}}</a></span>
                    </div>
                    <div class="card-footer row">
                        @if($item->status == 'menunggu penjual' || $item->status == 'diproses penjual' || $item->status == 'menunggu kurir')
                        <form action="{{ url( 'shipment/'.Auth::user()->id.'/delete/'.$item->id ) }}" method="POST" class="p-1">
                            <input type="hidden" name="_method" value="PUT">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger w-100">Batalkan Pesanan</button>
                        </form>
                        @endif
                    </div>               
                </div>
                
                @endforeach
            @else
                <div class="text-light text-center">Tidak ada barang nih. Tambah pesanan yuk ! </div>
            @endif    
        </div>
    </div>
</div>
<script>
    function showItem(a) {
        var statuses = ['a', 'b', 'c', 'd'];

        // Ambil semua elemen dengan ID yang diberikan
        var elementsToShow = document.querySelectorAll('[id="' + a + '"]');

        // Tampilkan elemen-elemen dengan ID yang sama, sembunyikan yang lain
        statuses.forEach(function(status) {
            var elements = document.querySelectorAll('[id="' + status + '"]');
            elements.forEach(function(element) {
                if (status === a) {
                    element.style.display = 'block';
                } else {
                    element.style.display = 'none';
                }
            });
        });
    }
    function toggleActive(button) {
        // Remove 'active' class from all buttons
        var buttons = document.querySelectorAll('.btn-group .btn');
        buttons.forEach(function(btn) {
            btn.classList.remove('active');
        });

        // Add 'active' class to the clicked button
        button.classList.add('active');
    }
</script>
@endsection