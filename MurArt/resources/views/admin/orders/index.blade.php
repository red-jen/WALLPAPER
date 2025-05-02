@extends('layouts.admin')

@section('title', 'Orders Management')

@section('content')
<!-- Breadcrumbs -->
<div class="mb-6">
    <div class="flex items-center text-sm text-charcoal/70">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-navy">Dashboard</a>
        <span class="mx-2">/</span>
        <span class="text-charcoal">Orders</span>
    </div>
</div>

<!-- Header -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
    <h1 class="text-3xl font-heading font-bold text-navy mb-4 sm:mb-0">Orders Management</h1>
    <div class="flex items-center space-x-3">
        <div class="relative">
            <input type="text" id="orderSearch" class="pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-gold focus:border-transparent" placeholder="Search orders...">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-search text-gray-400"></i>
            </div>
        </div>
        
        <div>
            <select id="statusFilter" class="pl-3 pr-8 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-gold focus:border-transparent">
                <option value="">All Statuses</option>
                <option value="pending">Pending</option>
                <option value="processing">Processing</option>
                <option value="completed">Completed</option>
                <option value="cancelled">Cancelled</option>
            </select>
        </div>
    </div>
</div>

<!-- Orders Table -->
<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="font-heading font-semibold text-lg text-navy">Orders List</h2>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Items</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200" id="ordersTableBody">
                @forelse ($orders as $order)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="font-medium text-navy">#{{ $order->order_number }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-8 w-8 rounded-full bg-navy/10 flex items-center justify-center text-navy mr-3">
                                    <i class="fas fa-user text-xs"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $order->user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $order->user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $order->created_at->format('M d, Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $order->orderItems->count() }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-navy">
                            ${{ number_format($order->total, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($order->status === 'completed') bg-green-100 text-green-800
                                @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                @elseif($order->status === 'pending') bg-amber-100 text-amber-800
                                @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <a href="{{ route('admin.orders.show', $order) }}" class="text-navy hover:text-navy/80 font-medium">
                                View Details
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                            No orders found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    @if($orders->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $orders->links() }}
        </div>
    @endif
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('orderSearch');
        const statusFilter = document.getElementById('statusFilter');
        
        function filterOrders() {
            const searchTerm = searchInput.value.toLowerCase();
            const status = statusFilter.value.toLowerCase();
            
            fetch(`/admin/api/orders/filter?search=${searchTerm}&status=${status}`)
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.getElementById('ordersTableBody');
                    
                    if (data.length === 0) {
                        tableBody.innerHTML = `
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                    No orders found matching your criteria
                                </td>
                            </tr>
                        `;
                        return;
                    }
                    
                    tableBody.innerHTML = data.map(order => `
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-medium text-navy">#${order.order_number}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-navy/10 flex items-center justify-center text-navy mr-3">
                                        <i class="fas fa-user text-xs"></i>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">${order.user.name}</div>
                                        <div class="text-sm text-gray-500">${order.user.email}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                ${new Date(order.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                ${order.order_items_count}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-navy">
                                $${parseFloat(order.total).toFixed(2)}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    ${order.status === 'completed' ? 'bg-green-100 text-green-800' : ''}
                                    ${order.status === 'processing' ? 'bg-blue-100 text-blue-800' : ''}
                                    ${order.status === 'pending' ? 'bg-amber-100 text-amber-800' : ''}
                                    ${order.status === 'cancelled' ? 'bg-red-100 text-red-800' : ''}
                                    ${!['completed', 'processing', 'pending', 'cancelled'].includes(order.status) ? 'bg-gray-100 text-gray-800' : ''}">
                                    ${order.status.charAt(0).toUpperCase() + order.status.slice(1)}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <a href="/admin/orders/${order.id}" class="text-navy hover:text-navy/80 font-medium">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    `).join('');
                });
        }
        
        // Debounce function to limit API calls during typing
        let timeout = null;
        searchInput.addEventListener('input', function() {
            clearTimeout(timeout);
            timeout = setTimeout(filterOrders, 500);
        });
        
        // Filter when status changes
        statusFilter.addEventListener('change', filterOrders);
    });
</script>
@endpush
