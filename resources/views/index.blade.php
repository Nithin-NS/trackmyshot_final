@extends('layouts.app')
@section('content')
    <header style="background-image: url('img/hero.jpg');background-size: cover;background-repeat: no-repeat;" class="min-vh-100 p-4">
    {{-- <header style="" class="min-vh-100 p-4"> --}}
        
        <h5><a href="https://trackmyshot.com" class="text-lg font-weight-bold text-decoration-none text-white">TrackMyShot</a></h5>

        <registration></registration>

    </header>
@stop