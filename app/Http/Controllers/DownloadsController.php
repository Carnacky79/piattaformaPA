<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadsController extends Controller
{
    public function download($file_name) {
        return Storage::download('documenti/'.$file_name);
    }
}
