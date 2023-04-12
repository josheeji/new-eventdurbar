@extends('layouts.app')
@section('content')
    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Participant Type</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <p>Are you sure you want to delete this participant type?</p>
                        <input type="hidden" name="participant_type_id" id="participantTypeId" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Delete Modal -->


    <div class="col-lg-12">

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Participant Types Table
                </h5>


                <!-- Default Table -->
                @if (session('message'))
                    <div class="alert alert-success">{{ session('message') }}</div>
                @endif
                <div class="card-body">
                    <a href="/admin/events/{{ $event->id }}/participant-types/create" class="btn btn-primary btn-sm">
                        <h6>Add New Participant Types</h6>
                    </a>
                    <a href="/admin/events/"> <button type="button" class="btn btn-success">Back
                        </button> </a>
                    <hr>
                    <table id="myDataTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col" width="10%">S.No.</th>
                                <th scope="col">Name</th>
                                <th scope="col">File</th>
                                <th class="text-center" width="170">Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            @php $i=1 @endphp

                            @foreach ($participantTypes as $participantType)
                                <tr>
                                    <td>{{ $i++ }} </td>
                                    <td>{{ $participantType->name }}</td>
                                    <td>{{ $participantType->url }}</td>
                                    <td class="text-center">

                                        <a title="Edit"
                                            href="/admin/events/{{ $event->id }}/participant-types/{{ $participantType->id }}/edit "
                                            class="btn btn-icon btn-circle btn-light"><i class="bi bi-pencil"></i></a>

                                        {{-- <button title="Delete" type="button"
                                            class="btn btn-icon btn-danger btn-circle deleteParticipantTypeBtn"
                                            value="{{ $participantType->id }}"><i class="bi bi-trash-fill"></i></button> --}}

                                        <button title="Delete" type="button"
                                            class="btn btn-icon btn-danger btn-circle delete deleteParticipantTypeBtn"
                                            data-id="{{ $participantType->id }}"><i class="bi bi-trash-fill"></i></button>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>

                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection


@section('scripts')
    <script>
        $(document).ready(function() {
            $('.deleteParticipantTypeBtn').click(function(e) {
                e.preventDefault();

                // Get the participant type ID and event ID
                var participantTypeId = $(this).val();
                var eventId = {{ $event->id }};

                // Set the action of the form to include the participant type ID and event ID
                $('#delete_form').attr('action', '/admin/events/' + eventId + '/participant-types/' +
                    participantTypeId);

                // Show the delete modal
                $('#deleteModal').modal('show');
            });
        });
    </script>
@endsection
