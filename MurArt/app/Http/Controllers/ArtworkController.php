<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Artwork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArtworkController extends Controller
{
    /**
     * Display a listing of the user's artworks.
     */
    public function index()
    {
        $artworks = Auth::user()->artworks()->latest()->get();
        return view('artworks.index', compact('artworks'));
    }

    /**
     * Show the form for creating a new artwork.
     */
    public function create()
    {
        return view('artworks.create');
    }

    /**
     * Store a newly created artwork in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'medium' => 'nullable|string|max:255',
            'dimensions' => 'nullable|string|max:255',
            'year_created' => 'nullable|integer|min:1900|max:' . date('Y'),
            'price' => 'nullable|numeric|min:0',
            'is_for_sale' => 'boolean',
            'is_featured' => 'boolean',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle file upload
        $imagePath = $request->file('image')->store('artworks', 'public');

        // Create artwork with user relationship
        $artwork = Auth::user()->artworks()->create([
            'title' => $request->title,
            'description' => $request->description,
            'medium' => $request->medium,
            'dimensions' => $request->dimensions,
            'year_created' => $request->year_created,
            'price' => $request->price,
            'is_for_sale' => $request->has('is_for_sale'),
            'is_featured' => $request->has('is_featured'),
            'image_path' => $imagePath,
        ]);

        return redirect()->route('artworks.index')
            ->with('success', 'Artwork created successfully!');
    }

    /**
     * Display the specified artwork.
     */
    public function show(Artwork $artwork)
    {
        // Optional: Check if the current user owns this artwork or if it's public
        return view('artworks.show', compact('artwork'));
    }

    /**
     * Show the form for editing the specified artwork.
     */
    public function edit(Artwork $artwork)
    {
        $this->authorize('update', $artwork);
        return view('artworks.edit', compact('artwork'));
    }

    /**
     * Update the specified artwork in storage.
     */
    public function update(Request $request, Artwork $artwork)
    {
        $this->authorize('update', $artwork);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'medium' => 'nullable|string|max:255',
            'dimensions' => 'nullable|string|max:255',
            'year_created' => 'nullable|integer|min:1900|max:' . date('Y'),
            'price' => 'nullable|numeric|min:0',
            'is_for_sale' => 'boolean',
            'is_featured' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update artwork data
        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'medium' => $request->medium,
            'dimensions' => $request->dimensions,
            'year_created' => $request->year_created,
            'price' => $request->price,
            'is_for_sale' => $request->has('is_for_sale'),
            'is_featured' => $request->has('is_featured'),
        ];

        // Handle image update if provided
        if ($request->hasFile('image')) {
            // Delete old image
            if ($artwork->image_path) {
                Storage::disk('public')->delete($artwork->image_path);
            }
            
            // Store new image
            $data['image_path'] = $request->file('image')->store('artworks', 'public');
        }

        $artwork->update($data);

        return redirect()->route('artworks.index')
            ->with('success', 'Artwork updated successfully!');
    }

    /**
     * Remove the specified artwork from storage.
     */
    public function destroy(Artwork $artwork)
    {
        $this->authorize('delete', $artwork);

        // Delete the image file
        if ($artwork->image_path) {
            Storage::disk('public')->delete($artwork->image_path);
        }

        // Delete the artwork
        $artwork->delete();

        return redirect()->route('artworks.index')
            ->with('success', 'Artwork deleted successfully!');
    }
} 