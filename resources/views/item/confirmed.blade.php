@extends('layouts.main')
@section('content')
    <div class="container-fluid">
        @if (session('status'))
                <div class="alert alert-danger" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            @if (session('sukses'))
            <div class="alert alert-success" role="alert">
                {{ session('sukses') }}
            </div>
        @endif
        <div class="card text-bg-dark">
            <div class="card-header">
                {{__(Route::current()->getName())}}
            </div>
            <div class="card-body">
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
                        
                        @foreach($data as $item)
                        
                        <tr>
                            <td>{{$item->id}}</td>
                            <td>{{$item->created_at}}</td>
                            <td>{{$item->ship->user->alamat}}<br>[ {{$item->ship->user->name}} ]</td>
                            <td>[ {{$item->ship->item_count}} ]<br>{{$item->ship->item->item_name}}</td>
                            <td>{{$item->ship->track->last()->status}}</td>
                            <td>@if($item->ship->status != 'diterima pembeli' && $item->ship->status != 'transaksi gagal' && $item->ship->status != 'dikomplain' && $item->ship->status !='dikirim balik')
                                <a href="{{ url( 'courier/change/'.$item->id ) }}" type="submit" class="btn btn-outline-warning w-100">Ubah Status Pengiriman</a>
                                @elseif($item->ship->status == 'dikirim balik')
                                <form action="{{ url( 'courier/fail/'.$item->ship->id ) }}" method="POST" class="p-1">
                                    <input type="hidden" name="_method" value="PUT">
                                    @csrf
                                    <button type="submit" class="btn btn-danger w-100">Pesanan telah dikembalikan</button>
                                </form>
                                @endif
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