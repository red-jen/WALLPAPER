<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Artwork;
use App\Models\Design;
use App\Models\Paper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArtworkController extends Controller
{
    public function create()
    {
        $papers = Paper::where('is_active', true)->get();
        $designs = Design::all();
        return view('client.artworks.create', compact('papers', 'designs'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'width' => 'nullable|integer|min:1',
            'height' => 'nullable|integer|min:1',
            'paper_id' => 'required|exists:papers,id',
            'design_id' => 'required|exists:designs,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $imagePath = $request->file('image')->store('artworks', 'public');

        // Create artwork with user_id
        $artwork = Artwork::create([
            'user_id' => auth()->id(), // Add the authenticated user's ID
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'width' => $validatedData['width'],
            'height' => $validatedData['height'],
            'paper_id' => $validatedData['paper_id'],
            'design_id' => $validatedData['design_id'],
            'image_path' => $imagePath,
        ]);

        return redirect()->route('artworks.show', $artwork)
            ->with('success', 'Artwork created successfully!');
    }


    /**
 * Display the specified artwork.
 */
public function show(Artwork $artwork)
{
    // Load the necessary relationships
    $artwork->load(['paper', 'design']);
    
    return view('client.artworks.show', compact('artwork'));
}

/**
 * Show the form for editing the specified artwork.
 */
public function edit(Artwork $artwork)
{
    // Get active papers and all designs
    $papers = Paper::where('is_active', true)
        ->orderBy('name')
        ->get();
    
    $designs = Design::orderBy('title')
        ->get();
    
    return view('client.artworks.edit', compact('artwork', 'papers', 'designs'));
}
    public function update(Request $request, Artwork $artwork)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'width' => 'nullable|integer|min:1',
            'height' => 'nullable|integer|min:1',
            'paper_id' => 'required|exists:papers,id',
            'design_id' => 'required|exists:designs,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            Storage::disk('public')->delete($artwork->image_path);
            
            // Store new image
            $validatedData['image_path'] = $request->file('image')->store('artworks', 'public');
        }
     
        $artwork->update($validatedData);

        return redirect()->route('artworks.show', $artwork)
            ->with('success', 'Artwork updated successfully!');
    }
}