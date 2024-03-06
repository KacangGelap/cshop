@extends('layouts.main')
@section('content')
<div class="container-fluid">
    @if (session('sukses'))
        <div class="alert alert-success" role="alert">
            {{ session('sukses') }}
        </div>
    @elseif (session('gagal'))
        <div class="alert alert-danger" role="alert">
            {{ session('gagal') }}
        </div>
    @endif
    <div class="card text-bg-secondary border">
        <div class="card-header border-bottom">
            <label class="h4">{{__(Route::current()->getName())}}</label>
            <div class="d-flex justify-content-between">
            <form class="d-flex" method="POST" action="{{ route('register') }}">
                @csrf
                <input  type="text" name="search" id="search" value="{{old('search')}}" placeholder="Cari Barang ..">
                <button type="submit" class="btn btn-primary">Submit</button>
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
                        <a class="btn btn-outline-info" href="{{url('user/'.$item->id)}}">{{__('Show')}}</a>
                        <a class="btn btn-outline-warning" href="{{url('user/edit/'.$item->id)}}">{{__('Edit')}}</a>
                        <form class="d-flex" action="{{url('/user/delete/'.$item->id)}}" method="POST"><input type="hidden" name="_method" value="DELETE">
                            @csrf
                                    <button class="btn btn-outline-danger"> {{__('Delete')}} </button>
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