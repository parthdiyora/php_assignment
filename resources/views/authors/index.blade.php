<x-app-layout>
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
            <table class="table-auto w-full mb-6">
                <thead>
                    <tr>
                        <th class="border px-4 py-2">ID</th>
                        <th class="border px-4 py-2">Name</th>
                        <th class="border px-4 py-2">Birthday</th>
                        <th class="border px-4 py-2">Gender</th>
                        <th class="border px-4 py-2">Place of birth</th>
                        <th class="border px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($authors['items'] as $author)
                        <tr>
                            <td class="border px-4 py-2 text-center">{{ $author['id'] }}</td>
                            <td class="border px-4 py-2 text-center">{{ $author['first_name'] . $author['last_name'] }}</td>
                            <td class="border px-4 py-2 text-center">
                                {{ Carbon\Carbon::parse($author['birthday'])->format('Y-m-d') }}</td>
                            <td class="border px-4 py-2 text-center">{{ $author['gender'] }}</td>
                            <td class="border px-4 py-2 text-center">{{ $author['place_of_birth'] }}</td>
                            <td class="border px-4 py-2 text-center">
                                <a href="{{ route('authors.show', $author['id']) }}" class="bg-blue-500 text-white px-4 py-2 rounded">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
