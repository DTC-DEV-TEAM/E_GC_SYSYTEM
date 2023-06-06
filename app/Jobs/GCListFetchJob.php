<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\GCList;
use App\QrCreation;
use Illuminate\Support\Facades\Http;


class GCListFetchJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $gc_list_data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {  

        // Prod
        // $response = Http::withHeaders([
        //     'Content-Type' => 'application/json',
        // ])->post('https://devp.digitstrading.ph/api/get-token', [
        //     'secret' => '9f56aa110c022b17fc1c7cec3fca2016',
        // ]);

        // $get_token = $response->json('data.access_token');

        // $redemption_list = Http::withHeaders([
        //     'Authorization' => 'Bearer ' . $get_token['data']['access_token'],
        // ])->get('https://devp.digitstrading.ph/api/redemption_code');

        // $gc_list_fetch = $redemption_list->json();
        
        // $gc_list_data = array_reverse($gc_list_fetch['data']);

        // foreach ($gc_list_data as $item) {
        //     GCList::firstOrCreate(
        //         ['id' => $item['id'], 'qr_reference_number' => $item['qr_reference_number']],
        //         $item
        //     );
        // }

        // Localhost Fetch Gclist
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('http://127.0.0.1:8080/api/get-token', [
            'secret' => '84aad301b67368285f7b6f17eed0a064',
        ]);

        $get_token = $response->json('data.access_token');

        $redemption_list = Http::withHeaders([
            'Authorization' => 'Bearer ' . $get_token['data']['access_token'],
        ])->get('http://127.0.0.1:8080/api/redemption_code');

        $gc_list_fetch = $redemption_list->json();
        
        $gc_list_data = array_reverse($gc_list_fetch['data']);

        foreach ($gc_list_data as $item) {
            GCList::firstOrCreate(
                ['id' => $item['id']],
                $item
            );
        }

        // Localhost fetch campaign
		$response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('http://127.0.0.1:8080/api/get-token', [
            'secret' => '84aad301b67368285f7b6f17eed0a064',
        ]);

        $get_token = $response->json('data.access_token');

        $redemption_list = Http::withHeaders([
            'Authorization' => 'Bearer ' . $get_token['data']['access_token'],
        ])->get('http://127.0.0.1:8080/api/qr_creation');

        $gc_list_fetch = $redemption_list->json();
        
        $gc_list_data = array_reverse($gc_list_fetch['data']);

        foreach ($gc_list_data as $item) {
            QrCreation::updateOrCreate(
                ['id' => $item['id']],
                $item
            );
        }
    }
}