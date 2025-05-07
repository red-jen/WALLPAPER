<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wallpaper;
use App\Models\WallpaperImage;
use App\Models\Category;
use App\Models\Paper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class WallpaperController extends Controller
{
    /**
     * Display a listing of the wallpapers.
     */
    public function index()
    {
        $wallpapers = Wallpaper::with(['category', 'primaryImage'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Add categories for the filter dropdown
        $categories = Category::orderBy('name')->pluck('name', 'id');

        return view('admin.wallpapers.index', compact('wallpapers', 'categories'));
    }

    /**
     * Show the form for creating a new wallpaper.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->pluck('name', 'id');
        $papers = Paper::where('is_active', true)->orderBy('name')->get();

        return view('admin.wallpapers.create', compact('categories', 'papers'));
    }

    /**
     * Store a newly created wallpaper in storage.
     */
    public function store(Request $request)
    {


        // Debug what's being received
        $primaryIndex = $request->has('primary_image') ? $request->input('primary_image') : 0;
        // Rest of your code...
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'images' => 'required',  // Change from 'required|array|min:1'
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120',

            'image_titles' => 'nullable|array',
            'image_titles.*' => 'nullable|string|max:255',
            'primary_image' => 'nullable|integer|min:0', // Make this optional
            'price' => 'required|numeric|min:0',
            'width' => 'nullable|integer|min:1',
            'height' => 'nullable|integer|min:1',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:draft,published,featured',
            'paper_ids' => 'nullable|array',
            'paper_ids.*' => 'exists:papers,id',
            'recommended_paper_ids' => 'nullable|array',
            'recommended_paper_ids.*' => 'exists:papers,id',
        ]);

        // Create wallpaper
        $wallpaper = Wallpaper::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'category_id' => $validatedData['category_id'],
            'price' => $validatedData['price'],
            'width' => $validatedData['width'],
            'height' => $validatedData['height'],
            'stock' => $validatedData['stock'],
            'status' => $validatedData['status'],
        ]);

        // Handle multiple image uploads
        if ($request->hasFile('images')) {
            $images = $request->file('images');
            $primaryIndex = $request->input('primary_image', 0);
            $imageTitles = $request->input('image_titles', []);

            foreach ($images as $index => $image) {
                // Get image dimensions if not provided in wallpaper
                if (empty($wallpaper->width) || empty($wallpaper->height)) {
                    $imageInfo = getimagesize($image);
                    $wallpaper->width = $imageInfo[0];
                    $wallpaper->height = $imageInfo[1];
                }

                $filename = time() . '_' . Str::slug($wallpaper->title) . '_' . $index . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('wallpapers', $filename, 'public');

                // Create wallpaper image
                WallpaperImage::create([
                    'wallpaper_id' => $wallpaper->id,
                    'image_path' => $imagePath,
                    'title' => $imageTitles[$index] ?? null,
                    'is_primary' => $index == $primaryIndex,
                    'sort_order' => $index,
                ]);
            }

            // Save dimensions to wallpaper if detected from image
            if ($wallpaper->isDirty()) {
                $wallpaper->save();
            }
        }

        // Attach papers if selected
        if (!empty($validatedData['paper_ids'])) {
            $attachData = [];

            foreach ($validatedData['paper_ids'] as $paperId) {
                $isRecommended = !empty($validatedData['recommended_paper_ids']) &&
                    in_array($paperId, $validatedData['recommended_paper_ids']);

                $attachData[$paperId] = ['is_recommended' => $isRecommended];
            }

            $wallpaper->papers()->attach($attachData);
        }

        return redirect()->route('admin.wallpapers.index')
            ->with('success', 'Wallpaper created successfully!');
    }

    /**
     * Display the specified wallpaper.
     */
    public function show(Wallpaper $wallpaper)
    {
        $wallpaper->load(['category', 'images', 'papers', 'reviews' => function ($query) {
            $query->where('is_approved', true)->with('user');
        }]);

        return view('admin.wallpapers.show', compact('wallpaper'));
    }

    /**
     * Show the form for editing the specified wallpaper.
     */
    public function edit(Wallpaper $wallpaper)
    {
        $categories = Category::orderBy('name')->pluck('name', 'id');
        $papers = Paper::where('is_active', true)->orderBy('name')->get();

        // Load wallpaper images
        $wallpaper->load('images');

        // Get currently selected papers
        $selectedPaperIds = $wallpaper->papers->pluck('id')->toArray();
        $recommendedPaperIds = $wallpaper->papers()->wherePivot('is_recommended', true)->pluck('papers.id')->toArray();

        return view('admin.wallpapers.edit', compact(
            'wallpaper',
            'categories',
            'papers',
            'selectedPaperIds',
            'recommendedPaperIds'
        ));
    }

    /**
     * Update the specified wallpaper in storage.
     */
    public function update(Request $request, Wallpaper $wallpaper)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'new_images' => 'nullable|array',
            'new_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
            'new_image_titles' => 'nullable|array',
            'new_image_titles.*' => 'nullable|string|max:255',
            'existing_image_titles' => 'nullable|array',
            'existing_image_titles.*' => 'nullable|string|max:255',
            'delete_image_ids' => 'nullable|array',
            'delete_image_ids.*' => 'exists:wallpaper_images,id',
            'primary_image_id' => 'required|integer',
            'price' => 'required|numeric|min:0',
            // 'width' => 'nullable|integer|min:1',
            // 'height' => 'nullable|integer|min:1',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:draft,published,featured',
            'paper_ids' => 'nullable|array',
            'paper_ids.*' => 'exists:papers,id',
            'recommended_paper_ids' => 'nullable|array',
            'recommended_paper_ids.*' => 'exists:papers,id',
        ]);

        // Update wallpaper
        $wallpaper->title = $validatedData['title'];
        $wallpaper->description = $validatedData['description'];
        $wallpaper->category_id = $validatedData['category_id'];
        $wallpaper->price = $validatedData['price'];
        // $wallpaper->width = $validatedData['width'];
        // $wallpaper->height = $validatedData['height'];
        $wallpaper->stock = $validatedData['stock'];
        $wallpaper->status = $validatedData['status'];
        $wallpaper->save();

        // Handle existing image updates
        if ($request->has('existing_image_titles')) {
            foreach ($request->input('existing_image_titles') as $imageId => $title) {
                $image = WallpaperImage::find($imageId);
                if ($image && $image->wallpaper_id == $wallpaper->id) {
                    $image->title = $title;
                    $image->save();
                }
            }
        }

        // Delete images if requested
        if ($request->has('delete_image_ids')) {
            $deleteIds = $request->input('delete_image_ids');
            $imagesToDelete = WallpaperImage::where('wallpaper_id', $wallpaper->id)
                ->whereIn('id', $deleteIds)
                ->get();

            foreach ($imagesToDelete as $image) {
                // Delete the image file
                if (Storage::disk('public')->exists($image->image_path)) {
                    Storage::disk('public')->delete($image->image_path);
                }

                $image->delete();
            }
        }

        // Set primary image
        if ($request->has('primary_image_id')) {
            $primaryId = $request->input('primary_image_id');

            // If primary ID is negative, it's a new image
            $isPrimaryNew = $primaryId < 0;

            // Reset all existing images as not primary
            WallpaperImage::where('wallpaper_id', $wallpaper->id)
                ->update(['is_primary' => false]);

            if (!$isPrimaryNew) {
                // Set the selected existing image as primary
                WallpaperImage::where('id', $primaryId)
                    ->where('wallpaper_id', $wallpaper->id)
                    ->update(['is_primary' => true]);
            }
        }

        // Handle new image uploads
        if ($request->hasFile('new_images')) {
            $newImages = $request->file('new_images');
            $newImageTitles = $request->input('new_image_titles', []);
            $primaryIndex = null;

            // If primary is one of new images, get its index
            if ($primaryId < 0 && isset($isPrimaryNew) && $isPrimaryNew) {
                $primaryIndex = abs($primaryId) - 1; // Convert to 0-based index
            }

            $startIndex = $wallpaper->images()->max('sort_order') + 1;

            foreach ($newImages as $index => $image) {
                $filename = time() . '_' . Str::slug($wallpaper->title) . '_' . ($startIndex + $index) . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('wallpapers', $filename, 'public');

                // Create wallpaper image
                WallpaperImage::create([
                    'wallpaper_id' => $wallpaper->id,
                    'image_path' => $imagePath,
                    'title' => $newImageTitles[$index] ?? null,
                    'is_primary' => $index === $primaryIndex,
                    'sort_order' => $startIndex + $index,
                ]);
            }
        }

        // Make sure at least one image is primary
        $hasPrimary = $wallpaper->images()->where('is_primary', true)->exists();

        if (!$hasPrimary && $wallpaper->images()->exists()) {
            $firstImage = $wallpaper->images()->orderBy('id')->first();
            $firstImage->is_primary = true;
            $firstImage->save();
        }

        // Sync papers with recommended status
        if (isset($validatedData['paper_ids'])) {
            $attachData = [];

            foreach ($validatedData['paper_ids'] as $paperId) {
                $isRecommended = !empty($validatedData['recommended_paper_ids']) &&
                    in_array($paperId, $validatedData['recommended_paper_ids']);

                $attachData[$paperId] = ['is_recommended' => $isRecommended];
            }

            $wallpaper->papers()->sync($attachData);
        } else {
            $wallpaper->papers()->detach();
        }

        return redirect()->route('admin.wallpapers.index')
            ->with('success', 'Wallpaper updated successfully!');
    }

    /**
     * Remove the specified wallpaper from storage.
     */
    public function destroy(Wallpaper $wallpaper)
    {
        // Delete all associated image files
        foreach ($wallpaper->images as $image) {
            if (Storage::disk('public')->exists($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
            }
        }

        // Delete the wallpaper (and cascading relationships)
        $wallpaper->delete();

        return redirect()->route('admin.wallpapers.index')
            ->with('success', 'Wallpaper deleted successfully!');
    }

    /**
     * Update stock levels.
     */
    public function updateStock(Request $request, Wallpaper $wallpaper)
    {
        $request->validate([
            'stock' => 'required|integer|min:0',
        ]);

        $wallpaper->stock = $request->stock;
        $wallpaper->save();

        return back()->with('success', 'Stock updated successfully!');
    }

    /**
     * Reorder images
     */
    public function reorderImages(Request $request, Wallpaper $wallpaper)
    {
        $request->validate([
            'image_order' => 'required|array',
            'image_order.*' => 'required|integer|exists:wallpaper_images,id',
        ]);

        $order = $request->input('image_order');

        foreach ($order as $position => $imageId) {
            WallpaperImage::where('id', $imageId)
                ->where('wallpaper_id', $wallpaper->id)
                ->update(['sort_order' => $position]);
        }

        return response()->json(['success' => true]);
    }
}
