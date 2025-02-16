<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class XSSController extends Controller
{
    public function showForm()
    {
        return view('xss.form'); 
    }

    public function sanitizeInput(Request $request)
    {
        $sanitizedData = htmlspecialchars($request->input('comment'), ENT_QUOTES, 'UTF-8');

        return response()->json([
            'original' => $request->input('comment'),
            'sanitized' => $sanitizedData,
            'message' => 'Input berhasil disanitasi!'
        ]);
    }
}
