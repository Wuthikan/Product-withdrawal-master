<?php

namespace DurianSoftware\Http\Controllers\api;

use DurianSoftware\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DurianSoftware\Platform;
use DurianSoftware\Publisher;

class GeneralController extends Controller
{

    public function getPublisher($id)
    {
        $publishers = Publisher::where('client_id', $id)->withTrashed()->get();
        return response()
            ->json([
                'status' => 200,
                'message' => 'success',
                'data' => $publishers
            ]);
    }
}
