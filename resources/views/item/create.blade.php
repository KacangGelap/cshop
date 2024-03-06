@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card text-bg-secondary border">
                <div class="card-header border-bottom">{{ __('Tambah barang anda') }}</div>

                <div class="card-body">
                    
                    <form method="POST" action="{{ url('/stall/'.Auth::user()->id.'/create')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <label for="item_name" class="col-md-4 col-form-label text-md-end">{{ __('Nama Barang') }}</label>

                            <div class="col-md-6">
                                <input id="item_name" type="text" class="form-control @error('item_name') is-invalid @enderror" name="item_name" value="{{ old('item_name') }}" required autocomplete="item_name" autofocus>

                                @error('item_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="category_id" class="col-md-4 col-form-label text-md-end">{{ __('Kategori') }}</label>

                            <div class="d-flex col-md-6">
                                <select name="category_id" id="category_id" class="form-control">
                                    <option value="{{NULL}}">Pilih Kategori</option>
                                    @foreach ($category as $c)
                                    <option value="{{$c->id}}">{{$c->categories}}</option>
                                    @endforeach
                                </select>

                                @error('category_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="item_price" class="col-md-4 col-form-label text-md-end">{{ __('Harga Barang') }}</label>

                            <div class="d-flex col-md-6">
                                <button class="btn btn-light rounded-0 rounded-start" disabled>Rp.</button><input id="item_price" type="number" class="rounded-0 rounded-end form-control @error('item_price') is-invalid @enderror" name="item_price" value="{{NULL != old('item_price') ? old('item_price') : 0}}" required autocomplete="item_price" autofocus>

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
                                <textarea id="item_description"  class="form-control @error('item_description') is-invalid @enderror" name="item_description" value="{{ old('item_description') }}" required autocomplete="item_description"></textarea>

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
                                <input id="item_count" type="number" class="form-control @error('item_count') is-invalid @enderror" name="item_count" value="{{NULL != old('item_count') ? old('item_count') : 0}}" required autocomplete="item_count" autofocus>

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
                                <input id="foto1" type="file" class="form-control @error('foto1') is-invalid @enderror" name="foto1" value="{{old('foto1')}}" required autocomplete="foto1" autofocus>

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
                                <input id="foto2" type="file" class="form-control @error('foto2') is-invalid @enderror" name="foto2" value="{{old('foto2')}}" autocomplete="foto2" autofocus>

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
                                    {{ __('Tambah Barang') }}
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
