@extends('layouts.app')

@section('title', 'Update Banner')
@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Update Banner Table
            </h5>
            <a href="{{ url('/admin/banners') }}"> <button type="button" class="btn btn-success">Back
                </button> </a>

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif
            <hr>
            <!-- Horizontal Form -->

            @if (session('message'))
                <h6 class="alert alert-success">{{ session('message') }} </h6>
            @endif
            <form class="form-sample" action="/admin/banners/{{ $banner->id }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="row mb-3">
                    <label for="title" class="col-sm-2 col-form-label">Banner Name<span
                            class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" name="title" class="form-control" id="title" placeholder="Banner title"
                            value="{{ old('title') ?? $banner->title }}">
                    </div>
                    @error('title')
                        <span class='text-danger'>{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-3 mb-3">
                    <button type="submit" id="submit_form" class="btn btn-primary btn-fw">Submit</button>

                </div>

            </form>
        </div>

        <!-- End Horizontal Form -->
    </div>

@endsection
