<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class AuthorController extends Controller
{
        private $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    // Fetch and display the list of authors
    public function index()
    {
        try {
            $response = $this->client->get(config('app.api_base_url'). "authors", [
                'headers' => [
                    'Authorization' => session('api_token'),
                ]
            ]);

            $authors = json_decode($response->getBody(), true);

            return view('authors.index', compact('authors'));
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to fetch authors.']);
        }
    }

    // Display a single author's details and books
    public function show($id)
    {
        try {
            $response = $this->client->get(config('app.api_base_url') . "authors/{$id}", [
                'headers' => [
                    'Authorization' => session('api_token'),
                ]
            ]);

            $author = json_decode($response->getBody(), true);  

            return view('authors.show', compact('author'));
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to fetch author details.']);
        }
    }

    // Delete an author
    public function destroy($id)
    {
        try {
            $this->client->delete( config('app.api_base_url') . "authors/{$id}", [
                'headers' => [
                    'Authorization' => session('api_token'),
                ]
            ]);

            return redirect()->route('authors.index')->with('success', 'Author deleted successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to delete the author.']);
        }
    }

     // Delete a book
     public function deleteBook($bookId)
     {
         try {
             $this->client->delete(config('app.api_base_url') . "books/{$bookId}", [
                 'headers' => [
                     'Authorization' => session('api_token'),
                 ]
             ]);
 
             return back()->with('success', 'Book deleted successfully.');
         } catch (\Exception $e) {
             return back()->withErrors(['error' => 'Failed to delete book.']);
         }
     }
 
     // Show the "Add Book" form
     public function createBook()
     {
        try {
            $response = $this->client->get(  config('app.api_base_url'). "authors", [
                'headers' => [
                    'Authorization' => 'Bearer ' . session('api_token'),
                ]
            ]);

            $authors = json_decode($response->getBody(), true);
            return view('books.create', compact('authors'));
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to fetch authors.']);
        }
     }
 
     // Store a new book
     public function storeBook(Request $request)
     {
        $request->validate([
            'author_id' => 'required|integer',
            'title'    => 'required|string',
            'release_date' => 'required|date',
            'description' => 'required|string',
            'isbn' => 'required|string',
            'format' => 'required|string',
            'number_of_pages' => 'required|integer',
        ]);
 
         try {
            $response = $this->client->post(config('app.api_base_url') . "books", [
                'headers' => [
                    'Authorization' => session('api_token'),
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'author' => [
                        'id' => $request->input('author_id'),
                    ],
                    'title' => $request->input('title'),
                    'release_date' => $request->input('release_date'),
                    'description' => $request->input('description'),
                    'isbn' => $request->input('isbn'),
                    'format' => $request->input('format'),
                    'number_of_pages' => (int)$request->input('number_of_pages'),
                ]
            ]);

            $book = json_decode($response->getBody(), true);

            if($response->getStatusCode() == 200){
                return redirect()->route('authors.show', ['id' => $book['author']['id']])->with('success', 'Book added successfully.');
            } else {
                return back()->withErrors(['error' => 'Failed to add book.']);
            }
            
        } catch (\Exception $e) {
             return back()->withErrors(['error' => 'Failed to add book.']);
        }
    }
}
