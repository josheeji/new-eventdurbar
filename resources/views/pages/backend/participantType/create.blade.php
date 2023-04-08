@extends('layouts.app')

@section('title', 'Create participant Type')
@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Create participant Type Table
            </h5>
            <a href="/admin/events/{{$event->id}}/participant-types"> <button type="button" class="btn btn-success">Back
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
                        <input type="text" name="name" class="form-control" id="name" placeholder="Event Name"
                            value="{{ old('name') }}">
                    </div>
                    @error('name')
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
