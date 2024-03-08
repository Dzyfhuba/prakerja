@extends('layouts.app')

@section('content')
    <div class="p-3">
        <a class="btn btn-primary d-block ml-auto" id='create' href='{{ route('students.create') }}'>
            Create
        </a>

        <div class="mb-3"></div>

        {{-- LIST RECORD --}}
        {{-- <div class="table-responsive"> --}}
        <div class="mb-3">
            {{ $data->links() }}
        </div>
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Favorites</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->email }}</td>
                        <td style="display: flex; flex-direction: column; gap: 8px;">
                            @foreach ($item->favorites as $f)
                                @if ($f == 0)
                                    Lainnya
                                @else
                                    {{ $f }}
                                @endif
                            @endforeach
                        </td>
                        <td>
                            <a href="{{ route('students.edit', $item->id) }}" class="btn w-100 btn-sm btn-warning">
                                Edit
                            </a>
                            <button type="button" class="btn btn-danger btn-sm w-100"
                                onclick="confirmAndDelete({{ $item->id }});">
                                Delete
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $data->links() }}
        {{-- </div> --}}
    </div>
@endsection

@push('script')
    <script>
        function confirmAndDelete(studentId) {
            var confirmation = confirm("Are you sure you want to delete?");

            if (confirmation) {
                // If the user confirms, send a DELETE request using Fetch API
                fetch(`/students/${studentId}`, {
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
