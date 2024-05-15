@extends('layouts.main')
@section('content')
<div class="container-fluid">
    <div class="card text-bg-secondary border">
        <div class="card-header border-bottom">
            
            <div class="card-header border-bottom">
                <label class="h4">{{__(Route::current()->getName().' : '.$query)}}</label>
                <div class="d-flex justify-content-between">
                <form class="d-flex" method="POST" action="{{ route('Cari Produk') }}">
                    @csrf
                    <input  type="text" name="query" id="query" value="{{old('query')}}" placeholder="Cari Produk ..">
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
            <table class="table table-striped table-secondary table-hover">
                <thead class="bg-secondary">
                    <tr>
                        <th>Nama Barang</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Seller</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody class="bg-secondary">
                    @foreach($items as $item)
                    <tr>
                        <td>{{$item->item_name}}</td>
                        <td>Rp. {{number_format($item->item_price, 0, ',', '.')}}</td>
                        <td>{{$item->item_count}}</td>
                        <td>{{$item->status}}</td>
                        <td>{{$item->user->name}}</td>
                        <td class="d-flex justify-content-around">
                            <a class="btn btn-outline-info" href="{{url('item/'.$item->id)}}">{{__('Show')}}</a>
                            <a class="btn btn-outline-warning" href="{{url('stall/'.$item->user->id.'/edit/'.$item->id)}}">{{__('Edit')}}</a>
                            <form action="{{ url( '/stall/'.$item->user->id.'/item/delete/'.$item->id ) }}" method="POST" class="p-1">
                                <input type="hidden" name="_method" value="DELETE">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger w-100">Hapus</button>
                        </form>
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