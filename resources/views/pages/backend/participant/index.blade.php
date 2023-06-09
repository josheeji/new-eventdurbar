@extends('layouts.app')
@section('content')
    <!--  Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <form method="POST" id="delete_form">
                    @csrf
                    @method('delete')
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete Participants </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="participant_delete_id" id="delete_participant_id">
                        <h5>Are you sure, you want to delete this Participants  ?</h5>
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
                <h5 class="card-title">Participants Table
                </h5>


                <!-- Default Table -->
                @if (session('message'))
                    <div class="alert alert-success">{{ session('message') }}</div>
                @endif
                <div class="card-body">
                    <a href="/admin/events/{{ $event->id }}/participants/create" class="btn btn-primary btn-sm">
                        <h6>Add New Participant</h6>
                    </a>
                    <a href="/admin/events/{{ $event->id }}/participants/import" class="btn btn-primary btn-sm">
                        <h6>Import file</h6>
                    </a>
                    <a href="/admin/events/"> <button type="button" class="btn btn-success">View Events
                        </button> </a>
                    <hr>
                    <table id="myDataTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col" width="10%">S.No.</th>
                                <th scope="col">Name</th>
                                <th scope="col">Affilated Institute</th>
                                <th scope="col">Post</th>
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

                                        <a title="Edit"
                                            href="/admin/events/{{ $event->id }}/participants/{{ $participant->id }}/edit "
                                            class="btn btn-icon btn-circle btn-light"><i class="bi bi-pencil"></i></a>

                                        <button title="Delete" type="button"
                                            class="btn btn-icon btn-danger btn-circle delete deleteParticipantBtn"
                                            value="{{ $participant->id }}"><i class="bi bi-trash-fill"></i></button>

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
            $('.deleteParticipantBtn').click(function(e) {
                e.preventDefault();

                var participant_id = $(this).val();
                var event_id = {{ $event->id }};


                $('#delete_form').attr('action', '/admin/events/' + {{ $event->id }} +
                    '/participants/' + participant_id);
                $('#deleteModal').modal('show');


            });
        });
    </script>
@endsection
