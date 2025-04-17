<?php

namespace App\Http\Controllers\Designer;

use App\Http\Controllers\Controller;
use App\Models\Design;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DesignController extends Controller
{
    /**
     * Display a listing of the designs.
     */
    public function index()
    {
        $designs = Auth::user()->designs()->latest()->get();
        return view('designer.designs.index', compact('designs'));
    }

    /**
     * Show the form for creating a new design.
     */
    public function create()
    {
        return view('designer.designs.create');
    }

    /**
     * Store a newly created design in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,published',
        ]);

        // Handle file upload
        $imagePath = $request->file('image')->store('designs', 'public');

        // Create design
        Auth::user()->designs()->create([
            'title' => $request->title,
            'description' => $request->description,
            'image_path' => $imagePath,
            'status' => $request->status,
        ]);

        return redirect()->route('designer.designs.index')
            ->with('success', 'Design posted successfully!');
    }

    /**
     * Display the specified design.
     */
    public function show(Design $design)
    {
        $this->authorize('view', $design);
        return view('designer.designs.show', compact('design'));
    }

    /**
     * Show the form for editing the specified design.
     */
    public function edit(Design $design)
    {
        $this->authorize('update', $design);
        return view('designer.designs.edit', compact('design'));
    }

    /**
     * Update the specified design in storage.
     */
    public function update(Request $request, Design $design)
    {
        $this->authorize('update', $design);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,published,archived',
        ]);

        // Update design data
        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
        ];

        // Handle image update if provided
        if ($request->hasFile('image')) {
            // Delete old image
            if ($design->image_path) {
                Storage::disk('public')->delete($design->image_path);
            }
            
            // Store new image
            $data['image_path'] = $request->file('image')->store('designs', 'public');
        }

        $design->update($data);

        return redirect()->route('designer.designs.index')
            ->with('success', 'Design updated successfully!');
    }

    /**
     * Remove the specified design from storage.
     */
    public function destroy(Design $design)
    {
        $this->authorize('delete', $design);

        // Delete the image file
        if ($design->image_path) {
            Storage::disk('public')->delete($design->image_path);
        }

        // Delete the design
        $design->delete();

        return redirect()->route('designer.designs.index')
            ->with('success', 'Design deleted successfully!');
    }
}