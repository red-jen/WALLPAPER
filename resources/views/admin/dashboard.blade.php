@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-serif font-bold text-navy">Dashboard Overview</h1>
    <p class="text-gray-600">Welcome back, {{ auth()->user()->name }}!</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
    <!-- Pending Artworks -->
    <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden">
        <div class="p-5 border-b border-gray-100">
            <div class="flex items-center">
                <div class="flex-shrink-0 rounded-md bg-yellow-100 p-3">
                    <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Pending Previews</dt>
                        <dd>
                            <div class="text-2xl font-bold text-gray-900">{{ $pendingPreviews }}</div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-5 py-3 hover:bg-gray-100 transition-colors duration-200">
            <div class="text-sm">
                <a href="{{ route('admin.artworks.index', ['preview' => 'pending']) }}" class="font-medium text-indigo-600 hover:text-indigo-700 flex items-center">
                    <span>View all</span>
                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Rejected Previews -->
    <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden">
        <div class="p-5 border-b border-gray-100">
            <div class="flex items-center">
                <div class="flex-shrink-0 rounded-md bg-red-100 p-3">
                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Rejected Previews</dt>
                        <dd>
                            <div class="text-2xl font-bold text-gray-900">{{ $rejectedPreviews }}</div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-5 py-3 hover:bg-gray-100 transition-colors duration-200">
            <div class="text-sm">
                <a href="{{ route('admin.artworks.index', ['preview' => 'rejected']) }}" class="font-medium text-indigo-600 hover:text-indigo-700 flex items-center">
                    <span>View all</span>
                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Production Queue -->
    <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden">
        <div class="p-5 border-b border-gray-100">
            <div class="flex items-center">
                <div class="flex-shrink-0 rounded-md bg-blue-100 p-3">
                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Production Queue</dt>
                        <dd>
                            <div class="text-2xl font-bold text-gray-900">{{ $productionQueue }}</div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-5 py-3 hover:bg-gray-100 transition-colors duration-200">
            <div class="text-sm">
                <a href="{{ route('admin.artworks.index', ['production' => 'queued']) }}" class="font-medium text-indigo-600 hover:text-indigo-700 flex items-center">
                    <span>View all</span>
                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Shipping -->
    <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden">
        <div class="p-5 border-b border-gray-100">
            <div class="flex items-center">
                <div class="flex-shrink-0 rounded-md bg-green-100 p-3">
                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Ready to Ship</dt>
                        <dd>
                            <div class="text-2xl font-bold text-gray-900">{{ $readyToShip }}</div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-5 py-3 hover:bg-gray-100 transition-colors duration-200">
            <div class="text-sm">
                <a href="{{ route('admin.artworks.index', ['production' => 'ready']) }}" class="font-medium text-indigo-600 hover:text-indigo-700 flex items-center">
                    <span>View all</span>
                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Pending Actions Section -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-10">
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white flex justify-between items-center">
                <h2 class="font-medium text-lg text-gray-800">Artworks Needing Attention</h2>
                @if(count($artworksNeedingAttention) > 0)
                    <span class="bg-indigo-100 text-indigo-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">{{ count($artworksNeedingAttention) }} Items</span>
                @endif
            </div>
            <div class="divide-y divide-gray-200">
                @forelse($artworksNeedingAttention as $artwork)
                    <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition-colors duration-150">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-12 w-12 bg-gray-100 rounded-md overflow-hidden shadow-inner">
                                @if($artwork->image_path)
                                    <img class="h-12 w-12 rounded-md object-cover" src="{{ asset('storage/' . $artwork->image_path) }}" alt="Artwork">
                                @else
                                    <div class="h-12 w-12 rounded-md bg-gray-200 flex items-center justify-center">
                                        <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $artwork->title }}</div>
                                <div class="text-sm text-gray-500 flex items-center">
                                    <svg class="mr-1 h-3 w-3 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $artwork->user->name }}
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center">
                            @if($artwork->preview_status == 'rejected')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 mr-2">
                                    <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-red-400" fill="currentColor" viewBox="0 0 8 8">
                                        <circle cx="4" cy="4" r="3" />
                                    </svg>
                                    Changes Requested
                                </span>
                            @elseif($artwork->preview_status == 'pending')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 mr-2">
                                    <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-yellow-400" fill="currentColor" viewBox="0 0 8 8">
                                        <circle cx="4" cy="4" r="3" />
                                    </svg>
                                    Preview Needed
                                </span>
                            @elseif($artwork->preview_status == 'approved' && (!isset($artwork->production_status) || $artwork->production_status == 'queued'))
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mr-2">
                                    <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-blue-400" fill="currentColor" viewBox="0 0 8 8">
                                        <circle cx="4" cy="4" r="3" />
                                    </svg>
                                    Production Ready
                                </span>
                            @endif
                            <a href="{{ route('admin.artworks.edit', $artwork) }}" class="inline-flex items-center px-3 py-1 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-150">
                                Manage
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="mt-3 text-sm font-medium text-gray-900">All caught up!</h3>
                        <p class="mt-2 text-sm text-gray-500">No artworks currently need your attention.</p>
                    </div>
                @endforelse
            </div>
            @if(count($artworksNeedingAttention) > 5)
                <div class="px-6 py-3 bg-gray-50 text-right border-t border-gray-100">
                    <a href="{{ route('admin.artworks.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800 transition-colors duration-150">
                        View all artworks
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- User Management Control Panel -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white flex justify-between items-center">
                <h2 class="font-medium text-lg text-gray-800">User Management</h2>
                <a href="{{ route('admin.users.index') }}" class="text-xs text-indigo-600 hover:text-indigo-800 transition-colors duration-150">
                    View All
                </a>
            </div>
            
            <!-- User Stats -->
            <div class="grid grid-cols-3 divide-x divide-gray-100 border-b border-gray-200">
                <div class="p-4 text-center">
                    <div class="text-2xl font-bold text-gray-800">{{ $userStats['total'] }}</div>
                    <div class="text-xs text-gray-500 mt-1">Total Users</div>
                </div>
                <div class="p-4 text-center">
                    <div class="text-2xl font-bold text-indigo-600">{{ $userStats['designers'] }}</div>
                    <div class="text-xs text-gray-500 mt-1">Designers</div>
                </div>
                <div class="p-4 text-center">
                    <div class="text-2xl font-bold text-green-600">{{ $userStats['clients'] }}</div>
                    <div class="text-xs text-gray-500 mt-1">Clients</div>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="p-4 space-y-4">
                <!-- Create User -->
                <a href="{{ route('admin.users.create') }}" 
                   class="flex items-center justify-between p-3 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition-colors duration-200">
                    <div class="flex items-center">
                        <div class="h-8 w-8 rounded-md bg-indigo-500 flex items-center justify-center text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <div class="text-sm font-medium">Create New User</div>
                            <div class="text-xs text-gray-500">Add admin, designer or client</div>
                        </div>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </a>
                
                <!-- Filter Users by Role -->
                <div class="flex gap-2">
                    <a href="{{ route('admin.users.index', ['role' => 'admin']) }}" 
                       class="flex-1 p-2 bg-gray-50 hover:bg-gray-100 rounded-lg text-center text-sm transition-colors duration-200 border border-gray-100">
                        <div class="text-gray-800">Admins</div>
                    </a>
                    <a href="{{ route('admin.users.index', ['role' => 'designer']) }}" 
                       class="flex-1 p-2 bg-gray-50 hover:bg-gray-100 rounded-lg text-center text-sm transition-colors duration-200 border border-gray-100">
                        <div class="text-gray-800">Designers</div>
                    </a>
                    <a href="{{ route('admin.users.index', ['role' => 'client']) }}" 
                       class="flex-1 p-2 bg-gray-50 hover:bg-gray-100 rounded-lg text-center text-sm transition-colors duration-200 border border-gray-100">
                        <div class="text-gray-800">Clients</div>
                    </a>
                </div>
                
                <!-- Mini User Search -->
                <div class="pt-2">
                    <form action="{{ route('admin.users.index') }}" method="GET" class="mt-1">
                        <div class="relative rounded-md shadow-sm">
                            <input type="text" name="search" 
                                   class="focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                   placeholder="Search users...">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <button type="submit" class="text-gray-400 hover:text-gray-500 transition-colors duration-150">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Recent Users -->
            <div class="px-6 py-3 bg-gray-50 border-t border-gray-200">
                <h3 class="text-sm font-medium text-gray-700">Recent Users</h3>
            </div>
            <div class="divide-y divide-gray-100 max-h-80 overflow-y-auto">
                @forelse($recentUsers as $user)
                    <a href="{{ route('admin.users.edit', $user) }}" class="block hover:bg-gray-50 transition-colors duration-150">
                        <div class="px-6 py-3 flex items-center">
                            <div class="flex-shrink-0">
                                <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-500">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            </div>
                            <div class="ml-3 flex-1">
                                <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                <div class="text-xs text-gray-500">{{ $user->email }}</div>
                            </div>
                            <div class="flex-shrink-0">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 
                                      ($user->role === 'designer' ? 'bg-indigo-100 text-indigo-800' : 'bg-green-100 text-green-800') }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="px-6 py-4 text-center text-gray-500 text-sm">
                        No users found
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions & Orders Section -->
<div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-10">
    <!-- Quick Actions Card -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
            <h2 class="font-medium text-gray-800">Quick Actions</h2>
        </div>
        <div class="p-6 space-y-3">
            <a href="{{ route('admin.artworks.index', ['preview' => 'pending']) }}" class="block w-full text-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 transition-colors duration-150">
                Process Pending Previews
            </a>
            <a href="{{ route('admin.artworks.index', ['preview' => 'rejected']) }}" class="block w-full text-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-150">
                View Rejected Previews
            </a>
            <a href="{{ route('admin.artworks.index', ['production' => 'queued']) }}" class="block w-full text-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-150">
                Manage Production Queue
            </a>
            <a href="{{ route('admin.artworks.index', ['production' => 'ready']) }}" class="block w-full text-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-150">
                Prepare for Shipping
            </a>
        </div>
    </div>

    <!-- Order Management Quick Access -->
    <div class="lg:col-span-3 bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white flex justify-between items-center">
            <h2 class="font-medium text-gray-800">Recent Orders</h2>
            <a href="{{ route('admin.orders.index') }}" class="text-xs text-indigo-600 hover:text-indigo-800 transition-colors duration-150">
                View All Orders
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($recentOrders as $order)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    #{{ $order->order_number }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $order->user->name }}</div>
                                <div class="text-xs text-gray-500">{{ $order->user->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $order->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ 
                                    $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                    ($order->status === 'processing' ? 'bg-blue-100 text-blue-800' : 
                                    ($order->status === 'shipped' ? 'bg-green-100 text-green-800' : 
                                    ($order->status === 'canceled' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')))
                                }}">
                                    {{ ucwords(str_replace('_', ' ', $order->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                {{ $order->currency }} {{ number_format($order->total, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.orders.show', $order) }}" class="text-indigo-600 hover:text-indigo-900 transition-colors duration-150">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                No recent orders found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Order Status Filters -->
        <div class="px-6 py-3 bg-gray-50 border-t border-gray-200 flex flex-wrap gap-2">
            <a href="{{ route('admin.orders.index') }}" class="px-3 py-1 text-xs font-medium rounded-md bg-indigo-100 text-indigo-700 hover:bg-indigo-200 transition-colors duration-150">
                All Orders
            </a>
            <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="px-3 py-1 text-xs font-medium rounded-md bg-yellow-100 text-yellow-700 hover:bg-yellow-200 transition-colors duration-150">
                Pending ({{ $orderCounts['pending'] ?? 0 }})
            </a>
            <a href="{{ route('admin.orders.index', ['status' => 'processing']) }}" class="px-3 py-1 text-xs font-medium rounded-md bg-blue-100 text-blue-700 hover:bg-blue-200 transition-colors duration-150">
                Processing ({{ $orderCounts['processing'] ?? 0 }})
            </a>
            <a href="{{ route('admin.orders.index', ['status' => 'shipped']) }}" class="px-3 py-1 text-xs font-medium rounded-md bg-green-100 text-green-700 hover:bg-green-200 transition-colors duration-150">
                Shipped ({{ $orderCounts['shipped'] ?? 0 }})
            </a>
            <a href="{{ route('admin.orders.index', ['status' => 'canceled']) }}" class="px-3 py-1 text-xs font-medium rounded-md bg-red-100 text-red-700 hover:bg-red-200 transition-colors duration-150">
                Canceled ({{ $orderCounts['canceled'] ?? 0 }})
            </a>
        </div>
    </div>
</div>

<!-- Revenue Chart Section -->
<div class="grid grid-cols-1 gap-6">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white flex justify-between items-center">
            <h2 class="font-medium text-gray-800">Monthly Orders Overview</h2>
            <div class="flex space-x-2">
                <button class="px-3 py-1 text-xs font-medium rounded-md bg-indigo-100 text-indigo-700 hover:bg-indigo-200 transition-colors duration-150">Weekly</button>
                <button class="px-3 py-1 text-xs font-medium rounded-md bg-white text-gray-500 hover:bg-gray-100 transition-colors duration-150">Monthly</button>
                <button class="px-3 py-1 text-xs font-medium rounded-md bg-white text-gray-500 hover:bg-gray-100 transition-colors duration-150">Yearly</button>
            </div>
        </div>
        <div class="p-6">
            <div class="h-64 flex items-center justify-center">
                <div class="text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <p class="mt-1 text-sm text-gray-500">Connect to your order data to view chart.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection