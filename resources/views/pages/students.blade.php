@extends('layouts.app')

@section('content')
    <div class="p-3">
        <button class="btn btn-primary d-block ml-auto" id='create' data-toggle="modal" data-target="#formModal">
            Create
        </button>

        <div class="mb-3"></div>

        {{-- LIST RECORD --}}
        {{-- <div class="table-responsive"> --}}
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>id</th>
                    <th>name</th>
                    <th>email</th>
                    <th>favorites</th>
                    <th>created At</th>
                    <th>updated At</th>
                </tr>
            </thead>
        </table>
        {{-- </div> --}}
    </div>

    <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="form">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add A New Student</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times" aria-hidden="true"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Oalah Siswa">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="name@example.com">
                        </div>
                        <div class="form-group">
                            <span>Favorites (Min: 1, Max: 3)</span>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="science" id="favoriteScience"
                                    name="favorites[]">
                                <label class="form-check-label" for="favoriteScience">
                                    Science
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="computer" id="favoriteComputer"
                                    name="favorites[]">
                                <label class="form-check-label" for="favoriteComputer">
                                    Computer
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="music" id="favoriteMusic"
                                    name="favorites[]">
                                <label class="form-check-label" for="favoriteMusic">
                                    Music
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="art" id="favoriteArt"
                                    name="favorites[]">
                                <label class="form-check-label" for="favoriteArt">
                                    Art
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="social" id="favoriteSocial"
                                    name="favorites[]">
                                <label class="form-check-label" for="favoriteSocial">
                                    Social
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="0" id="favorite0"
                                    name="favorites[]">
                                <label class="form-check-label" for="favorite0">
                                    There are no suitable options
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" type="submit">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <link href="{{ asset('sb-admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@push('script')
    <!-- Page level plugins -->
    <script src="{{ asset('sb-admin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('sb-admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <script>
        $('table').DataTable({
            ajax: '{{ route('students.get') }}',
            responsive: true
        })
    </script>

    <script>
        function disableButtonsAndModal() {
            // Disable all buttons inside the form
            var formButtons = document.getElementById('form').querySelectorAll('button');
            formButtons.forEach(function(button) {
                button.disabled = true;
            });

            // Disable the Bootstrap modal close trigger
            $('#formModal').modal({
                backdrop: 'static',
                keyboard: false
            });
        }

        function enableButtonsAndModal() {
            // Enable all buttons inside the form
            var formButtons = document.getElementById('form').querySelectorAll('button');
            formButtons.forEach(function(button) {
                button.disabled = false;
            });

            // Enable the Bootstrap modal close trigger
            $('#formModal').modal({
                backdrop: true,
                keyboard: true
            });
        }



        const favorites = document.querySelectorAll('input[name^="favorites"]')

        favorites.forEach(input => {
            input.addEventListener('change', (e) => {
                if (e.target.getAttribute('id') === 'favorite0') {
                    favorites.forEach(e2 => e2.removeAttribute('checked'))
                }

                const checkedInputs = document.querySelectorAll('input[name^="favorites"]:checked')
                const uncheckedInputs = document.querySelectorAll('input[name^="favorites"]:not(:checked)');

                if (checkedInputs.length < 3) {
                    uncheckedInputs.forEach((checkbox) => {
                        checkbox.removeAttribute('disabled')
                    })
                } else {
                    uncheckedInputs.forEach((checkbox) => {
                        checkbox.setAttribute('disabled', '')
                    })
                }
            })
        })

        document.querySelector('form#form').addEventListener('submit', (e) => {
            e.preventDefault()
            disableButtonsAndModal()

            const data = {
                name: document.querySelector('input[name="name"]').value,
                email: document.querySelector('input[name="email"]').value,
                favorites: [],
            }

            const checkedFavorites = document.querySelectorAll('input[name="favorites[]"]:checked');
            checkedFavorites.forEach((checkbox) => {
                data.favorites.push(checkbox.value);
            });

            const token = document.querySelector('[name="csrf-token"]').getAttribute('content')

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': token
                },
                timeout: 5000
            })
            $.ajax({
                url: '{{ route('students.store') }}',
                method: 'POST',
                data: data,
                success: function(response) {
                    console.log(response);
                    enableButtonsAndModal()
                },
                error: function(error) {
                    console.error(error);
                    enableButtonsAndModal()
                }
            })
        })
    </script>
@endpush
