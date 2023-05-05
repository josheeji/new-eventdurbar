@extends('layouts.app')

@section('title', 'Update Events')
@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Update Events Table
            </h5>
            <a href="{{ url('/admin/events') }}"> <button type="button" class="btn btn-success">Go To Events
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
            <form class="form-sample" action="/admin/events/{{ $event->id }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('put')

                <div class="row mb-3">
                    <label for="name" class="col-sm-2 col-form-label">Event Name<span
                            class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" name="name" class="form-control" id="name" placeholder="Event Name"
                            value="{{ old('name') ?? $event->name }}">
                    </div>
                    @error('name')
                        <span class='text-danger'>{{ $message }}</span>
                    @enderror
                </div>


                {{-- <div class="row mb-3">
                    <label for="event_slug" class="col-sm-2 col-form-label">Event Slug<span
                            class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text"class="form-control" name="event_slug" id="event_slug" placeholder="Event Slug"
                            value="{{ old('event_slug') ?? $event->event_slug }}">

                        <input type="hidden" id="event_slug" name="event_slug">

                    </div>
                    @error('event_slug')
                        <span class='text-danger'>{{ $message }}</span>
                    @enderror
                </div> --}}


                <div class="row mb-3">
                    <label for="event_slug" class="col-sm-2 col-form-label">Event Slug<span
                            class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" name="event_slug" id="event_slug" class="form-control" id="event_slug"
                            placeholder="Event Slug" value="{{ old('event_slug', $event->event_slug ?? '') }}">
                    </div>
                    @error('event_slug')
                        <span class='text-danger'>{{ $message }}</span>
                    @enderror
                </div>


                <div class="row mb-3">
                    <label for="image" class="col-sm-2 col-form-label">Image<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="file" name="image" class="form-control" id="image" placeholder="Upload Image"
                            value="{{ old('image') ?? $event->image }}">

                        @if ($event->image)
                            <img src="{{ asset('storage/events/' . $event['image']) }}" alt="Event Image" width="70px"
                                height="70px">
                        @endif
                    </div>
                    @error('image')
                        <span class='text-danger'>{{ $message }}</span>
                    @enderror
                </div>
                <div class="row mb-3">
                    <label for="short_description" class="col-sm-2 col-form-label">Short Description<span
                            class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <textarea name="short_description" id="short_description" rows="4" cols="107">{{ old('short_description') ?? $event->short_description }} </textarea>
                        {{-- <textarea name="short_description"id="short_description">{{ old('short_description', $event->short_description) }} </textarea> --}}

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
            var nameInput = $('#name');
            var slugInput = $('#event_slug');

            // Set initial slug based on the current value of the name input
            slugInput.val(generateSlug(nameInput.val()));

            // Update slug when name input changes
            nameInput.on('input', function() {
                var name = $(this).val();
                var slug = generateSlug(name);
                slugInput.val(slug);
            });

            // Update slug when label for name input is clicked
            $('label[for="name"]').on('click', function() {
                var name = nameInput.val();
                var slug = generateSlug(name);
                slugInput.val(slug);
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
