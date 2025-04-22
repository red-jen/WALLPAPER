<?php

namespace App\Http\Controllers;

use App\Models\Design;
use App\Models\Category;
use App\Models\Paper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DesignController extends Controller
{
    /**
     * Display a listing of the designs.
     */
    public function index()
    {
        $designs = Design::where('designer_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->with(['category'])
            ->paginate(12);

        return view('designer.designs.index', compact('designs'));
    }

    /**
     * Show the form for creating a new design.
     */
    public function create()
    {
        $categories = Category::all(['id', 'name']);
        return view('designer.designs.create', compact('categories'));
    }

    /**
     * Store a newly created design in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('designs', $filename, 'public');
        }

        // Create design with the fields from migration
        $design = Design::create([
            'title' => $validatedData['title'],
            'image_path' => $imagePath,
            'designer_id' => Auth::id(),
            'category_id' => $validatedData['category_id'],
        ]);

        return redirect()->route('designs.show', $design)
            ->with('success', 'Design created successfully!');
    }

    /**
     * Display the specified design.
     */
    public function show(Design $design)
    {
        // Load related papers
        $design->load(['category', 'designer']);
        
        // Get recommended papers for this design
        $recommendedPapers = Paper::where('is_active', true)
            ->inRandomOrder()
            ->limit(4)
            ->get();
        
        return view('designer.designs.show', compact('design', 'recommendedPapers'));
    }

    /**
     * Show the form for editing the specified design.
     */
    public function edit(Design $design)
    {
        // Check if the current user owns this design
        if ($design->designer_id !== Auth::id()) {
            return redirect()->route('designs.index')
                ->with('error', 'You are not authorized to edit this design.');
        }

        $categories = Category::orderBy('name')->pluck('name', 'id');
        
        return view('designer.designs.edit', compact('design', 'categories'));
    }

    /**
     * Update the specified design in storage.
     */
    public function update(Request $request, Design $design)
    {
        // Check if the current user owns this design
        if ($design->designer_id !== Auth::id()) {
            return redirect()->route('designs.index')
                ->with('error', 'You are not authorized to update this design.');
        }

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($design->image_path && Storage::disk('public')->exists($design->image_path)) {
                Storage::disk('public')->delete($design->image_path);
            }

            $image = $request->file('image');
            $filename = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('designs', $filename, 'public');
            $design->image_path = $imagePath;
        }

        // Update design fields
        $design->title = $validatedData['title'];
        $design->category_id = $validatedData['category_id'];
        $design->save();

        return redirect()->route('designs.show', $design)
            ->with('success', 'Design updated successfully!');
    }

    /**
     * Remove the specified design from storage.
     */
    public function destroy(Design $design)
    {
        // Check if the current user owns this design
        if ($design->designer_id !== Auth::id()) {
            return redirect()->route('designs.index')
                ->with('error', 'You are not authorized to delete this design.');
        }

        // Delete the image file
        if ($design->image_path && Storage::disk('public')->exists($design->image_path)) {
            Storage::disk('public')->delete($design->image_path);
        }

        // Delete the design
        $design->delete();

        return redirect()->route('designs.index')
            ->with('success', 'Design deleted successfully!');
    }
}