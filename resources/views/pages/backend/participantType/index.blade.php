@extends('layouts.app')
@section('content')
    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <form method="POST" id="delete_form">
                    @csrf
                    @method('delete')
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete Participant Type</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="participant_type_id_delete_id" id="delete_participant_type_id">
                        <h5>Are you sure, you want to delete this Participant Type ?</h5>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Yes, delete it</button>
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
                    <a href="/admin/events/"> <button type="button" class="btn btn-success">Go To Events 
                        </button> </a>
                    <hr>
                    <table id="myDataTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col" width="10%">S.No.</th>
                                <th scope="col">Participant Type</th>
                                <th scope="col" width="55%">File</th>
                                <th class="text-center" width="170">Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            @php $i=1 @endphp

                            @foreach ($participantTypes as $participantType)
                                <tr>
                                    <td>{{ $i++ }} </td>
                                    <td>{{ $participantType->name }}</td>
                                    <td>{{ ($participantType->url) }}</td>
                                    <td class="text-center">

                                        <a title="Edit"
                                            href="/admin/events/{{ $event->id }}/participant-types/{{ $participantType->id }}/edit "
                                            class="btn btn-icon btn-circle btn-light"><i class="bi bi-pencil"></i></a>

                                        <button title="Delete" type="button"
                                            class="btn btn-icon btn-danger btn-circle delete deleteParticipantTypeBtn"
                                            value="{{ $participantType->id }}"><i class="bi bi-trash-fill"></i></button>

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

                var participant_type_id = $(this).val();

                // var event_id = $(this).data('event-id');
                // var participant_type_id = $(this).data('participant-type-id');


                // $('#delete_event_id').val(event_id);

                // $('#delete_form').attr('action', '/admin/events/' + event_id);
                $('#delete_form').attr('action', '/admin/events/' + {{ $event->id }} +
                    '/participant-types/' + participant_type_id);
                $('#deleteModal').modal('show');


            });
        });
    </script>
@endsection
