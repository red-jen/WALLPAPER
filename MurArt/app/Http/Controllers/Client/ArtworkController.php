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
    /**
     * Display a listing of artworks.
     */
    public function index()
    {
        $artworks = Artwork::with(['paper', 'design'])
            ->when(Auth::check(), function ($query) {
                return $query->where('user_id', Auth::id());
            })
            ->latest()
            ->paginate(12);

        return view('client.artworks.index', compact('artworks'));
    }

    public function create()
    {
        // Get all papers and designs
        $papers = Paper::all();
        $designs = Design::get();
        
        // Check if there's a pre-selected design from session
        $selectedDesignId = session('selected_design_id');
        
        // Clear the session after use
        session()->forget('selected_design_id');
        
        return view('client.artworks.create', compact('papers', 'designs', 'selectedDesignId'));
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






/**
 * Approve the artwork preview
 */
public function approvePreview(Artwork $artwork)
{
    // Verify the artwork belongs to the current user
    if ($artwork->user_id !== auth()->id()) {
        abort(403, 'Unauthorized action.');
    }
    
    // Update the preview status
    $artwork->update([
        'preview_status' => 'approved',
        'preview_approved_at' => now(),
    ]);
    
    return redirect()->route('artworks.show', $artwork)
        ->with('success', 'Preview approved successfully! You can now proceed with your order.');
}

/**
 * Reject the artwork preview and provide feedback
 */
public function rejectPreview(Request $request, Artwork $artwork)
{
    // Validate input
    $request->validate([
        'feedback' => 'required|string|min:10',
    ]);
    
    // Verify the artwork belongs to the current user
    if ($artwork->user_id !== auth()->id()) {
        abort(403, 'Unauthorized action.');
    }
    
    // Update the preview status with feedback
    $artwork->update([
        'preview_status' => 'rejected',
        'feedback' => $request->feedback,
        'preview_updated_at' => now(),
    ]);
    
    return redirect()->route('artworks.show', $artwork)
        ->with('success', 'Feedback submitted successfully! Our design team will review your comments and update the preview.');
}
}
