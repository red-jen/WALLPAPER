<?php

// namespace App\Http\Controllers;

// use App\Models\Design;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Storage;
// use Illuminate\Support\Str;

// class DesignController extends Controller
// {
//     /**
//      * Display a listing of the designs.
//      */
//     public function index()
//     {
//         $designs = Design::where('user_id', Auth::id())
//             ->orderBy('created_at', 'desc')
//             ->paginate(12);

//         return view('designs.index', compact('designs'));
//     }

//     /**
//      * Show the form for creating a new design.
//      */
//     public function create()
//     {
//         return view('designs.create');
//     }

//     /**
//      * Store a newly created design in storage.
//      */
//     public function store(Request $request)
//     {
//         $validatedData = $request->validate([
//             'title' => 'required|string|max:255',
//             'description' => 'nullable|string',
//             'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
//             'price' => 'nullable|numeric|min:0',
//             'width' => 'nullable|string|max:255',
//             'height' => 'nullable|string|max:255',
//             'format' => 'nullable|string|max:255',
//             'tags' => 'nullable|string',
//         ]);

//         // Handle image upload
//         $imagePath = null;
//         if ($request->hasFile('image')) {
//             $image = $request->file('image');
//             $filename = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
//             $imagePath = $image->storeAs('designs', $filename, 'public');
//         }

//         // Process tags
//         $tags = [];
//         if (!empty($validatedData['tags'])) {
//             $tags = array_map('trim', explode(',', $validatedData['tags']));
//         }

//         // Create design
//         $design = Design::create([
//             'title' => $validatedData['title'],
//             'description' => $validatedData['description'],
//             'image_path' => $imagePath,
//             'user_id' => Auth::id(),
//             'status' => 'draft',
//             'price' => $validatedData['price'],
//             'width' => $validatedData['width'],
//             'height' => $validatedData['height'],
//             'format' => $validatedData['format'] ?? $request->file('image')->getClientOriginalExtension(),
//             'tags' => $tags,
//         ]);

//         return redirect()->route('designs.show', $design)
//             ->with('success', 'Design created successfully!');
//     }

//     /**
//      * Display the specified design.
//      */
//     public function show(Design $design)
//     {
//         // Increment view count
//         $design->increment('views');
        
//         return view('designs.show', compact('design'));
//     }

//     /**
//      * Show the form for editing the specified design.
//      */
//     public function edit(Design $design)
//     {
//         // Check if the current user owns this design
//         if ($design->user_id !== Auth::id()) {
//             return redirect()->route('designs.index')
//                 ->with('error', 'You are not authorized to edit this design.');
//         }

//         return view('designs.edit', compact('design'));
//     }

//     /**
//      * Update the specified design in storage.
//      */
//     public function update(Request $request, Design $design)
//     {
//         // Check if the current user owns this design
//         if ($design->user_id !== Auth::id()) {
//             return redirect()->route('designs.index')
//                 ->with('error', 'You are not authorized to update this design.');
//         }

//         $validatedData = $request->validate([
//             'title' => 'required|string|max:255',
//             'description' => 'nullable|string',
//             'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
//             'price' => 'nullable|numeric|min:0',
//             'width' => 'nullable|string|max:255',
//             'height' => 'nullable|string|max:255',
//             'format' => 'nullable|string|max:255',
//             'tags' => 'nullable|string',
//             'status' => 'nullable|in:draft,pending,published',
//         ]);

//         // Handle image upload if provided
//         if ($request->hasFile('image')) {
//             // Delete old image if exists
//             if ($design->image_path && Storage::disk('public')->exists($design->image_path)) {
//                 Storage::disk('public')->delete($design->image_path);
//             }

//             $image = $request->file('image');
//             $filename = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
//             $imagePath = $image->storeAs('designs', $filename, 'public');
//             $design->image_path = $imagePath;
//         }

//         // Process tags
//         if (isset($validatedData['tags'])) {
//             $tags = array_map('trim', explode(',', $validatedData['tags']));
//             $design->tags = $tags;
//         }

//         // Update design fields
//         $design->title = $validatedData['title'];
//         $design->description = $validatedData['description'];
//         $design->price = $validatedData['price'];
//         $design->width = $validatedData['width'];
//         $design->height = $validatedData['height'];
//         $design->format = $validatedData['format'] ?? $design->format;
        
//         // Update status if provided and it's a valid transition
//         if (isset($validatedData['status'])) {
//             $design->status = $validatedData['status'];
//         }

//         $design->save();

//         return redirect()->route('designs.show', $design)
//             ->with('success', 'Design updated successfully!');
//     }

//     /**
//      * Remove the specified design from storage.
//      */
//     public function destroy(Design $design)
//     {
//         // Check if the current user owns this design
//         if ($design->user_id !== Auth::id()) {
//             return redirect()->route('designs.index')
//                 ->with('error', 'You are not authorized to delete this design.');
//         }

//         // Delete the image file
//         if ($design->image_path && Storage::disk('public')->exists($design->image_path)) {
//             Storage::disk('public')->delete($design->image_path);
//         }

//         // Delete the design
//         $design->delete();

//         return redirect()->route('designs.index')
//             ->with('success', 'Design deleted successfully!');
//     }

//     /**
//      * Publish a design (change status to pending for review).
//      */
//     public function publish(Design $design)
//     {
//         // Check if the current user owns this design
//         if ($design->user_id !== Auth::id()) {
//             return redirect()->route('designs.index')
//                 ->with('error', 'You are not authorized to publish this design.');
//         }

//         $design->status = 'pending';
//         $design->save();

//         return redirect()->route('designs.show', $design)
//             ->with('success', 'Design submitted for review!');
//     }

//     /**
//      * Like a design.
//      */
//     public function like(Design $design)
//     {
//         $design->increment('likes');
        
//         return back()->with('success', 'Design liked!');
//     }
}