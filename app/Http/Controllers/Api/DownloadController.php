<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DownloadController extends Controller
{
    public function downloadCv()
    {
        return response()->download(public_path('downloads/cv.pdf'));
    }
}
