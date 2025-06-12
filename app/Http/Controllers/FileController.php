<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    /**
     * Store a newly created file in storage.
     */
    public function store(Request $request)
    {
        try{
            $request->validate([
                'name' => 'required|string|max:255',
                'file' => 'required|file',
                'status' => 'required|in:public,private',
                'short_description' => 'nullable|string|max:255',
                // 'long_description' => 'nullable|string',
                // 'type' => 'required|in:image,video,audio,document,other',
                'folder_id' => 'nullable|exists:folders,id',
            ]);
        
            $path = $request->file('file')->store('uploads/files');
            
            File::create([
                'name' => $request->name,
                'path' => $path,
                'status' => $request->status,
                'user_id' => auth()->id(),
                'folder_id' => $request->folder_id,
                'short_description' => $request->short_description,
                'long_description' => $request->long_description,
                'type' => 'image',
            ]);
            
            return redirect()->back()->with('success', 'File uploaded successfully!');
        } catch(\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with('error', 'File upload failed: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified file.
     */
    public function show($id)
    {
        $file = File::findOrFail($id);
        $user = auth()->user();
    
        // 🔒 حماية الملفات الخاصة
        if ($file->status === 'private' && $file->user_id !== $user->id && !$file->sharedUsers->contains($user->id)) {
            return back()->with('error', 'You do not have permission to view this file.');
        }
    
        return view('Files.show', compact('file'));
    }
    
    

    /**
     * Update the specified file in storage.
     */
    public function update(Request $request, File $file)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'file' => 'nullable|file',
            'status' => 'required|in:public,private',
            'short_description' => 'nullable|string|max:255',
            'long_description' => 'nullable|string',
            // 'type' => 'required|in:image,video,audio,document,other',
        ]);

        $data = [
            'name' => $request->name,
            'status' => $request->status,
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,
            'type' => 'image',
        ];
        if($request->hasFile('file')) {
            Storage::delete($file->path);
            $path = $request->file('file')->store('uploads/files');
            $data['path'] = $path;
        }

        $file->update($data);

        return redirect()->back()->with('success', 'File updated successfully!');
    }


    
    public function download($id)
    {
        $file = File::findOrFail($id);
        $user = auth()->user();
    
        // 🔒 حماية الملفات الخاصة
        if ($file->status === 'private' && $file->user_id !== $user->id && !$file->sharedUsers->contains($user->id)) {
            return back()->with('error', 'You do not have permission to download this file.');
        }
    
        $path = storage_path('app/public/' . $file->path);
    
        if (!file_exists($path)) {            dd('File not found: ' . $path);

            return back()->with('error', 'File not found!');
        }
    
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        $fileName = $file->name . '.' . $extension;
    
        return response()->download($path, $fileName);
    }
    
    
    
    public function share(Request $request)
    {
        $file = File::findOrFail($request->file_id);
        $user = User::where('email', $request->email)->first();
    
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found']);
        }
    
        // إضافة الصلاحية إذا لم تكن مضافة بالفعل
        if (!$file->sharedUsers()->where('user_id', $user->id)->exists()) {
            $file->sharedUsers()->attach($user->id);
        }
    
        return response()->json(['success' => true, 'email' => $user->email, 'user_id' => $user->id]);
    }
    
    public function removeAccess(Request $request)
    {
        $file = File::findOrFail($request->file_id);
        $user = User::findOrFail($request->user_id);
    
        $file->sharedUsers()->detach($user->id);
    
        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified file from storage.
     */
    public function destroy(File $file)
    {
        Storage::delete($file->path);
        $file->delete();

        return redirect()->back()->with('success', 'File deleted successfully!');
    }
}