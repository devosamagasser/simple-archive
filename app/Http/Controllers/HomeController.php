<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $query = request()->input('search');
    
        $folders = $user->folders()
                        ->whereNull('folder_id')
                        ->when($query, function ($queryBuilder) use ($query) {
                            $queryBuilder->where('name', 'like', "%$query%");
                        })  
                        ->withCount('files')
                        ->orderBy('created_at', 'desc')
                        ->get();
    
        $files = $user->files()
                      ->whereNull('folder_id')
                      ->when($query, function ($queryBuilder) use ($query) {
                        $queryBuilder->where('name', 'like', "%$query%");
                      }) 
                      ->orderBy('created_at', 'desc')
                      ->get();
    
        return view('home', compact('folders', 'files'));
    }



    public static function homeFolders()
    {
        $user = auth()->user();
        $folders = $user->folders()
                        ->whereNull('folder_id')
                        ->get();

        return $folders;   
    }
    
}
