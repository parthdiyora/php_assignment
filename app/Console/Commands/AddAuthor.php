<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class AddAuthor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'author:add {first_name} {last_name} {birthday} {biography} {gender} {place_of_birth}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a new author via the API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $client = new Client();

        $apiToken = Cache::get('api_token');

        if (!$apiToken) {
            $this->error('API token not found. Please login first.');
            return;
        }

        $data = [
            'first_name' => $this->argument('first_name'),
            'last_name' => $this->argument('last_name'),
            'birthday' => $this->argument('birthday'),
            'biography' => $this->argument('biography'),
            'gender' => $this->argument('gender'),
            'place_of_birth' => $this->argument('place_of_birth')
        ];


        try {
            $client->post(config('app.api_base_url') . 'authors', [
                'headers' => [
                    'Authorization' => $apiToken,
                    'Content-Type' => 'application/json',
                ],
                'json' => $data
            ]);

            $this->info('Author added successfully!');
        } catch (\Exception $e) {
            $this->error($e->getMessage());
            $this->error('Failed to add author.');
        }
    }
}
