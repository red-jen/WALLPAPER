<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artwork;
use App\Models\ArtworkPreview;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        // Get counts for dashboard stats
        $pendingPreviews = Artwork::whereDoesntHave('previews')
            ->orWhereHas('previews', function ($q) {
                $q->where('status', 'pending');
            })
            ->count();

        $rejectedPreviews = Artwork::whereHas('previews', function ($q) {
            $q->where('status', 'rejected');
        })->count();

        $productionQueue = Artwork::where('production_status', 'queued')
            ->orWhere('production_status', 'in_progress')
            ->count();

        $readyToShip = Artwork::where('production_status', 'ready')->count();

        // Get artworks needing attention
        $artworksNeedingAttention = Artwork::with(['user', 'latestPreview'])
            ->where(function ($query) {
                $query->whereDoesntHave('previews')
                    ->orWhereHas('previews', function ($q) {
                        $q->where('status', 'pending')
                            ->orWhere('status', 'rejected');
                    })
                    ->orWhere(function ($q) {
                        $q->whereHas('previews', function ($sq) {
                            $sq->where('status', 'approved');
                        })
                            ->where(function ($sq) {
                                $sq->whereNull('production_status')
                                    ->orWhere('production_status', 'queued');
                            });
                    });
            })
            ->latest()
            ->take(5)
            ->get();

        // User statistics
        $userStats = [
            'total' => User::count(),
            'admins' => User::where('role', 'admin')->count(),
            'designers' => User::where('role', 'designer')->count(),
            'clients' => User::where('role', 'client')->count(),
        ];

        // Get recent users
        $recentUsers = User::latest()->take(5)->get();

        // Get recent orders and order counts for quick access
        $recentOrders = Order::with(['user'])
            ->latest()
            ->take(5)
            ->get();

        $orderCounts = [
            'pending' => Order::where('status', 'pending')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'shipped' => Order::where('status', 'shipped')->count(),
            'canceled' => Order::where('status', 'canceled')->count(),
        ];

        // Recent activity
        $recentActivities = $this->getRecentActivities();

        return view('admin.dashboard', compact(
            'pendingPreviews',
            'rejectedPreviews',
            'productionQueue',
            'readyToShip',
            'artworksNeedingAttention',
            'userStats',
            'recentUsers',
            'recentOrders',
            'orderCounts',
            'recentActivities'
        ));
    }

    /**
     * Get the recent activities for the system.
     */
    private function getRecentActivities()
    {
        // Get preview uploads, approvals and rejections
        $previewActivities = ArtworkPreview::with('artwork')
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($preview) {
                $artwork = $preview->artwork;
                $title = $artwork ? $artwork->title : 'Unknown Artwork';

                if ($preview->status === 'uploaded') {
                    return [
                        'type' => 'preview_upload',
                        'message' => "Preview uploaded for \"$title\"",
                        'time' => $preview->created_at
                    ];
                } elseif ($preview->status === 'approved') {
                    return [
                        'type' => 'preview_approved',
                        'message' => "Preview approved for \"$title\"",
                        'time' => $preview->approved_at ?? $preview->updated_at
                    ];
                } elseif ($preview->status === 'rejected') {
                    return [
                        'type' => 'preview_rejected',
                        'message' => "Changes requested for \"$title\"",
                        'time' => $preview->rejected_at ?? $preview->updated_at
                    ];
                }

                return null;
            })
            ->filter()
            ->take(10);

        // Get recent production updates
        $productionUpdates = Artwork::whereNotNull('production_status')
            ->latest('updated_at')
            ->take(5)
            ->get()
            ->map(function ($artwork) {
                $statusMap = [
                    'queued' => 'queued for production',
                    'in_progress' => 'in production',
                    'ready' => 'ready for shipping',
                    'shipped' => 'shipped',
                    'delivered' => 'delivered'
                ];

                $status = $statusMap[$artwork->production_status] ?? $artwork->production_status;

                return [
                    'type' => 'production_update',
                    'message' => "\"$artwork->title\" is now $status",
                    'time' => $artwork->updated_at
                ];
            });

        // Combine and sort activities
        $activities = $previewActivities->concat($productionUpdates)
            ->sortByDesc('time')
            ->take(10)
            ->values()
            ->all();

        return $activities;
    }

    /**
     * Get sales data for charts
     */
    public function getSalesChartData()
    {
        // This would be implemented to return sales data
        // for the dashboard charts
        return response()->json([
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            'datasets' => [
                [
                    'label' => 'Orders',
                    'data' => [12, 19, 3, 5, 2, 3],
                ]
            ]
        ]);
    }

    /**
     * Filter users for admin dashboard
     */
    public function filterUsers(Request $request)
    {
        $query = User::query();

        if ($request->has('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->latest()->paginate(10);

        return response()->json([
            'users' => $users
        ]);
    }
}
