<?php

namespace App\Http\Controllers;

use App\Models\Paper;
use Illuminate\Http\Request;

class PaperController extends Controller
{
    /**
     * Display a listing of papers for clients.
     */
    public function index()
    {
        $papers = Paper::where('is_active', true)
            ->orderBy('name')
            ->paginate(12);

        return view('papers.index', compact('papers'));
    }

    /**
     * Display the specified paper.
     */
    public function show(Paper $paper)
    {
        if (!$paper->is_active) {
            return redirect()->route('papers.index')
                ->with('error', 'This paper type is not available.');
        }

        return view('papers.show', compact('paper'));
    }
}
