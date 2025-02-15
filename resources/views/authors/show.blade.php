<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Author Details') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <div class="font-semibold text-xl text-gray-800 leading-tight pb-3">{{ $author['first_name'] . ' ' . $author['last_name'] }}</div>

            {{-- Author Delete Button --}}
            @if(count($author['books']) == 0)
                <div class="flex justify-end mb-4">
                    <form action="{{ route('authors.destroy', $author['id']) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded" onclick="return confirm('Are you sure?')">Delete Author</button>
                    </form>
                </div>
            @endif

            <table class="table-auto w-full mb-6">
                <tbody>
                    <tr>
                        <td class="border px-4 py-2 font-semibold">Birthday:</td>
                        <td class="border px-4 py-2">{{ Carbon\Carbon::parse($author['birthday'])->format('Y-m-d') }}</td>
                    </tr>
                    <tr>
                        <td class="border px-4 py-2 font-semibold">Gender:</td>
                        <td class="border px-4 py-2">{{ $author['gender'] }}</td>
                    </tr>
                    <tr>
                        <td class="border px-4 py-2 font-semibold">Biography:</td>
                        <td class="border px-4 py-2">{{ $author['biography'] }}</td>
                    </tr>
                    <tr>
                        <td class="border px-4 py-2 font-semibold">Place of birth:</td>
                        <td class="border px-4 py-2">{{ $author['place_of_birth'] }}</td>
                    </tr>
                </tbody>
            </table>

            <h2 class="text-xl font-semibold mb-2">Books</h2>
                <div class="flex justify-end mb-4">
                    <a href="{{ route('books.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Add Book</a>
                </div>
            
            @if(session('success'))
                <p style="color: green;">{{ session('success') }}</p>
            @endif  

            @if ($errors->has('error'))
                <p style="color: red;">{{ $errors->first('error') }}</p>
            @endif
            
            <table class="table-auto w-full mb-6">
                <thead>
                    <tr>
                        <th class="border px-4 py-2">Title</th>
                        <th class="border px-4 py-2">Description</th>
                        <th class="border px-4 py-2">ISBN</th>
                        <th class="border px-4 py-2">Format</th>
                        <th class="border px-4 py-2">Number of pages</th>
                        <th class="border px-4 py-2">Release Date</th>
                        <th class="border px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($author['books']) > 0)
                        @foreach($author['books'] as $book)
                            <tr>
                                <td class="border px-4 py-2">{{ $book['title'] }}</td>
                                <td class="border px-4 py-2">{{ $book['description'] }}</td>
                                <td class="border px-4 py-2">{{ $book['isbn'] }}</td>
                                <td class="border px-4 py-2">{{ $book['format'] }}</td>
                                <td class="border px-4 py-2">{{ $book['number_of_pages'] }}</td>
                                <td class="border px-4 py-2">{{ Carbon\Carbon::parse($book['release_date'])->format('Y-m-d') }}</td>
                                <td class="border px-4 py-2">
                                    <form action="{{ route('books.delete', $book['id']) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded" onclick="return confirm('Are you sure you want to delete the book titled {{ $book['title'] }}')">Delete</button>
                                    </form> 
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="border px-4 py-2" colspan="7">No books found.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>