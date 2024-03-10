@extends('layouts.app')

@section('content')
    <div class="p-3">
        @role('admin')
            <a class="btn btn-primary d-block ml-auto w-max" id='create' href='{{ route('users.create') }}'>
                Create
            </a>
        @endrole

        <div class="mb-3"></div>

        {{-- LIST RECORD --}}
        <div class="mb-3">
          {{ $data->links() }}
        </div>
        <div class="table-responsive">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Roles</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->email }}</td>
                        <td>
                          @foreach ($item->roles as $role)
                            @if ($role->name == 'admin')
                            <button class="btn btn-sm btn-success">
                            @elseif ($role->name == 'writer')
                            <button class="btn btn-sm btn-warning">
                            @elseif ($role->name == 'user')
                            <button class="btn btn-sm btn-info">
                            @else
                            <button class="btn btn-sm btn-secondary">
                            @endif
                              {{$role->name}}
                            </button>
                          @endforeach
                        </td>
                        <td>
                            @if (auth()->user()->hasRole('admin'))
                                <a href="{{ route('users.edit', $item->id) }}" class="btn w-max btn-sm btn-warning">
                                    Edit
                                </a>
                                <button type="button" class="btn btn-danger btn-sm w-max" data-toggle="modal" data-target="#deleteModal{{$item->id}}">
                                  Delete
                                </button>
                                <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1"
                                    aria-labelledby="deleteModalLabel" aria-hidden="true">
                                    <form action="{{ route('users.destroy', $item->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel">Are you sure you want to
                                                        delete?</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    "{{ $item->name }}" will be deleted and can't restored
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </div>
                                            </div>
                                    </form>
                                </div>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $data->links() }}
        </div>
    </div>
@endsection

@push('script')
    <script>
        function confirmAndDelete(studentId) {
            var confirmation = confirm("Are you sure you want to delete?");

            if (confirmation) {
                // If the user confirms, send a DELETE request using Fetch API
                fetch(`/users/${studentId}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
                            // You may include additional headers if required, such as CSRF token
                        },
                        // You can include a request body if needed
                        // body: JSON.stringify({}),
                    })
                    .then(response => {
                        if (response.ok) {
                            // Successful deletion
                            // You may want to redirect or perform additional actions
                            console.log('Student deleted successfully');
                            window.location.reload()
                        } else {
                            // Handle error responses
                            console.error('Error deleting student');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            } else {
                // If the user cancels, do nothing
            }
        }
    </script>
@endpush
