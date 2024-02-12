@extends('layouts.app')
@section('content')
<style>
.move{
    position:relative;
    animation-name: mymove;
    animation-duration: 2s;
}
.fade,.fade:not(.show){
    opacity: 100%;
    animation-name:fade;
    animation-duration: 1.3s;
}
.slide,.slide:not(.show){
    opacity: 100%;
    animation-name:slide;
    animation-duration: 4s;
}
@keyframes mymove {
    from {left:50%;opacity:6%}
    to {left: 0px;opacity:100%}
}
@keyframes fade{
    from {opacity:6%;position: relative}
    to {opacity: 100%;position: relative}
}
@keyframes slide{
    from {width:0%;opacity:6%;position: relative}
    to {width:100%;opacity: 100%;position: relative}
}
</style>
<div class="container-fluid">
    <div class="row pb-6" style="background-image: linear-gradient(to right, transparent 0%, #141d2b 75%),url('{{asset('img/devan_bg.png')}}');background-size:cover;background-attachment: fixed; background-position: 0% 50%">
        <div class="py-4 d-flex">
            <div class="col-md-5 offset-md-2 text-light">
                <img class="w-75 move" src="{{asset('img/devan.png')}}">
            </div>
            <div class="col-md-5 text-light pt-12 text-start justify-content-between d-block ">
                <h1 class="fade text-light py-4">Devan Apriandi Dwicahya</h1>
                <hr class="slide">
                <pre>
Age         : 21
Gender      : male
Student ID  : 11211030</pre>
                <p text-align="fade text-justify">saya adalah seorang mahasiswa Institut Teknologi Kalimantan. 
                    Dalam pembangunan aplikasi, saya memiliki tanggung jawab sebagai Fullstack Developer, 
                    bertanggung jawab untuk mengembangkan seluruh aspek dari aplikasi, 
                    mulai dari sisi depan (frontend) hingga sisi belakang (backend).</p>
                <hr>
                <p class="mt-5 text-end">The Mind shall Vanquish the Sword<br>-Sima Yi-</p>
                <img class="justify-content-between" alt="kacanggelap" src="https://github-readme-stats.vercel.app/api/top-langs?username=kacanggelap&amp;show_icons=true&amp;locale=en&amp;layout=compact">
                
            </div>
        </div>
        <div class="col-md-12 text-light text-start py-6">
        </div>
    
    </div>
</div>
@endsection