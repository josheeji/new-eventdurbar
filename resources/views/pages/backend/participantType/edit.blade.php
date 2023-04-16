@extends('layouts.app')

@section('title', 'Update Events')
@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Update Events Table
            </h5>
            <a href="{{ url('/admin/events') }}"> <button type="button" class="btn btn-success">Back
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
            <form class="form-sample" action="/admin/events/{{ $event->id }}/participant-types/{{ $participantType->id }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="row mb-3">
                    <label for="name" class="col-sm-2 col-form-label">Event Name<span
                            class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" name="name" class="form-control" id="name" placeholder="Event Name"
                            value="{{ old('name') ?? $participantType->name }}">
                    </div>
                    @error('name')
                        <span class='text-danger'>{{ $message }}</span>
                    @enderror
                </div>

                <div class="row mb-3">
                    <label for="url" class="col-sm-2 col-form-label">HTML File<span
                            class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="file" name="url" class="form-control" id="url"
                            placeholder="Upload Certificate url" value="{{ old('url') ?? $participantType->url }}">
                    </div>
                    @error('url')
                        <span class='text-danger'>{{ $message }}</span>
                    @enderror
                </div>

                <div class="row mb-3">
                    <label for="template_files" class="col-sm-2 col-form-label">Template Files</label>
                    <div class="col-sm-10">

                        <input type="file" class="form-control" id="template_files" name="template_files[]" multiple
                            value="{{ old('template_files') ?? $participantType->template_files }}">
                    </div>
                    @error('template_files')
                        <span class='text-danger'>{{ $message }}</span>
                    @enderror
                </div>
                <div class="row mb-3">
                    <label for="template_height" class="col-sm-2 col-form-label">Template Height</label>
                    <div class="col-sm-10">
                        <input type="text" name="template_height" class="form-control" id="template_height"
                            placeholder="Template Height"
                            value="{{ old('template_height') ?? $participantType->template_height }}">
                    </div>
                    @error('template_height')
                        <span class='text-danger'>{{ $message }}</span>
                    @enderror
                </div>

                <div class="row mb-3">
                    <label for="template_width" class="col-sm-2 col-form-label">Template Width</label>
                    <div class="col-sm-10">
                        <input type="text" name="template_width" class="form-control" id="template_width"
                            placeholder="Template Width"
                            value="{{ old('template_width') ?? $participantType->template_width }}">
                    </div>
                    @error('template_width')
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
