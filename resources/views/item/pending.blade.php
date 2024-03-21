@extends('layouts.main')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="card text-bg-dark">
                <div class="card-header">
                    {{Route::current()->getName()}}
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-secondary table-hover">
                            <thead class="bg-secondary">
                            <tr>
                                <th>Tanggal</th>
                                <th>Pembeli</th>
                                <th>Jumlah Barang</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody class="bg-secondary">
                            @foreach($pending_items as $item)
                            <tr>
                                <td>{{$item->created_at}}</td>
                                <td>{{$item->user->name}}</td>
                                <td>{{$item->item_count}}</td>
                                <td>{{$item->status}}</td>
                                <td>
                                    @if($item->status == 'menunggu penjual')
                                    <form class="d-flex" action="{{url('/user/delete/'.$item->id)}}" method="POST"><input type="hidden" name="_method" value="DELETE">
                                        @csrf
                                    <button class="btn btn-outline-warning"> {{__('Proses Pesanan')}} </button>
                                    </form>
                                    @elseif($item->status == 'diproses penjual')
                                    <form class="d-flex" action="{{url('/user/delete/'.$item->id)}}" method="POST"><input type="hidden" name="_method" value="DELETE">
                                        @csrf
                                    <button class="btn btn-outline-danger"> {{__('Kirim')}} </button>
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
    </div>
@endsection