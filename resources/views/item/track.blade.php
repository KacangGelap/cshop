@extends('layouts.main')
@section('content')
    <div class="container-fluid">
        <div class="card text-bg-dark">
            <div class="d-flex card-header justify-content-between">
                <span>{{__(Route::current()->getName().' : '.$track->last()->ship->item->item_name)}}</span>
                <span class="col-4 text-end">
                    <a class="btn btn-outline-primary" href="{{url()->previous()}}"><i class="bi-arrow-90deg-left"></i></a>
                </span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-secondary table-hover">
                        <thead class="bg-secondary">
                        <tr>
                            <th>Tanggal</th>
                            <th>Status</th>
                        
                        </tr>
                        </thead>
                        <tbody class="bg-secondary">
                        @foreach($track as $item)
                        <tr>
                            <td>{{ Carbon\Carbon::parse($item->created_at)->format('d-F-Y : H:i:s')}}</td>
                            <td>{{$item->status}}
                                <br>
                                @if(NULL != $item->img)
                                <button type="button" class="btn btn-link text-success" data-bs-toggle="modal" data-bs-target="#myModal{{$item->id}}">
                                    lihat foto pesanan
                                </button>
                                 <!-- The Modal -->
                                <div class="modal" id="myModal{{$item->id}}">
                                    <div class="modal-dialog">
                                    <div class="modal-content text-bg-secondary">
                                
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                        <h4 class="modal-title">Foto Pesanan Anda </h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                
                                        <!-- Modal body -->
                                        <div class="modal-body">
                                        <img src="{{$item->img}}" class="img-fluid object-fit-cover">
                                        </div>
                                
                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                        </div>
                                
                                    </div>
                                    </div>
                                </div>
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