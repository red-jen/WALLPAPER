<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the tags.
     */
    public function index()
    {
        $tags = Tag::withCount('designs')
            ->orderBy('name')
            ->paginate(20);

        return view('admin.tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new tag.
     */
    public function create()
    {
        return view('admin.tags.create');
    }

    /**
     * Store a newly created tag in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:tags',
        ]);

        // Create tag
        Tag::create($validatedData);

        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag created successfully!');
    }

    /**
     * Display the specified tag.
     */
    public function show(Tag $tag)
    {
        $tag->load(['designs' => function($query) {
            $query->orderBy('created_at', 'desc')->paginate(12);
        }]);
        
        return view('admin.tags.show', compact('tag'));
    }

    /**
     * Show the form for editing the specified tag.
     */
    public function edit(Tag $tag)
    {
        return view('admin.tags.edit', compact('tag'));
    }

    /**
     * Update the specified tag in storage.
     */
    public function update(Request $request, Tag $tag)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:tags,name,' . $tag->id,
        ]);

        // Update tag
        $tag->update($validatedData);

        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag updated successfully!');
    }

    /**
     * Remove the specified tag from storage.
     */
    public function destroy(Tag $tag)
    {
        // Delete tag
        $tag->delete();

        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag deleted successfully!');
    }
}