@extends('layouts.admin')

@section('title', 'User Management')

@section('content')
<!-- Breadcrumbs -->
<div class="mb-6">
    <div class="flex items-center text-sm text-charcoal/70">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-navy">Dashboard</a>
        <span class="mx-2">/</span>
        <span class="text-charcoal">Users</span>
    </div>
</div>

<!-- Header -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
    <h1 class="text-3xl font-heading font-bold text-navy mb-4 sm:mb-0">User Management</h1>
    <a href="{{ route('admin.users.create') }}" 
        class="px-4 py-2 bg-navy text-white rounded-md font-medium hover:bg-navy/90 transition-colors flex items-center gap-2">
        <i class="fas fa-plus"></i> Add New User
    </a>
</div>

@if(session('success'))
<div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded-md mb-6 flex justify-between items-center">
    <div>{{ session('success') }}</div>
    <button type="button" class="text-green-800" onclick="this.parentElement.remove()">
        <i class="fas fa-times"></i>
    </button>
</div>
@endif

@if(session('error'))
<div class="bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded-md mb-6 flex justify-between items-center">
    <div>{{ session('error') }}</div>
    <button type="button" class="text-red-800" onclick="this.parentElement.remove()">
        <i class="fas fa-times"></i>
    </button>
</div>
@endif

<!-- Filters and Search -->
<div class="mb-6 bg-white rounded-xl shadow-sm p-6">
    <form action="{{ route('admin.users.index') }}" method="GET" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <div class="relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input 
                        type="text" 
                        name="search" 
                        id="search" 
                        class="focus:ring-gold focus:border-gold block w-full pl-10 sm:text-sm border-gray-300 rounded-md" 
                        placeholder="Search by name or email"
                        value="{{ request('search') }}"
                    >
                </div>
            </div>
            
            <div>
                <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                <select 
                    id="role" 
                    name="role" 
                    class="focus:ring-gold focus:border-gold block w-full sm:text-sm border-gray-300 rounded-md"
                >
                    <option value="">All Roles</option>
                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="designer" {{ request('role') === 'designer' ? 'selected' : '' }}>Designer</option>
                    <option value="customer" {{ request('role') === 'customer' ? 'selected' : '' }}>Customer</option>
                </select>
            </div>
            
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select 
                    id="status" 
                    name="status" 
                    class="focus:ring-gold focus:border-gold block w-full sm:text-sm border-gray-300 rounded-md"
                >
                    <option value="">All Statuses</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="banned" {{ request('status') === 'banned' ? 'selected' : '' }}>Banned</option>
                </select>
            </div>
        </div>
        
        <div class="flex justify-between items-center pt-4">
            <div>
                <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">Sort By</label>
                <div class="flex items-center space-x-2">
                    <select 
                        id="sort" 
                        name="sort" 
                        class="focus:ring-gold focus:border-gold block sm:text-sm border-gray-300 rounded-md"
                    >
                        <option value="created_at" {{ request('sort') === 'created_at' ? 'selected' : '' }}>Created Date</option>
                        <option value="name" {{ request('sort') === 'name' ? 'selected' : '' }}>Name</option>
                        <option value="email" {{ request('sort') === 'email' ? 'selected' : '' }}>Email</option>
                    </select>
                    
                    <select 
                        id="direction" 
                        name="direction" 
                        class="focus:ring-gold focus:border-gold block sm:text-sm border-gray-300 rounded-md"
                    >
                        <option value="desc" {{ request('direction') === 'desc' ? 'selected' : '' }}>Descending</option>
                        <option value="asc" {{ request('direction') === 'asc' ? 'selected' : '' }}>Ascending</option>
                    </select>
                </div>
            </div>
            
            <div class="space-x-2">
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-navy hover:bg-navy/90 focus:outline-none">
                    <i class="fas fa-filter mr-2"></i>
                    Apply Filters
                </button>
                
                <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none">
                    <i class="fas fa-redo-alt mr-2"></i>
                    Reset
                </a>
            </div>
        </div>
    </form>
</div>

<!-- Users Table -->
<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <!-- Bulk Actions -->
    <form id="bulkActionForm" action="{{ route('admin.users.bulk-action') }}" method="POST">
        @csrf
        <input type="hidden" name="action" id="bulkAction">
        
        <div class="px-6 py-4 border-b border-gray-200 flex flex-wrap justify-between items-center">
            <h2 class="font-heading font-semibold text-lg text-navy">Users List</h2>
            
            <div class="flex items-center space-x-3">
                <select 
                    id="bulkActionSelect" 
                    class="focus:ring-gold focus:border-gold block sm:text-sm border-gray-300 rounded-md"
                >
                    <option value="">Bulk Actions</option>
                    <option value="activate">Activate Selected</option>
                    <option value="ban">Ban Selected</option>
                    <option value="delete">Delete Selected</option>
                </select>
                
                <button 
                    type="button" 
                    id="applyBulkAction"
                    class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none"
                    disabled
                >
                    Apply
                </button>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <div class="flex items-center">
                                <input 
                                    type="checkbox" 
                                    id="selectAll" 
                                    class="focus:ring-gold h-4 w-4 text-gold border-gray-300 rounded"
                                >
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($users as $user)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <input 
                                        type="checkbox" 
                                        name="user_ids[]" 
                                        value="{{ $user->id }}" 
                                        class="user-checkbox focus:ring-gold h-4 w-4 text-gold border-gray-300 rounded"
                                        {{ $user->id === auth()->id() ? 'disabled' : '' }}
                                    >
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 rounded-full bg-navy/10 flex items-center justify-center text-navy mr-3">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($user->role === 'admin') bg-red-100 text-red-800
                                    @elseif($user->role === 'designer') bg-purple-100 text-purple-800
                                    @else bg-blue-100 text-blue-800
                                    @endif">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {!! $user->status_badge !!}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $user->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="text-navy hover:text-navy/80">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    @if($user->id !== auth()->id())
                                        @if($user->status !== 'banned')
                                            <form action="{{ route('admin.users.ban', $user) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-red-600 hover:text-red-800" title="Ban User">
                                                    <i class="fas fa-ban"></i>
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.users.activate', $user) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-green-600 hover:text-green-800" title="Activate User">
                                                    <i class="fas fa-check-circle"></i>
                                                </button>
                                            </form>
                                        @endif
                                        
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800" title="Delete User">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                No users found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </form>
    
    <!-- Pagination -->
    @if($users->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $users->links() }}
        </div>
    @endif
</div>

<!-- Confirmation Modal -->
<div id="confirmationModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        
        <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-red-100 rounded-full sm:mx-0 sm:h-10 sm:w-10">
                        <i class="fas fa-exclamation-triangle text-red-600"></i>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg font-medium leading-6 text-gray-900" id="modalTitle">Confirm Action</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500" id="modalMessage">
                                Are you sure you want to perform this action?
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-4 py-3 bg-gray-50 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" id="confirmAction" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                    Confirm
                </button>
                <button type="button" id="cancelAction" class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAllCheckbox = document.getElementById('selectAll');
        const userCheckboxes = document.querySelectorAll('.user-checkbox');
        const bulkActionSelect = document.getElementById('bulkActionSelect');
        const applyBulkActionBtn = document.getElementById('applyBulkAction');
        const bulkActionForm = document.getElementById('bulkActionForm');
        const bulkActionInput = document.getElementById('bulkAction');
        const confirmationModal = document.getElementById('confirmationModal');
        const modalTitle = document.getElementById('modalTitle');
        const modalMessage = document.getElementById('modalMessage');
        const confirmActionBtn = document.getElementById('confirmAction');
        const cancelActionBtn = document.getElementById('cancelAction');
        
        // Select all checkbox functionality
        selectAllCheckbox.addEventListener('change', function() {
            const isChecked = this.checked;
            
            userCheckboxes.forEach(checkbox => {
                if (!checkbox.disabled) {
                    checkbox.checked = isChecked;
                }
            });
            
            updateBulkActionButton();
        });
        
        // Individual checkboxes
        userCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateBulkActionButton);
        });
        
        // Update bulk action button state
        function updateBulkActionButton() {
            const checkedCheckboxes = document.querySelectorAll('.user-checkbox:checked');
            applyBulkActionBtn.disabled = checkedCheckboxes.length === 0 || bulkActionSelect.value === '';
        }
        
        // Bulk action select change
        bulkActionSelect.addEventListener('change', updateBulkActionButton);
        
        // Apply bulk action
        applyBulkActionBtn.addEventListener('click', function() {
            const action = bulkActionSelect.value;
            const checkedCount = document.querySelectorAll('.user-checkbox:checked').length;
            
            if (action && checkedCount > 0) {
                // Set up the confirmation modal
                if (action === 'delete') {
                    modalTitle.textContent = 'Confirm Deletion';
                    modalMessage.textContent = `Are you sure you want to delete ${checkedCount} selected users? This cannot be undone.`;
                } else if (action === 'ban') {
                    modalTitle.textContent = 'Confirm Ban';
                    modalMessage.textContent = `Are you sure you want to ban ${checkedCount} selected users?`;
                } else if (action === 'activate') {
                    modalTitle.textContent = 'Confirm Activation';
                    modalMessage.textContent = `Are you sure you want to activate ${checkedCount} selected users?`;
                }
                
                // Show the modal
                confirmationModal.classList.remove('hidden');
                
                // Set up the action
                bulkActionInput.value = action;
            }
        });
        
        // Confirm the bulk action
        confirmActionBtn.addEventListener('click', function() {
            bulkActionForm.submit();
        });
        
        // Cancel the bulk action
        cancelActionBtn.addEventListener('click', function() {
            confirmationModal.classList.add('hidden');
        });
    });
</script>
@endpush
