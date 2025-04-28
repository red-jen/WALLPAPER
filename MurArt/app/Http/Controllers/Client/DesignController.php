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
        
        // Filter by category if provided
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }
        
        // Get the designs with their designer and category
        $designs = $query->with(['designer', 'category'])  // 'with' not 'where'
                        //  ->orderBy('featured', 'desc')
                         ->orderBy('created_at', 'desc')
                         ->paginate(12);
        
        // Get all categories for filtering
        $categories = Category::get();
        
        return view('client.designs.index', compact('designs', 'categories'));
    }
    
    // Rest of controller remains unchanged

    
    /**
     * Display the specified design.
     */
    public function show(Design $design)
    {
        // Load related models
        $design->load(['designer', 'category']);
        
        // Get similar designs in same category
        $similarDesigns = Design::where('category_id', $design->category_id)
        ->where('id', '!=', $design->id)
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
        // Redirect to artwork creation page with design ID in session
        session(['selected_design_id' => $design->id]);
        
        return redirect()->route('artworks.create');
    }
} 