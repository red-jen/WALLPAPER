@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="mb-6">
    <div class="flex items-center text-sm text-charcoal/70">
        <span class="text-navy font-medium">Dashboard</span>
    </div>
    <h1 class="text-3xl font-heading font-bold text-navy mt-2">Admin Dashboard</h1>
</div>

<!-- Statistics Overview -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Users Stat Card -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-50 hover:-translate-y-1 hover:shadow-md transition duration-300">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-heading font-semibold text-navy">Total Users</h3>
                <div class="w-10 h-10 rounded-full bg-navy/10 flex items-center justify-center text-navy">
                    <i class="fas fa-users"></i>
                </div>
            </div>
            <div class="flex items-end justify-between">
                <div>
                    <p class="text-4xl font-bold text-charcoal">{{ $totalUsers }}</p>
                    <p class="text-sm text-charcoal/60">
                        <span class="text-green-500"><i class="fas fa-arrow-up"></i> {{ $newUsersPercent }}%</span> 
                        from last month
                    </p>
                </div>
                <a href="{{ route('admin.users.index') }}" class="text-sm text-navy hover:underline">View All</a>
            </div>
        </div>
        <div class="bg-navy/5 px-6 py-3">
            <div class="flex justify-between items-center">
                <div class="flex gap-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">
                        {{ $customerCount }} Customers
                    </span>
                    <span class="inline-flex items-center px-2.5 py-0.5 bg-green-100 text-green-800 rounded-full text-xs font-medium">
                        {{ $designerCount }} Designers
                    </span>
                </div>
                <span class="text-xs text-charcoal/60">{{ $activeUsersPercent }}% active</span>
            </div>
        </div>
    </div>
    
    <!-- Products Stat Card -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-50 hover:-translate-y-1 hover:shadow-md transition duration-300">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-heading font-semibold text-navy">Total Products</h3>
                <div class="w-10 h-10 rounded-full bg-gold/10 flex items-center justify-center text-gold">
                    <i class="fas fa-images"></i>
                </div>
            </div>
            <div class="flex items-end justify-between">
                <div>
                    <p class="text-4xl font-bold text-charcoal">{{ $totalWallpapers }}</p>
                    <p class="text-sm text-charcoal/60">
                        <span class="text-green-500"><i class="fas fa-arrow-up"></i> {{ $newWallpapersPercent }}%</span> 
                        from last month
                    </p>
                </div>
                <a href="{{ route('admin.wallpapers.index') }}" class="text-sm text-navy hover:underline">View All</a>
            </div>
        </div>
        <div class="bg-gold/5 px-6 py-3">
            <div class="flex justify-between items-center">
                <div class="flex gap-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 bg-amber-100 text-amber-800 rounded-full text-xs font-medium">
                        {{ $lowStockCount }} Low Stock
                    </span>
                    <span class="inline-flex items-center px-2.5 py-0.5 bg-red-100 text-red-800 rounded-full text-xs font-medium">
                        {{ $outOfStockCount }} Out of Stock
                    </span>
                </div>
                <span class="text-xs text-charcoal/60">{{ $designsCount }} designs available</span>
            </div>
        </div>
    </div>
    
    <!-- Orders Stat Card -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-50 hover:-translate-y-1 hover:shadow-md transition duration-300">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-heading font-semibold text-navy">Total Orders</h3>
                <div class="w-10 h-10 rounded-full bg-sage/10 flex items-center justify-center text-sage">
                    <i class="fas fa-shopping-cart"></i>
                </div>
            </div>
            <div class="flex items-end justify-between">
                <div>
                    <p class="text-4xl font-bold text-charcoal">{{ $totalOrders }}</p>
                    <p class="text-sm text-charcoal/60">
                        <span class="text-green-500"><i class="fas fa-arrow-up"></i> {{ $newOrdersPercent }}%</span> 
                        from last month
                    </p>
                </div>
            </div>
        </div>
        <div class="bg-sage/5 px-6 py-3">
            <div class="flex justify-between items-center">
                <div class="flex gap-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 bg-amber-100 text-amber-800 rounded-full text-xs font-medium">
                        {{ $pendingOrdersCount }} Pending
                    </span>
                    <span class="inline-flex items-center px-2.5 py-0.5 bg-green-100 text-green-800 rounded-full text-xs font-medium">
                        {{ $completedOrdersCount }} Completed
                    </span>
                </div>
                <span class="text-xs text-charcoal/60">{{ $averageOrderValue }} avg value</span>
            </div>
        </div>
    </div>
    
    <!-- Revenue Stat Card -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-50 hover:-translate-y-1 hover:shadow-md transition duration-300">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-heading font-semibold text-navy">Total Revenue</h3>
                <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-700">
                    <i class="fas fa-dollar-sign"></i>
                </div>
            </div>
            <div class="flex items-end justify-between">
                <div>
                    <p class="text-4xl font-bold text-charcoal">${{ number_format($totalRevenue, 2) }}</p>
                    <p class="text-sm text-charcoal/60">
                        @if($revenueChangePercent > 0)
                            <span class="text-green-500"><i class="fas fa-arrow-up"></i> {{ $revenueChangePercent }}%</span>
                        @else
                            <span class="text-red-500"><i class="fas fa-arrow-down"></i> {{ abs($revenueChangePercent) }}%</span>
                        @endif
                        from last month
                    </p>
                </div>
            </div>
        </div>
        <div class="bg-green-50 px-6 py-3">
            <div class="flex justify-between items-center">
                <div class="flex gap-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">
                        ${{ number_format($monthlyRevenue, 2) }} Monthly
                    </span>
                    <span class="inline-flex items-center px-2.5 py-0.5 bg-purple-100 text-purple-800 rounded-full text-xs font-medium">
                        ${{ number_format($yearlyRevenue, 2) }} Yearly
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Recent Orders & Activity - Left Side (2/3 width on large screens) -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Sales Chart -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-heading font-semibold text-navy">Sales Overview</h3>
                    <div class="flex items-center space-x-2">
                        <select id="chartTimeframe" class="text-sm border border-gray-200 rounded py-1 px-2 focus:outline-none focus:ring-2 focus:ring-gold">
                            <option value="week">This Week</option>
                            <option value="month" selected>This Month</option>
                            <option value="year">This Year</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <div class="h-80">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Recent Orders -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-heading font-semibold text-navy">Recent Orders</h3>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($recentOrders as $order)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-navy">#{{ $order->order_number }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $order->user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->created_at->format('M d, Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-navy">${{ number_format($order->total_amount, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($order->status === 'completed') bg-green-100 text-green-800
                                        @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                        @elseif($order->status === 'pending') bg-amber-100 text-amber-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">No recent orders found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Recent Activity -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-heading font-semibold text-navy">Recent Activity</h3>
            </div>
            <div class="p-6">
                <div class="flow-root">
                    <ul role="list" class="-mb-8">
                        @forelse($recentActivities as $activity)
                            <li>
                                <div class="relative pb-8">
                                    @if(!$loop->last)
                                        <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                    @endif
                                    <div class="relative flex items-start space-x-3">
                                        <div class="relative">
                                            <div class="h-10 w-10 rounded-full flex items-center justify-center 
                                                @if($activity->type === 'user_created') bg-blue-100 text-blue-700
                                                @elseif($activity->type === 'order_placed') bg-green-100 text-green-700
                                                @elseif($activity->type === 'review_submitted') bg-amber-100 text-amber-700
                                                @elseif($activity->type === 'design_uploaded') bg-purple-100 text-purple-700
                                                @else bg-gray-100 text-gray-700
                                                @endif">
                                                @if($activity->type === 'user_created')
                                                    <i class="fas fa-user"></i>
                                                @elseif($activity->type === 'order_placed')
                                                    <i class="fas fa-shopping-cart"></i>
                                                @elseif($activity->type === 'review_submitted')
                                                    <i class="fas fa-star"></i>
                                                @elseif($activity->type === 'design_uploaded')
                                                    <i class="fas fa-image"></i>
                                                @else
                                                    <i class="fas fa-bell"></i>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <div class="text-sm text-charcoal font-medium">{{ $activity->description }}</div>
                                            <div class="mt-1 text-sm text-charcoal/60">
                                                {{ $activity->created_at->diffForHumans() }}
                                                @if($activity->causer)
                                                    by {{ $activity->causer->name }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li>
                                <p class="text-center text-gray-500 text-sm">No recent activity</p>
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Right Sidebar - Right Side (1/3 width on large screens) -->
    <div class="lg:col-span-1 space-y-6">
        <!-- User Management Card -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-heading font-semibold text-navy">User Management</h3>
                    <a href="#" class="text-sm px-3 py-1 bg-navy text-white rounded-md hover:bg-navy/90 transition-colors">
                        <i class="fas fa-plus mr-1 text-xs"></i> New User
                    </a>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div class="relative">
                        <input type="text" id="userSearch" class="block w-full border border-gray-300 rounded-md px-4 py-2 pr-10 focus:outline-none focus:ring-2 focus:ring-gold focus:border-transparent" placeholder="Search users...">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                    </div>
                    
                    <!-- User tab filtering buttons -->
                    <div class="flex mb-4">
                        <button id="allUsersBtn" class="flex-1 py-2 text-sm font-medium border-b-2 border-navy text-navy">All Users</button>
                        <button id="designersBtn" class="flex-1 py-2 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-navy hover:border-navy/30">Designers</button>
                        <button id="customersBtn" class="flex-1 py-2 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-navy hover:border-navy/30">Customers</button>
                    </div>
                    
                    <div class="overflow-y-auto max-h-[340px]">
                        <ul class="divide-y divide-gray-200">
                            @forelse($recentUsers as $user)
                                <li class="py-3">
                                    <div class="flex items-center hover:bg-gray-50 p-2 rounded-md -m-2">
                                        <div class="w-10 h-10 rounded-full bg-gold/10 flex items-center justify-center text-gold mr-3">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-navy truncate">{{ $user->name }}</p>
                                            <p class="text-xs text-charcoal/60 truncate">{{ $user->email }}</p>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                @if($user->role === 'admin') bg-red-100 text-red-800
                                                @elseif($user->role === 'designer') bg-purple-100 text-purple-800
                                                @else bg-blue-100 text-blue-800
                                                @endif">
                                                {{ ucfirst($user->role) }}
                                            </span>
                                            
                                            <!-- Status Indicator & Dropdown Trigger -->
                                            <div class="relative" x-data="{ open: false }">
                                                <button @click="open = !open" type="button" class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full border focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-navy
                                                    @if($user->status === 'active') bg-green-100 text-green-800 border-green-200
                                                    @elseif($user->status === 'inactive') bg-gray-100 text-gray-800 border-gray-200 
                                                    @elseif($user->status === 'suspended') bg-red-100 text-red-800 border-red-200
                                                    @else bg-yellow-100 text-yellow-800 border-yellow-200
                                                    @endif">
                                                    <span>{{ ucfirst($user->status ?? 'pending') }}</span>
                                                    <svg class="ml-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 011.414 1.414l-4 4a1 1 01-1.414 0l-4-4a1 1 010-1.414z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                                
                                                <!-- Status Change Dropdown -->
                                                <div x-show="open" @click.away="open = false" 
                                                    class="origin-top-right absolute right-0 mt-2 w-40 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10"
                                                    x-transition:enter="transition ease-out duration-100"
                                                    x-transition:enter-start="transform opacity-0 scale-95"
                                                    x-transition:enter-end="transform opacity-100 scale-100"
                                                    x-transition:leave="transition ease-in duration-75"
                                                    x-transition:leave-start="transform opacity-100 scale-100"
                                                    x-transition:leave-end="transform opacity-0 scale-95">
                                                    <div class="py-1" role="menu" aria-orientation="vertical">
                                                        <form id="status-form-{{ $user->id }}" method="POST" class="status-update-form">
                                                            @csrf
                                                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                            <button type="button" data-status="active" data-user-id="{{ $user->id }}" 
                                                                class="status-action block w-full text-left px-4 py-2 text-sm text-green-700 hover:bg-green-100 hover:text-green-900" role="menuitem">
                                                                <i class="fas fa-check-circle mr-2"></i> Activate
                                                            </button>
                                                            <button type="button" data-status="inactive" data-user-id="{{ $user->id }}" 
                                                                class="status-action block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">
                                                                <i class="fas fa-ban mr-2"></i> Deactivate
                                                            </button>
                                                            <button type="button" data-status="suspended" data-user-id="{{ $user->id }}" 
                                                                class="status-action block w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-red-100 hover:text-red-900" role="menuitem">
                                                                <i class="fas fa-exclamation-circle mr-2"></i> Suspend
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <li class="py-4 text-center text-sm text-gray-500">
                                    No users found
                                </li>
                            @endforelse
                        </ul>
                    </div>
                    <div class="mt-4 text-center">
                        {{-- <a href="{{ route('admin.users.index') }}" class="text-sm text-navy hover:underline">View All Users</a> --}}
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Top Selling Products Card -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-heading font-semibold text-navy">Top Selling Products</h3>
            </div>
            <div class="p-6">
                <ul class="divide-y divide-gray-200">
                    @forelse($topSellingProducts as $product)
                        <li class="py-3 flex items-center">
                            <div class="h-12 w-12 rounded-lg overflow-hidden mr-3 flex-shrink-0">
                                <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->title }}" class="h-full w-full object-cover">
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-navy truncate">{{ $product->title }}</p>
                                <div class="flex items-center text-xs space-x-2">
                                    <span class="text-charcoal/60">${{ number_format($product->price, 2) }}</span>
                                    <span class="text-green-600">{{ $product->sales_count }} units sold</span>
                                </div>
                            </div>
                            <div class="ml-2">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                    ${{ number_format($product->total_revenue, 2) }}
                                </span>
                            </div>
                        </li>
                    @empty
                        <li class="py-4 text-center text-sm text-gray-500">
                            No data available
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
        
        <!-- Popular Designs Card -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-heading font-semibold text-navy">Popular Designs</h3>
            </div>
            <div class="p-6">
                <ul class="divide-y divide-gray-200">
                    @forelse($popularDesigns as $design)
                        <li class="py-3 flex items-center">
                            <div class="h-12 w-12 rounded-lg overflow-hidden mr-3 flex-shrink-0">
                                <img src="{{ asset('storage/' . $design->image_path) }}" alt="{{ $design->title }}" class="h-full w-full object-cover">
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-navy truncate">{{ $design->title }}</p>
                                <div class="flex items-center text-xs">
                                    <span class="text-charcoal/60">by {{ $design->designer->name }}</span>
                                </div>
                            </div>
                            <div class="ml-2 flex items-center text-amber-500 text-sm">
                                <i class="fas fa-star mr-1"></i>
                                <span>{{ number_format($design->average_rating, 1) }}</span>
                            </div>
                        </li>
                    @empty
                        <li class="py-4 text-center text-sm text-gray-500">
                            No data available
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Sales data for chart (we'll use the data passed from the controller)
        const salesData = @json($salesChartData);
        
        // Create the sales chart
        const ctx = document.getElementById('salesChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: salesData.labels,
                datasets: [
                    {
                        label: 'Revenue',
                        data: salesData.revenue,
                        borderColor: '#2C3E50',
                        backgroundColor: 'rgba(44, 62, 80, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.3
                    },
                    {
                        label: 'Orders',
                        data: salesData.orders,
                        borderColor: '#D4AF37',
                        backgroundColor: 'rgba(212, 175, 55, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.3
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.dataset.label === 'Revenue') {
                                    return label + '$' + context.parsed.y.toFixed(2);
                                }
                                return label + context.parsed.y;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '$' + value;
                            }
                        }
                    }
                }
            }
        });
        
        // Handle timeframe changes
        document.getElementById('chartTimeframe').addEventListener('change', function() {
            const timeframe = this.value;
            fetch(`/admin/api/sales-chart-data?timeframe=${timeframe}`)
                .then(response => response.json())
                .then(data => {
                    chart.data.labels = data.labels;
                    chart.data.datasets[0].data = data.revenue;
                    chart.data.datasets[1].data = data.orders;
                    chart.update();
                });
        });
        
        // User tab filtering
        const allUsersBtn = document.getElementById('allUsersBtn');
        const designersBtn = document.getElementById('designersBtn');
        const customersBtn = document.getElementById('customersBtn');
        const userSearch = document.getElementById('userSearch');
        
        function setActiveTab(tab) {
            // Remove active styles from all tabs
            [allUsersBtn, designersBtn, customersBtn].forEach(btn => {
                btn.classList.remove('border-navy', 'text-navy');
                btn.classList.add('border-transparent', 'text-gray-500');
            });
            
            // Add active styles to the selected tab
            tab.classList.remove('border-transparent', 'text-gray-500');
            tab.classList.add('border-navy', 'text-navy');
            
            // Filter users based on selected tab
            const role = tab === allUsersBtn ? '' : (tab === designersBtn ? 'designer' : 'customer');
            filterUsers(userSearch.value, role);
        }
        
        allUsersBtn.addEventListener('click', () => setActiveTab(allUsersBtn));
        designersBtn.addEventListener('click', () => setActiveTab(designersBtn));
        customersBtn.addEventListener('click', () => setActiveTab(customersBtn));
        
        // Search functionality
        let searchTimeout;
        userSearch.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                const activeTab = document.querySelector('#allUsersBtn, #designersBtn, #customersBtn.border-navy');
                const role = activeTab === allUsersBtn ? '' : (activeTab === designersBtn ? 'designer' : 'customer');
                filterUsers(this.value, role);
            }, 300);
        });
        
        function filterUsers(search, role) {
            fetch(`/admin/api/filter-users?search=${search}&role=${role}`)
                .then(response => response.json())
                .then(data => {
                    const userList = document.querySelector('.overflow-y-auto ul');
                    if (data.length === 0) {
                        userList.innerHTML = `
                            <li class="py-4 text-center text-sm text-gray-500">
                                No users found
                            </li>
                        `;
                        return;
                    }
                    
                    userList.innerHTML = data.map(user => `
                        <li class="py-3">
                            <div class="flex items-center hover:bg-gray-50 p-2 rounded-md -m-2">
                                <div class="w-10 h-10 rounded-full bg-gold/10 flex items-center justify-center text-gold mr-3">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-navy truncate">${user.name}</p>
                                    <p class="text-xs text-charcoal/60 truncate">${user.email}</p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        ${user.role === 'admin' ? 'bg-red-100 text-red-800' : 
                                         user.role === 'designer' ? 'bg-purple-100 text-purple-800' : 
                                         'bg-blue-100 text-blue-800'}">
                                        ${user.role.charAt(0).toUpperCase() + user.role.slice(1)}
                                    </span>
                                    
                                    <!-- Status Indicator & Dropdown Trigger -->
                                    <div class="relative" x-data="{ open: false }">
                                        <button @click="open = !open" type="button" class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full border focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-navy
                                            ${user.status === 'active' ? 'bg-green-100 text-green-800 border-green-200' :
                                             user.status === 'inactive' ? 'bg-gray-100 text-gray-800 border-gray-200' : 
                                             user.status === 'suspended' ? 'bg-red-100 text-red-800 border-red-200' :
                                             'bg-yellow-100 text-yellow-800 border-yellow-200'}">
                                            <span>${(user.status || 'pending').charAt(0).toUpperCase() + (user.status || 'pending').slice(1)}</span>
                                            <svg class="ml-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 011.414 1.414l-4 4a1 1 01-1.414 0l-4-4a1 1 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                        
                                        <!-- Status Change Dropdown -->
                                        <div x-show="open" @click.away="open = false" 
                                            class="origin-top-right absolute right-0 mt-2 w-40 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10">
                                            <div class="py-1" role="menu" aria-orientation="vertical">
                                                <form id="status-form-${user.id}" method="POST" class="status-update-form">
                                                    <input type="hidden" name="user_id" value="${user.id}">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <button type="button" data-status="active" data-user-id="${user.id}" 
                                                        class="status-action block w-full text-left px-4 py-2 text-sm text-green-700 hover:bg-green-100 hover:text-green-900" role="menuitem">
                                                        <i class="fas fa-check-circle mr-2"></i> Activate
                                                    </button>
                                                    <button type="button" data-status="inactive" data-user-id="${user.id}" 
                                                        class="status-action block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">
                                                        <i class="fas fa-ban mr-2"></i> Deactivate
                                                    </button>
                                                    <button type="button" data-status="suspended" data-user-id="${user.id}" 
                                                        class="status-action block w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-red-100 hover:text-red-900" role="menuitem">
                                                        <i class="fas fa-exclamation-circle mr-2"></i> Suspend
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    `).join('');
                });
        }
        
        // User status update functionality
        document.querySelectorAll('.status-action').forEach(button => {
            button.addEventListener('click', function() {
                const userId = this.getAttribute('data-user-id');
                const newStatus = this.getAttribute('data-status');
                const form = document.getElementById(`status-form-${userId}`);
                
                // Create status field dynamically
                const statusInput = document.createElement('input');
                statusInput.type = 'hidden';
                statusInput.name = 'status';
                statusInput.value = newStatus;
                form.appendChild(statusInput);
                
                // Send AJAX request to update status
                fetch('/admin/users/update-status', {
                    method: 'POST',
                    body: new FormData(form),
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update the UI to reflect the new status
                        const statusButton = form.closest('.relative').querySelector('button[type="button"]:not(.status-action)');
                        
                        // Remove all status-related classes
                        statusButton.classList.remove(
                            'bg-green-100', 'text-green-800', 'border-green-200',
                            'bg-gray-100', 'text-gray-800', 'border-gray-200',
                            'bg-red-100', 'text-red-800', 'border-red-200',
                            'bg-yellow-100', 'text-yellow-800', 'border-yellow-200'
                        );
                        
                        // Add appropriate classes for the new status
                        if (newStatus === 'active') {
                            statusButton.classList.add('bg-green-100', 'text-green-800', 'border-green-200');
                        } else if (newStatus === 'inactive') {
                            statusButton.classList.add('bg-gray-100', 'text-gray-800', 'border-gray-200');
                        } else if (newStatus === 'suspended') {
                            statusButton.classList.add('bg-red-100', 'text-red-800', 'border-red-200');
                        } else {
                            statusButton.classList.add('bg-yellow-100', 'text-yellow-800', 'border-yellow-200');
                        }
                        
                        // Update the status text
                        statusButton.querySelector('span').textContent = newStatus.charAt(0).toUpperCase() + newStatus.slice(1);
                        
                        // Show a toast notification
                        showNotification(`User status updated to ${newStatus}`, 'success');
                    } else {
                        showNotification('Failed to update user status', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('An error occurred', 'error');
                });
                
                // Close the dropdown
                const dropdownContainer = form.closest('[x-data]');
                if (dropdownContainer.__x) {
                    dropdownContainer.__x.$data.open = false;
                }
            });
        });
        
        // Simple notification function
        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-md z-50 ${
                type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
            }`;
            notification.textContent = message;
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }
    });
</script>
@endpush