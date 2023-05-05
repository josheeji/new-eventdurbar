@extends('layouts.app')
@section('title', 'Events Table')

@section('content')

    <!--  Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <form action={{ '/admin/events' }} method="POST" id="delete_form">
                    @csrf
                    @method('delete')
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete Event</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="event_delete_id" id="delete_event_id">
                        <h5>Are you sure, you want to delete this Event ?</h5>
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
                <h5 class="card-title">EventS Table

                </h5>

                <!-- Default Table -->
                @if (session('message'))
                    <div class="alert alert-success">{{ session('message') }}</div>
                @endif
                <div class="card-body">

                    <a href="/admin/events/create">
                        <button class="btn btn-primary" type="submit">Add New Event</button>
                    </a>

                    <a href="/admin/events/trash">
                        <button class="btn btn-danger" type="submit">Go to trash</button>
                    </a>
                    <hr>
                    <table id="myDataTable" class="table table-bordered">

                        <thead>
                            <tr>

                                <th scope="col" width="10%">S.No.</th>
                                <th scope="col">Name</th>
                                <th scope="col">Slug</th>
                                <th scope="col">Image</th>
                                {{-- <th scope="col">Short Description</th> --}}
                                <th scope="col">Associations</th>
                                <th class="text-center" width="170">Action</th>

                            </tr>

                        </thead>
                        <tbody>
                            @php $i=1 @endphp

                            @foreach ($events as $event)
                                <tr>
                                    <td>{{ $i++ }} </td>
                                    <td>{{ $event->name }}</td>
                                    <td>{{ $event->event_slug }}</td>

                                    <td>
                                        @if ($event->image)
                                            <img src="{{ asset('storage/events/' . $event->image) }}"
                                                alt="{{ $event->name }}" width="70px" height="70px">
                                        @endif
                                    </td>

                                    <td class="text-center">


                                        <a title="Add Partidcipant Type"
                                            href="/admin/events/{{ $event->id }}/participant-types">
                                            <button class="btn btn-primary" type="submit"> Participant Types</button>
                                        </a>

                                        <a title="Add Participant" 
                                        href="/admin/events/{{ $event->id }}/participants">
                                            <button class="btn btn-primary" type="submit">Participants</button>
                                        </a>
                                    </td>
                                    <td>

                                        <a title="Edit" href="/admin/events/{{ $event->id }}/edit"
                                            class="btn btn-icon btn-circle btn-light"><i class="bi bi-pencil"></i></a>



                                        <button title="Delete" type="button"
                                            class="btn btn-icon btn-danger btn-circle delete deleteEventBtn"
                                            value="{{ $event->id }}"><i class="bi bi-trash-fill"></i></button>
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
            $('.deleteEventBtn').click(function(e) {
                e.preventDefault();

                var event_id = $(this).val();
                // $('#delete_event_id').val(event_id);

                $('#delete_form').attr('action', '/admin/events/' + event_id);
                $('#deleteModal').modal('show');


            });
        });
    </script>


    {{-- <script>
        $(document).ready(function() {
            $('#myDataTable').DataTable();
        });
    </script> --}}


@endsection
