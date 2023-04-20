<section style="min-height:500px;">

    <div class="divider">
        <div class="container pb-50 pt-50">
            <div class="section-content">
                <div style="font-size: 22px; color:#111; margin-bottom: 15px; font-weight: bold;">5th National Conference
                    of SIMON</div>
                <div id="table_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="dataTables_length" id="table_length"><label>Show <select name="table_length"
                                        aria-controls="table" class="form-control input-sm">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select> entries</label></div>
                        </div>
                        <div class="col-sm-6">
                            <div id="table_filter" class="dataTables_filter"><label>Search:<input type="search"
                                        class="form-control input-sm" placeholder="" aria-controls="table"></label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <table
                                class="table table-striped table-hover table-hover table-schedule dataTable no-footer"
                                border="0" id="table" role="grid" aria-describedby="table_info">
                                <thead>
                                    <tr role="row">
                                        <thead>
                                            <tr>
                                                <th scope="col" width="10%">S.No.</th>
                                                <th scope="col">Name</th>

                                                <th scope="col">Event</th>
                                                <th scope="col">Participant Type</th>
                                                <th class="text-center" width="170">Action</th>

                                            </tr>
                                        </thead>
                                <tbody>
                                    @php $i=1 @endphp

                                    @foreach ($participants as $participant)
                                        <tr>
                                            <td>{{ $i++ }} </td>
                                            <td>{{ $participant->name }}</td>
                                            <td>{{ $participant->affilated_institute }}</td>
                                            <td>{{ $participant->post }}</td>


                                            <td>{{ $participant->event->name }}</td>
                                            <td>{{ $participant->participantType->name }}</td>


                                            <td class="text-center">

                                                <a title="Download PDF"
                                                    href="/admin/events/{{ $event->id }}/participants/{{ $participant->id }}/download-pdf"
                                                    class="btn btn-primary" class="bi bi-arrow-down-circle-fill"><i
                                                        class="bi bi-arrow-down-circle-fill"></i></a>

                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>


            </div>
        </div>

    </div>
</section>

{{-- html adn csss code for image to make index.php file --}}
<!DOCTYPE html>
<html>

<head>
    <style>
        @page {
            margin: 0px;
            padding: 0px;
        }

        body {
            margin: 0px;
            max-width: 1000px;
        }

        img {
            max-width: 900px;
        }
    </style>
</head>

<body>
    <div class="">
        <img class="" src="{{ $resourcePath }}/Aakriti Pokharel-pdf.png" />
        <h1 style="position: absolute; top: 360px; left: 430px">
            {{ $participant->name }}
        </h1>
        <h1 style="position: absolute; top: 400px; left: 430px">
            {{ $participant->participantType->name }}
        </h1>
    </div>
</body>

</html>

{{-- testing --}}
<div class="col-sm-6 col-md-4 col-lg-4">
    <div class="schedule-box maxwidth500 mb-30 bg-lighter">

        <div class="thumb"> <img src="https://conferencenepal.com/uploads/media/banner_LQgpyFLpCZerSHdP9lNh.jpeg">
        </div>

        <div class="schedule-details clearfix p-15 pt-10">
            <h5 class="font-16 title"><a href="https://conferencenepal.com/events/detail/6/apaccm2022">APACCM2022</a>
            </h5>
            <ul class="list-inline font-11 mb-20">
                <li><i class="fa fa-calendar mr-5"></i>2022-12-04</li>
                <li><i class="fa fa-map-marker mr-5"></i>Kathmandu</li>
            </ul>
            <p>
                aa </p>
            <div class="mt-10">
                <a class="btn btn-colored btn-theme-colored btn-sm"
                    href="https://conferencenepal.com/downloads/certificates/event/6">Download Certificate</a>
                <a class="btn btn-colored btn-theme-colored btn-sm"
                    href="https://conferencenepal.com/events/detail/6/apaccm2022">Details</a>
            </div>
        </div>
    </div>
</div>



{{-- home page --}}

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- app  --}}
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>


{{-- saving static map --}}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MapController extends Controller
{
    public function show($id)
    {
        $map = Map::findOrFail($id);
        $imagePath = public_path($map->image_path);
        // Render the view with the map data and image path
    }

    public function store(Request $request)
    {
        // Validate the request input
        $request->validate([
            'latitude' => 'required',
            'longitude' => 'required',
            'zoom' => 'required|numeric',
        ]);

        // Generate and save the static map image
        $lat = $request->input('latitude');
        $lng = $request->input('longitude');
        $zoom = $request->input('zoom');
        $url = "https://maps.googleapis.com/maps/api/staticmap?center={$lat},{$lng}&zoom={$zoom}&size=640x640&scale=2&maptype=roadmap&key=YOUR_API_KEY";
        $imageData = file_get_contents($url);
        $imagePath = 'maps/' . uniqid() . '.png'; // Unique filename
        file_put_contents(public_path($imagePath), $imageData);

        // Save the map data and image path to the database
        

        // Redirect to the map view with a success message
        return redirect()->route('maps.show', $map->id)->with('success', 'Map created successfully.');
    }
}