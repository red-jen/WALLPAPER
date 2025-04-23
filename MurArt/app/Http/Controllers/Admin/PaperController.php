<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Paper;
use Illuminate\Http\Request;

class PaperController extends Controller
{
    /**
     * Display a listing of papers.
     */
    public function index()
    {
        $papers = Paper::orderBy('name')->paginate(20);
        return view('admin.papers.index', compact('papers'));
    }

    /**
     * Show the form for creating a new paper.
     */
    public function create()
    {
        $paperTypes = [
            'Matte' => 'Matte',
            'Glossy' => 'Glossy',
            'Recycled' => 'Recycled',
            'Bond' => 'Bond',
            'Cardstock' => 'Cardstock',
            'Photo' => 'Photo',
            'Canvas' => 'Canvas',
            'Specialty' => 'Specialty',
            'Other' => 'Other',
        ];
        
        $paperSizes = [
            'A0' => 'A0',
            'A1' => 'A1',
            'A2' => 'A2',
            'A3' => 'A3',
            'A4' => 'A4',
            'A5' => 'A5',
            'Letter' => 'Letter (8.5" x 11")',
            'Legal' => 'Legal (8.5" x 14")',
            'Tabloid' => 'Tabloid (11" x 17")',
            'Custom' => 'Custom',
        ];
        
        $paperFinishes = [
            'Smooth' => 'Smooth',
            'Textured' => 'Textured',
            'Satin' => 'Satin',
            'Lustre' => 'Lustre',
            'Metallic' => 'Metallic',
            'Other' => 'Other',
        ];
        
        return view('admin.papers.create', compact('paperTypes', 'paperSizes', 'paperFinishes'));
    }

    /**
     * Store a newly created paper in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|string|max:255',
            'thickness' => 'nullable|integer|min:1',
            'size' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
            'finish' => 'nullable|string|max:255',
            'usage' => 'nullable|string',
            'is_active' => 'boolean',
            'price' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        // Set boolean value
        $validatedData['is_active'] = $request->has('is_active');
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('papers', 'public');
            $validatedData['image_path'] = $imagePath;
        }
        
        
        // Create paper
        Paper::create($validatedData);
        
        return redirect()->route('admin.papers.index')
            ->with('success', 'Paper type created successfully!');
    }

    /**
     * Display the specified paper.
     */
    public function show(Paper $paper)
    {
        return view('admin.papers.show', compact('paper'));
    }

    /**
     * Show the form for editing the specified paper.
     */
    public function edit(Paper $paper)
    {
        $paperTypes = [
            'Matte' => 'Matte',
            'Glossy' => 'Glossy',
            'Recycled' => 'Recycled',
            'Bond' => 'Bond',
            'Cardstock' => 'Cardstock',
            'Photo' => 'Photo',
            'Canvas' => 'Canvas',
            'Specialty' => 'Specialty',
            'Other' => 'Other',
        ];
        
        $paperSizes = [
            'A0' => 'A0',
            'A1' => 'A1',
            'A2' => 'A2',
            'A3' => 'A3',
            'A4' => 'A4',
            'A5' => 'A5',
            'Letter' => 'Letter (8.5" x 11")',
            'Legal' => 'Legal (8.5" x 14")',
            'Tabloid' => 'Tabloid (11" x 17")',
            'Custom' => 'Custom',
        ];
        
        $paperFinishes = [
            'Smooth' => 'Smooth',
            'Textured' => 'Textured',
            'Satin' => 'Satin',
            'Lustre' => 'Lustre',
            'Metallic' => 'Metallic',
            'Other' => 'Other',
        ];
        
        return view('admin.papers.edit', compact('paper', 'paperTypes', 'paperSizes', 'paperFinishes'));
    }

    /**
     * Update the specified paper in storage.
     */
    public function update(Request $request, Paper $paper)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|string|max:255',
            'thickness' => 'nullable|integer|min:1',
            'size' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
            'finish' => 'nullable|string|max:255',
            'usage' => 'nullable|string',
            'is_active' => 'boolean',
            'price' => 'nullable|numeric|min:0',
        ]);
        
        // Set boolean value
        $validatedData['is_active'] = $request->has('is_active');
        
        // Update paper
        $paper->update($validatedData);
        
        return redirect()->route('admin.papers.index')
            ->with('success', 'Paper type updated successfully!');
    }

    /**
     * Remove the specified paper from storage.
     */
    public function destroy(Paper $paper)
    {
        // Check if paper is associated with any designs
        if ($paper->designs()->count() > 0) {
            return back()->with('error', 'Cannot delete this paper type because it is associated with designs.');
        }
        
        // Delete paper
        $paper->delete();
        
        return redirect()->route('admin.papers.index')
            ->with('success', 'Paper type deleted successfully!');
    }
}