@extends('layouts.main')
@section('content')

    @if (session('sukses'))
        <div class="alert alert-success text-success" role="alert" >
            {{ session('sukses') }}
        </div>
    @elseif (session('gagal'))
        <div class="alert alert-danger" role="alert" >
            {{ session('gagal') }}
        </div>
        
    @endif
    @error('item_count')
        <div class="alert alert-danger" role="alert">
            <strong>{{ $message }}</strong>
        </div>
    @enderror
    <div class="container-fluid text-bg-dark">
        
        <div class="row py-3">
            <span class="col-4"><img src="{{$item->foto1}}" class="w-100" loading="lazy"></span>
            <span class="col-4">
                <h2>{{$item->item_name}}</h2>
                <pre class="text-info">{{$item->category->categories}}</pre>
                <h1>Rp. {{number_format($item->item_price, 0, ',', '.')}}</h1>
                <div class="d-flex">
                @if(NULL != $comments)
                @for ($i = 0; $i < $comments->avg('rating'); $i++)
                    <i class="bi bi-star-fill text-warning"></i>
                @endfor
                
                <p>({{$comments->count()}} komentar)</p>
                @endif
                </div>
                <!-- Button to Open the Modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal" @if(Auth::user()->id == $item->user->id || $item->item_count < 1) disabled @endif>
                    @if(Auth::user()->id == $item->user->id) Ini barang milik anda @elseif($item->item_count < 1) Barang Habis @else Tambahkan ke Keranjang @endif
                </button>
                
                <!-- The Modal -->
                <div class="modal" id="myModal" loading="lazy">
                    <div class="modal-dialog">
                    <div class="modal-content  text-bg-secondary">
                
                        <!-- Modal Header -->
                        <div class="modal-header">
                        <h4 class="modal-title">Masukkan Keranjang (stok : {{$item->item_count}})</h4>
                        <button type="button" class="btn-close text-white" data-bs-dismiss="modal"></button>
                        </div>
                
                        <!-- Modal body -->
                            <form action="{{url('/add/'.$item->id)}}" method="post">  
                            <div class="modal-body">
                                @csrf
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
                            </div>
                    
                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success" >Tambahkan</button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                    </div>
                </div>
            </span>
            <span class="col-4 text-end">
                <a class="btn btn-outline-primary" href="{{url('/home')}}"><i class="bi-arrow-90deg-left"></i></a>
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
                @if(NULL != $comments)
                <span class="d-flex"><h5>Penilaian : {{__( intval($comments->avg('rating')).'/5' )}}</h5>&nbsp;({{$comments->count()}} komentar)</span>
               
                
                <div class="card">
                    <div class="card-header">
                       <span class="d-flex"><img src="{{$comments->user->photo != NULL ? $comments->user->photo : 'https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fpluspng.com%2Fimg-png%2Fpng-user-icon-person-icon-png-people-person-user-icon-2240.png&f=1&nofb=1&ipt=31f2d6611ddc01a7ccc8ba193c5630d2bd1ab24b2d5cec443e962b46e01e5485&ipo=images'}}" alt="hugenerd" width="30" height="30" class="rounded-circle"> <p class="mx-2">{{$comments->user->name}}</p>
                         @for ($i = 0; $i < $comments->rating; $i++)
                           <i class="bi bi-star-fill text-warning"></i>
                       @endfor</span>
                    </div>
                    <div class="card-body">
                        
                        <div class="row px-2">
                            @foreach ([$comments->media1, $comments->media2, $comments->media3] as $media)
                                @if ($media)
                                    <img src="{{$media}}" class="col-4 img-fluid object-fit-cover ratio-16x9" loading="lazy">
                                @endif
                            @endforeach

                        </div>
                        
                        <hr>

                        <div class="">
                            <h5>Komentar :</h5>
                            <pre>{{$comments->comment}}</pre>
                        </div>
                    </div>
                    
                </div> 
                
                @else
                <pre class="text-center">Belum Ada penilaian nih</pre>
                @endif
            </div>
        </div>
    </div>
    <script>
        // JavaScript to open the modal when the link is clicked on page A
        document.addEventListener("DOMContentLoaded", function() {
            const openModalLinks = document.querySelectorAll('.open-modal-link');
            if (openModalLinks) {
                openModalLinks.forEach(function(link) {
                    link.addEventListener('click', function(event) {
                        event.preventDefault(); // Prevent the default behavior of the link
                        const modal = new bootstrap.Modal(document.getElementById('myModal')); // Create a new Modal instance
                        modal.show(); // Show the modal
                    });
                });
            }
        });
    </script>
@endsection