@extends('layouts.main')
@section('content')
<style>
    .landscape {
    aspect-ratio: 16 / 9;
}
</style>
    <div class="container-fluid text-bg-dark">
        <div class="row py-3">
            <span class="col-4"><img src="{{$item->foto1}}" class="w-100"></span>
            <span class="col-4">
                <h2>{{$item->item_name}}</h2>
                <pre class="text-info">{{$item->category->categories}}</pre>
                <h1>Rp. {{number_format($item->item_price, 0, ',', '.')}}</h1>
                <div class="d-flex">
                @for ($i = 0; $i < $comments->avg('rating'); $i++)
                    <i class="bi bi-star-fill text-warning"></i>
                @endfor
                <p>({{$comments->count()}} komentar)</p>
                </div>
                <form action="{{url('/item/'.$item->id.'/cart')}}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-outline-warning"><i class="bi-cart-plus"> </i>Add To Cart</button>
                </form>
            </span>
            <span class="col-4 text-end">
                <a class="btn btn-outline-primary" href="{{url()->previous()}}"><i class="bi-arrow-90deg-left"></i></a>
            </span>
        </div>
        <hr>
        <div class="container-fluid">
            <div class="pb-4">
                <h5>Deskripsi :</h5>
                <pre class="p-2">{{$item->item_description}}</pre>
            </div>
        </div>
        <hr>
        <div class="container-fluid">
            <div class="pb-4">
                <span class="d-flex"><h5>Penilaian : {{$comments->avg('rating')}}</h5>&nbsp;({{$comments->count()}} komentar)</span>
                @if($comments->count() > 0)
                @foreach ($comments as $item)
                <div class="card">
                    <div class="card-header">
                       <span class="d-flex"><img src="{{$item->user->photo != NULL ? $item->user->photo : 'https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fpluspng.com%2Fimg-png%2Fpng-user-icon-person-icon-png-people-person-user-icon-2240.png&f=1&nofb=1&ipt=31f2d6611ddc01a7ccc8ba193c5630d2bd1ab24b2d5cec443e962b46e01e5485&ipo=images'}}" alt="hugenerd" width="30" height="30" class="rounded-circle"> <p class="mx-2">{{$item->user->name}}</p>
                         @for ($i = 0; $i < $item->rating; $i++)
                           <i class="bi bi-star-fill text-warning"></i>
                       @endfor</span>
                    </div>
                    <div class="card-body">
                        
                        <div class="row px-2">
                            @if(NULL != $item->media1 )
                            <img src="{{$item->media1}}" class="col-4 img-fluid object-fit-cover landscape" data-bs-toggle="modal" data-bs-target="{{__('#media1Modal'.$item->user->id)}}">
                                <!-- Modal for media1 -->
                                <div class="modal fade" id="{{__('media1Modal'.$item->user->id)}}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <img src="{{$item->media1}}" class="img-fluid">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if (NULL != $item->media2 )
                            <img src="{{$item->media2}}" class="col-4 img-fluid object-fit-cover landscape" data-bs-toggle="modal" data-bs-target="{{__('#media2Modal'.$item->user->id)}}">
                                <!-- Modal for media2 -->
                                <div class="modal fade" id="{{__('media2Modal'.$item->user->id)}}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <img src="{{$item->media2}}" class="img-fluid">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if (NULL != $item->media3 )
                            <img src="{{$item->media3}}" class="col-4 img-fluid object-fit-cover landscape" data-bs-toggle="modal" data-bs-target="{{__('#media3Modal'.$item->user->id)}}">
                                <!-- Modal for media3 -->
                                <div class="modal fade" id="{{__('media3Modal'.$item->user->id)}}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <img src="{{$item->media3}}" class="img-fluid">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        
                        <hr>

                        <div class="">
                            <h5>Komentar :</h5>
                            <pre>{{$item->comment}}</pre>
                        </div>
                    </div>
                    
                </div> 
                @endforeach
                @else
                <pre class="text-center">Belum Ada penilaian nih</pre>
                @endif
            </div>
        </div>
    </div>
@endsection