@extends('layouts.main')
@section('content')
    <div class="container-fluid">
        <div class="row">
            @if (session('sukses'))
                <div class="alert alert-success" role="alert">
                    {{ session('sukses') }}
                </div>
            @endif
            @if (session('gagal'))
            <div class="alert alert-success" role="alert">
                {{ session('gagal') }}
            </div>
        @endif
            <div class="card text-bg-dark">
                <div class="card-header">
                    {{Route::current()->getName()}}
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-secondary table-hover">
                            <thead class="bg-secondary">
                            <tr>
                                <th>ID pesanan</th>
                                <th>Tanggal</th>
                                <th>Pembeli</th>
                                <th>Jumlah Barang</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody class="bg-secondary">
                            @foreach($pending_items as $item)
                                @if($item->status != 'transaksi gagal' && $item->status != 'sedang dikirim')
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>{{$item->created_at}}</td>
                                <td>{{$item->user->name}}</td>
                                <td>{{$item->item_count}}</td>
                                <td>{{$item->status}}</td>
                                <td>
                                    @if($item->status == 'menunggu penjual')
                                    <form action="{{ url( 'shipment/'.$item->user_id.'/accept/'.$item->id ) }}" method="POST" class="p-1">
                                        <input type="hidden" name="_method" value="PUT">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-warning w-100">Terima Pesanan</button>
                                    </form>
                                    @elseif($item->status == 'diproses penjual')
                                    <form action="{{ url( 'shipment/'.$item->user_id.'/ready/'.$item->id ) }}" method="POST" class="p-1">
                                        <input type="hidden" name="_method" value="PUT">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-success w-100">Kirim Pesanan</button>
                                    </form>
                                    @elseif($item->status == 'dikomplain')
                                    <form action="{{ url( 'shipment/'.$item->user_id.'/return/'.$item->id ) }}" method="POST" class="p-1">
                                        <input type="hidden" name="_method" value="PUT">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-success w-100">Terima Pengembalian</button>
                                    </form>
                                    <form action="{{ url( 'shipment/'.$item->user_id.'/reject/'.$item->id ) }}" method="POST" class="p-1">
                                        <input type="hidden" name="_method" value="PUT">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger w-100">Tolak Pengembalian</button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection