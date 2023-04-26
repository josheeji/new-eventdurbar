@extends('layouts.app')

@section('title', 'Create participant Type')
@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Create participant Type
            </h5>
            <a href="/admin/events/{{ $event->id }}/participant-types"> <button type="button" class="btn btn-success">View Participant Types
                </button> </a>


            <hr>
            <!-- Horizontal Form -->

            @if (session('message'))
                <h6 class="alert alert-success">{{ session('message') }} </h6>
            @endif
            <form class="form-sample" action="/admin/events/{{ $event->id }}/participant-types " method="POST"
                enctype="multipart/form-data">
                @csrf

                <div class="row mb-3">
                    {{-- <label for="Event" class="col-sm-2 col-form-label">Event</label> --}}
                    <div class="col-sm-10">
                        <input type="hidden" name="event_id" id="event_id" value="{{ $event->id }}">
                    </div>
                </div>


                <div class="row mb-3">
                    <label for="name" class="col-sm-2 col-form-label">Participant Type Name<span
                            class="text-danger">*</span></label>
                    <div class="col-sm-8">
                        <input type="text" name="name" class="form-control" id="name" placeholder="Participant Type Name"
                            value="{{ old('name') }}">
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
                            placeholder="Upload Certificate url" value="{{ old('url') }}">
                    </div>
                    @error('url')
                        <span class='text-danger'>{{ $message }}</span>
                    @enderror
                </div>

                <div class="row mb-3">
                    <label for="template_files" class="col-sm-2 col-form-label">Template Files</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control" id="template_files" name="template_files[]" multiple
                            value="{{ old('template_files') }}">
                    </div>
                    @error('template_files')
                        <span class='text-danger'>{{ $message }}</span>
                    @enderror
                </div>
                <div class="row mb-3">
                    <label for="template_height" class="col-sm-2 col-form-label">Template Height</label>
                    <div class="col-sm-10">
                        <input type="text" name="template_height" class="form-control" id="template_height"
                            placeholder="Template Height" value="{{ old('template_height') }}">
                    </div>
                    @error('template_height')
                        <span class='text-danger'>{{ $message }}</span>
                    @enderror
                </div>

                <div class="row mb-3">
                    <label for="template_width" class="col-sm-2 col-form-label">Template Width</label>
                    <div class="col-sm-10">
                        <input type="text" name="template_width" class="form-control" id="template_width"
                            placeholder="Template Width" value="{{ old('template_width') }}">
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

@section('scripts')
