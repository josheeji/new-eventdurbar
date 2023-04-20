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
                        <h5>Are you sure, you want to delete this category ?</h5>
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
                    <a href="/admin/events/create" class="btn btn-primary btn-sm">
                        <h6>Add New Event</h6>
                    </a>
                    <hr>
                    <table id="myDataTable" class="table table-bordered">
                        <thead>
                            <tr>

                                <th scope="col" width="10%">S.No.</th>
                                <th scope="col">Name</th>
                                <th scope="col">Image</th>
                                <th scope="col">Short Description</th>
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

                                    <td>
                                        <img src="{{ asset($event->image) }}" alt="Image" width="70px" height="70px">

                                    </td>

                                    <td>{{ $event->short_description }}</td>
                                    <td class="text-center">

                                        <a href="/admin/events/{{ $event->id }}/participant-types"
                                            class="btn btn-primary"> Participant Types</a>


                                        <a href='/admin/events/{{ $event->id }}/participants' class="btn btn-primary">
                                            Participants</a>

                                        {{-- <a title="View Participant Types"
                                            href="/admin/events/{{ $event->id }}/participant-types"
                                            class="btn btn-icon btn-circle btn-light"><i
                                                class="bi bi-card-checklist"></i></a>
                                                 --}}



                                        {{-- <a title="View Participant" href="/admin/events/{{ $event->id }}/participants"
                                            class="btn btn-icon btn-circle btn-light"><i
                                                class="bi bi-card-checklist"></i></a> --}}
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


@endsection
