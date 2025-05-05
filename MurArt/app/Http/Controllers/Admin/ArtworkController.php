<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artwork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArtworkController extends Controller
{
    /**
     * Display a listing of the artworks.
     */
    public function index(Request $request)
    {
        $query = Artwork::query()->with(['user', 'paper', 'design']);
        
        // Filter by status if provided
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by preview status
        if ($request->has('preview')) {
            if ($request->preview === 'pending') {
                $query->whereNull('preview_image')->orWhere('preview_status', 'pending');
            } elseif ($request->preview === 'approved') {
                $query->where('preview_status', 'approved');
            } elseif ($request->preview === 'rejected') {
                $query->where('preview_status', 'rejected');
            }
        }
        
        // Filter by production status
        if ($request->has('production')) {
            if ($request->production === 'pending') {
                $query->where('production_status', 'pending');
            } elseif ($request->production === 'completed') {
                $query->where('production_status', 'completed');
            }
        }
        
        $artworks = $query->latest()->paginate(10);
        
        return view('admin.artworks.index', compact('artworks'));
    }

    /**
     * Show the form for editing the specified artwork.
     */
    public function edit(Artwork $artwork)
    {
        return view('admin.artworks.edit', compact('artwork'));
    }

    /**
     * Store a preview image for the artwork.
     */
    public function storePreview(Request $request, Artwork $artwork)
    {
        $request->validate([
            'preview_image' => 'required|image|max:4096',
            'preview_notes' => 'nullable|string|max:500',
        ]);

        // Delete old preview image if exists
        if ($artwork->preview_image_path) {
            Storage::disk('public')->delete($artwork->preview_image_path);
        }

        // Store the new preview image
        $path = $request->file('preview_image')->store('artwork_previews', 'public');
        
        $artwork->update([
            'preview_image_path' => $path,
            'preview_status' => 'uploaded',
            'preview_updated_at' => now(),
            'status_notes' => $request->preview_notes
        ]);

        // TODO: Send notification to user that preview is available

        return redirect()->route('admin.artworks.edit', $artwork)
            ->with('success', 'Preview image uploaded successfully and customer has been notified.');
    }

    /**
     * Delete the preview image for the artwork.
     */
    public function deletePreview(Artwork $artwork)
    {
        if ($artwork->preview_image_path) {
            Storage::disk('public')->delete($artwork->preview_image_path);
        }

        $artwork->update([
            'preview_image_path' => null,
            'preview_status' => 'pending',
            'preview_updated_at' => now(),
        ]);

        return redirect()->route('admin.artworks.edit', $artwork)
            ->with('success', 'Preview image deleted successfully.');
    }

    /**
     * Update the artwork preview status.
     */
    public function updateStatus(Request $request, Artwork $artwork)
    {
        $request->validate([
            'preview_status' => 'required|in:pending,uploaded,approved,rejected',
            'status_notes' => 'nullable|string|max:500',
        ]);

        $artwork->update([
            'preview_status' => $request->preview_status,
            'status_notes' => $request->status_notes,
            'preview_updated_at' => now(),
        ]);

        // TODO: Send notification to user about status change if needed

        return redirect()->route('admin.artworks.edit', $artwork)
            ->with('success', 'Artwork preview status updated successfully.');
    }

    /**
     * Store a production image for the artwork.
     */
    public function storeProductionImage(Request $request, Artwork $artwork)
    {
        $request->validate([
            'production_image' => 'required|image|max:5120',
            'image_type' => 'required|in:production,ready,packaging',
            'image_note' => 'nullable|string|max:255',
            'notify_customer' => 'nullable|boolean',
        ]);

        // Store the production image
        $path = $request->file('production_image')->store('artwork_production', 'public');
        
        // Get current production images or initialize empty array
        $productionImages = $artwork->production_images ?? [];
        
        // Add new image
        $productionImages[] = $path;
        
        $artwork->update([
            'production_images' => $productionImages,
        ]);

        // TODO: Send notification to user if requested

        return redirect()->route('admin.artworks.edit', $artwork)
            ->with('success', 'Production image uploaded successfully.');
    }

    /**
     * Delete a production image.
     */
    public function deleteProductionImage(Artwork $artwork, $index)
    {
        $productionImages = $artwork->production_images ?? [];
        
        if (isset($productionImages[$index])) {
            // Delete the file
            Storage::disk('public')->delete($productionImages[$index]);
            
            // Remove from array
            unset($productionImages[$index]);
            
            // Reindex array
            $productionImages = array_values($productionImages);
            
            $artwork->update([
                'production_images' => $productionImages,
            ]);
            
            return redirect()->route('admin.artworks.edit', $artwork)
                ->with('success', 'Production image deleted successfully.');
        }
        
        return redirect()->route('admin.artworks.edit', $artwork)
            ->with('error', 'Production image not found.');
    }

    /**
     * Update the production status.
     */
    public function updateProductionStatus(Request $request, Artwork $artwork)
    {
        $request->validate([
            'production_status' => 'required|in:queued,in_progress,ready,shipped,delivered',
            'tracking_number' => 'nullable|string|max:100',
            'production_notes' => 'nullable|string|max:500',
            'notify_production_update' => 'nullable|boolean',
        ]);

        $artwork->update([
            'production_status' => $request->production_status,
            'tracking_number' => $request->tracking_number,
            'production_notes' => $request->production_notes,
        ]);

        // TODO: Send notification to user if requested

        return redirect()->route('admin.artworks.edit', $artwork)
            ->with('success', 'Production status updated successfully.');
    }
}