@extends('layouts.app')

@section('title', 'Create Events')
@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Create Events Table
            </h5>
            <a href="{{ url('/admin/events') }}"> <button type="button" class="btn btn-success">Back
                </button> </a>

            {{-- @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif --}}
            <hr>
            <!-- Horizontal Form -->

            @if (session('message'))
                <h6 class="alert alert-success">{{ session('message') }} </h6>
            @endif
            <form class="form-sample" action="/admin/events" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row mb-3">
                    <label for="name" class="col-sm-2 col-form-label">Event Name<span
                            class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" name="name" class="form-control" id="name" placeholder="Event Name"
                            value="{{ old('name') }}">
                    </div>
                    @error('name')
                        <span class='text-danger'>{{ $message }}</span>
                    @enderror
                </div>


                <div class="row mb-3">
                    <label for="event_slug" class="col-sm-2 col-form-label">Event Slug<span
                            class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" name="event_slug" id="event_slug" class="form-control" id="event_slug"
                            placeholder="Event Slug" value="{{ old('event_slug') }}">
                        {{-- <input type="hidden" id="event_slug" name="event_slug"> --}}

                    </div>
                    @error('event_slug')
                        <span class='text-danger'>{{ $message }}</span>
                    @enderror
                </div>


                <div class="row mb-3">
                    <label for="iamge" class="col-sm-2 col-form-label"> Image</label>
                    <div class="col-sm-10">
                        <input type="file" name="image" class="form-control" id="image" placeholder="Event Image"
                            value="{{ old('image') }}">
                    </div>
                    @error('image')
                        <span class='text-danger'>{{ $message }}</span>
                    @enderror
                </div>



                <div class="row mb-3">
                    <label for="short_description" class="col-sm-2 col-form-label">Short Description</label>
                    <div class="col-sm-10">
                        <textarea name="short_description" id="short_description" rows="4" cols="107">{{ old('short_description') }}</textarea>
                    </div>
                    @error('short_description')
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

    <script>
        $(document).ready(function() {
            $('#name').on('input', function() {
                var name = $(this).val();
                var slug = generateSlug(name);
                $('#event_slug').val(slug);
            });

            function generateSlug(name) {
                return name.trim()
                    .toLowerCase()
                    .replace(/[^a-z0-9-]+/g, '-')
                    .replace(/^-+|-+$/g, '');
            }
        });
    </script>

@endsection
