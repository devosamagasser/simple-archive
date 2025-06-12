<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class FolderController extends Controller
{

    

    // Store a newly created folder in storage
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:public,private',
            'folder_id' => 'nullable|integer|exists:folders,id',
        ]);

        auth()->user()->folders()->create([
            'name' => $request->name,
            'status' => $request->status,
            'folder_id' => $request->folder_id,
        ]);
    
        return redirect()->back()->with('success', 'Folder created successfully!');
    }
    

    // Display the specified folder
    public function show(Folder $folder, Request $request)
    {
        $query = $request->input('search');
    
        $foldersQuery = Folder::where('folder_id', $folder->id);
        $filesQuery = $folder->files();
    
        if ($query) {
            $foldersQuery->where('name', 'like', "%$query%");
            $filesQuery->where('name', 'like', "%$query%");
        }
    
        $folders = $foldersQuery->get();
        $files = $filesQuery->get();
    
        return view('Folders.show', compact('folder', 'folders', 'files'));
    }
    

    // Show the form for editing the specified folder
    public function edit(Folder $folder)
    {
        return view('folders.edit', compact('folder'));
    }

    // Update the specified folder in storage
    public function update(Request $request, Folder $folder)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:public,private',
        ]);

        $folder->update([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Folder updated successfully.');
    }

    // Remove the specified folder from storage
    public function destroy(Folder $folder)
    {
        $folder->delete();

        return redirect()->back()->with('success', 'Folder deleted successfully.');
    }
}