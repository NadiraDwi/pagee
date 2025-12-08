<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AudiusController extends Controller
{
    // Node paling stabil
    private $node = "https://discoveryprovider.audius.co";

    public function search(Request $request)
    {
        $q = $request->query('q');

        $response = Http::get("$this->node/v1/tracks/search", [
            'query' => $q,
            'app_name' => 'TemenHoliday'
        ]);

        return $response->json();
    }

    public function stream(Request $request)
{
    $id = $request->query('id');

    $response = Http::withOptions(['allow_redirects' => false])
        ->get("https://discoveryprovider3.audius.co/v1/tracks/$id/stream", [
            'app_name' => 'TemenHoliday'
        ]);

    return response()->json([
        "requested_id" => $id,
        "status" => $response->status(),
        "headers" => $response->headers(),
        "body" => substr($response->body(), 0, 500), // biar gak kepanjangan
        "note" => "Jika status 302, header Location harus muncul."
    ]);
}

}
