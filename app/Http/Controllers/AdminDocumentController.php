<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserDocument;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class AdminDocumentController extends Controller
{
    public function create() {
        $users = User::all(); // show all users
        return view('adminunits', compact('users'));
    }
    

    public function store(Request $request) {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'type' => 'required|in:property_lease,certificate,deed,ticket',
            'file' => 'required|file|mimes:pdf',
        ]);

        $userId = $request->user_id;
        $type = $request->type;
        $file = $request->file('file');

        // store in public storage under user folder
        $path = $file->store("documents/user_$userId", 'public');

        // save or update record
        UserDocument::updateOrCreate(
            ['user_id' => $userId, 'type' => $type],
            ['file_path' => $path]
        );

        return back()->with('success', 'File uploaded!');
    }

    public function download($type)
{
    $allowed = ['property_lease', 'certificate', 'deed', 'ticket'];
    if (!in_array($type, $allowed)) {
        abort(404, 'Invalid document type.');
    }

    // Get the document for the logged-in user
    $doc = UserDocument::where('user_id', auth()->id())
                       ->where('type', $type)
                       ->firstOrFail();

    if (!Storage::disk('public')->exists($doc->file_path)) {
        abort(404, 'File not found.');
    }

    // Get the full file path
    $filePath = Storage::disk('public')->path($doc->file_path);

    // Open PDF in browser
    return response()->file($filePath);
}

public function checkFile($type)
{
    $allowed = ['property_lease', 'certificate', 'deed', 'ticket'];
    if (!in_array($type, $allowed)) {
        return response()->json(['exists' => false]);
    }

    $doc = UserDocument::where('user_id', auth()->id())
                       ->where('type', $type)
                       ->first();

    if (!$doc || !Storage::disk('public')->exists($doc->file_path)) {
        return response()->json(['exists' => false]);
    }

    return response()->json(['exists' => true]);
}


}