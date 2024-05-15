@extends('layouts.main')
@section('content')
    <div class="container-fluid">
        <div class="card text-bg-dark">
        <div class="card-header">
            <div class="row justify-content-center">
                <a class="btn {{Route::current()->parameter('cat') == $category->find(1)->id ? 'alert text-white': 'alert alert-danger'}} col-md-2 border-5 border-dark" href="{{url('/category/'.$category->find(1)->id)}}"><i class="fs-3 bi-plug"></i><br>{{$category->find(1)->categories}}</a>
                <a class="btn {{Route::current()->parameter('cat') == $category->find(2)->id ? 'alert text-white': 'alert alert-warning'}} col-md-2 border-5 border-dark" href="{{url('/category/'.$category->find(2)->id)}}"><i class="fs-3 bi-display"></i><br>{{$category->find(2)->categories}}</a>
                <a class="btn {{Route::current()->parameter('cat') == $category->find(3)->id ? 'alert text-white': 'alert alert-success'}} col-md-2 border-5 border-dark" href="{{url('/category/'.$category->find(3)->id)}}"><i class="fs-3 bi-phone"></i><br>{{$category->find(3)->categories}}</a>
                <a class="btn {{Route::current()->parameter('cat') == $category->find(4)->id ? 'alert text-white': 'alert alert-info'}} col-md-2 border-5 border-dark" href="{{url('/category/'.$category->find(4)->id)}}"><i class="fs-3 bi-house-up"></i><br>{{$category->find(4)->categories}}</a>
                <a class="btn {{Route::current()->parameter('cat') == $category->find(5)->id ? 'alert text-white': 'alert alert-dark'}} col-md-2 border-5 border-dark" href="{{url('/category/'.$category->find(5)->id)}}"><i class="fs-3 bi-bicycle"></i><br>{{$category->find(5)->categories}}</a>
                <a class="btn {{Route::current()->parameter('cat') == $category->find(6)->id ? 'alert text-white': 'alert alert-light'}} col-md-2 border-5 border-dark" href="{{url('/category/'.$category->find(6)->id)}}"><i class="fs-3 bi-gender-ambiguous"></i><br>{{$category->find(6)->categories}}</a>
                {{-- <a class="btn alert alert-success col-md-2" href=""><i class="fs-3 bi-display"></i><br>{{$category->find(2)->categories}}</a>
                <a class="btn alert alert-success col-md-2" href=""><i class="fs-3 bi-display"></i><br>{{$category->find(2)->categories}}</a> --}}
            </div>
        </div>
        <div class="card-body row d-flex">
            @if($item->count() > 0)
                @foreach($item as $item)
                    @if($item->user_id != Auth::user()->id )
                    <div class="card col-3 px-0 border-dark border-4">
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
            @else
            <div class="text-center">Tidak Ada barang nih</div>
            @endif
        </div>
        </div>
    </div>
@endsection