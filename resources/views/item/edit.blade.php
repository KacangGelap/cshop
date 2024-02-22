@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card text-bg-secondary border">
                <div class="card-header border-bottom">{{ __('Edit barang anda') }}</div>

                <div class="card-body">
                    
                    <form method="POST" action="{{ url('/stall/'.Auth::user()->id.'/edit/'.$items->id)}}" enctype="multipart/form-data">
                        <input type="hidden" name="_method" value="PUT">
                        @csrf
                        <div class="row mb-3">
                            <label for="item_name" class="col-md-4 col-form-label text-md-end">{{ __('Nama Barang') }}</label>

                            <div class="col-md-6">
                                <input id="item_name" type="text" class="form-control @error('item_name') is-invalid @enderror" name="item_name" value="{{ $items->item_name }}" required autocomplete="item_name" autofocus>

                                @error('item_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="item_price" class="col-md-4 col-form-label text-md-end">{{ __('Harga Barang') }}</label>

                            <div class="d-flex col-md-6">
                                <button class="btn btn-light" disabled>Rp.</button><input id="item_price" type="number" class="form-control @error('item_price') is-invalid @enderror" name="item_price" value="{{$items->item_price}}" required autocomplete="item_price" autofocus>

                                @error('item_price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="item_description" class="col-md-4 col-form-label text-md-end">{{ __('Deskripsi') }}</label>

                            <div class="col-md-6">
                                <textarea id="item_description" class="form-control @error('item_description') is-invalid @enderror" name="item_description" value="" required autocomplete="item_description">{{ $items->item_description }}</textarea>

                                @error('item_description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label for="item_count" class="col-md-4 col-form-label text-md-end">{{ __('Jumlah Barang') }}</label>

                            <div class="col-md-6">
                                <input id="item_count" type="number" class="form-control @error('item_count') is-invalid @enderror" name="item_count" value="{{$items->item_count}}" required autocomplete="item_count" autofocus>

                                @error('item_count')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="foto1" class="col-md-4 col-form-label text-md-end">{{ __('Foto produk') }}</label>

                            <div class="col-md-6">
                                <input id="foto1" type="file" class="form-control @error('foto1') is-invalid @enderror" name="foto1" autocomplete="foto1" autofocus>

                                @error('foto1')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="foto2" class="col-md-4 col-form-label text-md-end">{{ __('Tambahan Foto Produk (opsional)') }}</label>

                            <div class="col-md-6">
                                <input id="foto2" type="file" class="form-control @error('foto2') is-invalid @enderror" name="foto2" autocomplete="foto2" autofocus>

                                @error('foto2')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Ubah Data Barang') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
