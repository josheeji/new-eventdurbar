@extends('layouts.app')

@section('title', 'Upload Excel File')
@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Upload Excel File
            </h5>
            <a href="/admin/events/{{ $event->id }}/participants"> <button type="button" class="btn btn-success">View
                    Participants
                </button> </a>

            <a href="/admin/events/{{ $event->id }}/participants/import/download-demo">
                <button type="button" class="btn btn-secondary">Download Demo
                </button>
            </a>

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
            <form class="form-sample" action="/admin/events/{{ $event->id }}/participants/upload-excel-file"
                method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row mb-3">
                    {{-- <label for="Event" class="col-sm-2 col-form-label">Event</label> --}}
                    <div class="col-sm-10">
                        <input type="hidden" name="event_id" id="event_id" value="{{ $event->id }}">
                    </div>
                </div>

                {{-- <div class="row mb-3">
                    <label for="event_id" class="col-sm-2 col-form-label">Event<span
                            class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <select id="event_id" name="event_id" class="custom-select form-control">
                            <option value="">Select Event</option>
                            @foreach ($events as $event)
                                <option value="{{ $event->id }}">{{ $event->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('event_id')
                        <span class='text-danger'>{{ $message }}</span>
                    @enderror
                </div> --}}

                <div class="row mb-3">
                    <label for="participant_type_id" class="col-sm-2 col-form-label">Participant Type<span
                            class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <select id="participant_type_id" name="participant_type_id" class="custom-select form-control">
                            <option value="">Participant Type</option>
                            @foreach ($participantTypes as $participantType)
                                <option value="{{ $participantType->id }}">{{ $participantType->name }}

                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('participant_type_id')
                        <span class='text-danger'>{{ $message }}</span>
                    @enderror
                </div>


                <div class="row mb-3">
                    <label for="excel_file" class="col-sm-2 col-form-label">File<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="file" name="excel_file" class="form-control" id="excel_file"
                            placeholder="Upload excel_file" value="{{ old('excel_file') }}">
                    </div>
                    @error('excel_file')
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
