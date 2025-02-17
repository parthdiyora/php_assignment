<x-app-layout>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.min.css">

    <!-- jQuery & DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Authors List') }}
        </h2>
    </x-slot>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if ($errors->has('error'))
        <p style="color: red;">{{ $errors->first('error') }}</p>
    @endif

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <!-- Search Input -->
            <div class="mb-4">
                <input type="text" id="searchBox" class="w-full border px-4 py-2" placeholder="Search authors...">
            </div>
            <table class="table-auto w-full mb-6" id="authorsTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Birthday</th>
                        <th>Gender</th>
                        <th>Place of birth</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            let table = $('#authorsTable').DataTable({
                processing: true,
                serverSide: true,
                searching: false, 
                pageLength: 5,
                lengthMenu: [5, 10, 25, 50],
                ajax: function(data, callback) {
                    let apiBaseUrl = "{{ config('app.api_base_url') }}";
                    let baseUrl = "{{ config('app.url') }}"
    
                    let params = {
                        query: $('#searchBox').val(),
                        order_by: data.columns[data.order[0].column].data || "id",
                        direction: data.order[0].dir || "ASC",
                        limit: data.length,
                        page: (data.start / data.length) + 1
                    };
                    // add csrf token to the request headers
                    $.ajax({
                        url: "{{ route('authors.data') }}",
                        headers: {
                            'accept': 'application/json',
                        },
                        method: "GET",
                        data: params,
                        success: function(response) {
                            callback({
                                draw: data.draw,
                                recordsTotal: response.total_results,
                                recordsFiltered: response.total_results,
                                data: response.items
                            });
                        },
                        error: function() {
                            alert("Failed to fetch authors.");
                        }
                    });
                },
                columns: [
                    { data: "id" },
                    { data: "first_name" },
                    { data: "birthday", render: function(data) {
                        return new Date(data).toLocaleDateString();
                    }},
                    { data: "gender" },
                    { data: "place_of_birth" },
                    { data: "id", render: function(data) {
                        return `<a href="/authors/${data}" class="bg-blue-500 text-white px-4 py-2 rounded">View</a>`;
                    }}
                ]
            });

            $('#searchBox').keyup(function() {
                $('#authorsTable').DataTable().ajax.reload();
            });
        });
    </script>
</x-app-layout>
