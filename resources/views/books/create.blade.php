<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Book') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($errors->has('error'))
                <p style="color: red;">{{ $errors->first('error') }}</p>
            @endif
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('books.store') }}" method="POST">
                        @csrf       
                        <div class="mb-4">
                            <label for="title" class="block text-gray-700 font-bold mb-2">Title:</label>    
                            <input type="text" name="title" id="title" class="border border-gray-400 p-2 w-full" required>
                        </div>
                        <div class="mb-4">
                            <label for="description" class="block text-gray-700 font-bold mb-2">Description:</label>    
                            <textarea name="description" id="description" class="border border-gray-400 p-2 w-full" required></textarea>
                        </div>  
                        <div class="mb-4">
                            <label for="isbn" class="block text-gray-700 font-bold mb-2">ISBN:</label>    
                            <input type="text" name="isbn" id="isbn" class="border border-gray-400 p-2 w-full" required>
                        </div>
                        <div class="mb-4">
                            <label for="format" class="block text-gray-700 font-bold mb-2">Format:</label>    
                            <input type="text" name="format" id="format" class="border border-gray-400 p-2 w-full" required>
                        </div>
                        <div class="mb-4">
                            <label for="number_of_pages" class="block text-gray-700 font-bold mb-2">Number of pages:</label>    
                            <input type="number" name="number_of_pages" id="number_of_pages" class="border border-gray-400 p-2 w-full" required>
                        </div>
                        <div class="mb-4">
                            <label for="release_date" class="block text-gray-700 font-bold mb-2">Release date:</label>    
                            <input type="date" name="release_date" id="release_date" class="border border-gray-400 p-2 w-full" required>
                        </div>
                        <div class="mb-4">
                            <label for="author_id" class="block text-gray-700 font-bold mb-2">Author:</label>    
                            <select name="author_id" id="author_id" class="border border-gray-400 p-2 w-full" required>
                                @foreach ($authors['items'] as $author)
                                    <option value="{{ $author['id'] }}">{{ $author['first_name'] . ' ' . $author['last_name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">  
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Create Book</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>