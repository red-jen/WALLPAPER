<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Design;
use Illuminate\Http\Request;

class DesignController extends Controller
{
    /**
     * Display a listing of all designs.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Design::with(['designer', 'category']);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('designer', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            // By default, only show approved or pending designs
            $query->whereIn('status', ['approved', 'pending']);
        }

        // Sort by most recent by default
        $designs = $query->latest()->paginate(15)->withQueryString();

        // Count designs by status for stats
        $allDesignsCount = Design::count();
        $approvedCount = Design::where('status', 'approved')->count();
        $pendingCount = Design::where('status', 'pending')->count();
        $rejectedCount = Design::where('status', 'rejected')->count();
        $archivedCount = Design::where('status', 'archived')->count();

        return view('admin.designs.index', compact(
            'designs', 
            'allDesignsCount', 
            'approvedCount', 
            'pendingCount', 
            'rejectedCount', 
            'archivedCount'
        ));
    }

    /**
     * Update the status of a design.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Request $request)
    {
        $request->validate([
            'design_id' => 'required|exists:designs,id',
            'status' => 'required|in:pending,approved,rejected,archived',
        ]);

        try {
            $design = Design::findOrFail($request->design_id);
            $originalStatus = $design->status;

            $design->status = $request->status;
            $design->save();



            return back()->with('success', 'Design status updated successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update design status: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified design.
     *
     * @param  \App\Models\Design  $design
     * @return \Illuminate\Http\Response
     */
    public function show(Design $design)
    {
        $design->load(['designer', 'category', 'reviews.user']);

        return view('admin.designs.show', compact('design'));
    }
}
