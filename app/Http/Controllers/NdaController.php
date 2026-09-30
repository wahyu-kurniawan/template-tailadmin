<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NdaController extends Controller
{
    public function showForm()
    {
        $user = Auth::user();
        return view('nda.form', compact('user'));
    }

    public function downloadTemplate()
    {
        $path = storage_path('app/public/template_nda.pdf'); 
        return response()->download($path);
    }

    public function uploadNda(Request $request)
    {
        $request->validate([
            'nda_file' => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $user = Auth::user();
        
        $path = $request->file('nda_file')->store('nda_documents', 'public');

        $user->update([
            'nda_document_path' => $path,
            'status' => 'pending_verification'
        ]);

        return back()->with('success', 'Dokumen NDA berhasil diunggah. Menunggu verifikasi Admin.');
    }
}
