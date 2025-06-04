<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Design;
use App\Models\Category;
use Illuminate\Http\Request;

class DesignController extends Controller
{
    /**
     * Display a listing of all available designs for clients.
     */
    public function index(Request $request)
    {
        // Start with a query builder, not a collection
        $query = Design::query();

        // Only show approved designs to clients - this is the key change
        $query->where('status', 'approved');

        // Filter by category if provided
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        // Get the designs with their designer and category
        $designs = $query->with(['designer', 'category'])
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        // Get all categories for filtering
        $categories = Category::get();

        return view('client.designs.index', compact('designs', 'categories'));
    }

    /**
     * Display the specified design.
     */
    public function show(Design $design)
    {
        // Check if design is approved - redirect if not
        if ($design->status !== 'approved') {
            return redirect()->route('designs.index')
                ->with('error', 'This design is not available for viewing.');
        }

        // Load related models
        $design->load(['designer', 'category']);

        // Get similar designs in same category - only approved ones
        $similarDesigns = Design::where('category_id', $design->category_id)
            ->where('id', '!=', $design->id)
            ->where('status', 'approved')
            ->with('designer')
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('client.designs.show', compact('design', 'similarDesigns'));
    }

    /**
     * Go to create artwork form with a pre-selected design.
     */
    public function createWithDesign(Design $design)
    {
        // Only allow approved designs to be used for artworks
        if ($design->status !== 'approved') {
            return redirect()->route('designs.index')
                ->with('error', 'This design is not available for use.');
        }

        // Redirect to artwork creation page with design ID in session
        session(['selected_design_id' => $design->id]);

        return redirect()->route('artworks.create');
    }
}
