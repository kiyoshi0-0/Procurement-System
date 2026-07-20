@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Breadcrumb & Page Title Rows -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-3 md:space-y-0">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Supplier</h1>
            <div class="flex items-center space-x-2 text-sm text-gray-500 mt-1">
                <span>Dashboard</span>
                <i class="fa-solid fa-chevron-right text-xs"></i>
                <span>Supplier Management</span>
                <i class="fa-solid fa-chevron-right text-xs"></i>
                <a href="{{ route('suppliers.index') }}" class="hover:underline">Supplier List</a>
                <i class="fa-solid fa-chevron-right text-xs"></i>
                <span class="text-gray-800 font-medium">Edit Supplier</span>
            </div>
        </div>
        <div>
            <a href="{{ route('suppliers.index') }}" class="inline-flex items-center space-x-2 px-4 py-2 border border-gray-300 rounded-lg bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 shadow-xs transition">
                <i class="fa-solid fa-arrow-left text-xs"></i>
                <span>Back to List</span>
            </a>
        </div>
    </div>

    <!-- Main Entry Form Panel -->
    <div class="bg-white rounded-xl shadow-xs border border-gray-200 overflow-hidden">
        <div class="p-6 border-b border-gray-100 bg-gray-50/50">
            <h3 class="text-base font-semibold text-gray-800">Supplier Information</h3>
            <p class="text-xs text-gray-400 mt-0.5">Modify the supplier profiles, category settings, and core point of contact particulars.</p>
        </div>

        <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Supplier Corporate Name -->
                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Supplier Name</label>
                    <div class="relative">
                        <input type="text" name="name" value="{{ old('name', $supplier->name) }}" class="w-full border border-gray-300 rounded-lg pl-10 pr-4 py-2.5 text-sm focus:ring-1 focus:ring-emerald-500 focus:outline-none text-gray-800 font-medium">
                        <i class="fa-solid fa-industry absolute left-3.5 top-3.5 text-gray-400 text-sm"></i>
                    </div>
                </div>

                <!-- Product Categories Provided -->
                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Sub-Categories / Products</label>
                    <div class="relative">
                        <input type="text" name="sub_categories" value="{{ old('sub_categories', $supplier->sub_categories) }}" class="w-full border border-gray-300 rounded-lg pl-10 pr-4 py-2.5 text-sm focus:ring-1 focus:ring-emerald-500 focus:outline-none text-gray-800">
                        <i class="fa-solid fa-boxes-stowed absolute left-3.5 top-3.5 text-gray-400 text-sm"></i>
                    </div>
                </div>

                <!-- Core Category Label -->
                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Main Category Group</label>
                    <select name="category" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm bg-white text-gray-700 focus:ring-1 focus:ring-emerald-500 focus:outline-none">
                        <option value="Components" {{ old('category', $supplier->category) == 'Components' ? 'selected' : '' }}>Components</option>
                        <option value="Graphics" {{ old('category', $supplier->category) == 'Graphics' ? 'selected' : '' }}>Graphics</option>
                        <option value="Power Supply" {{ old('category', $supplier->category) == 'Power Supply' ? 'selected' : '' }}>Power Supply</option>
                        <option value="Storage" {{ old('category', $supplier->category) == 'Storage' ? 'selected' : '' }}>Storage</option>
                        <option value="Cooling" {{ old('category', $supplier->category) == 'Cooling' ? 'selected' : '' }}>Cooling</option>
                    </select>
                </div>

                <!-- Status Select -->
                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Operational Status</label>
                    <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm bg-white text-gray-700 focus:ring-1 focus:ring-emerald-500 focus:outline-none">
                        <option value="Active" {{ old('status', $supplier->status) == 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="Inactive" {{ old('status', $supplier->status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <!-- Primary Rep Name -->
                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Contact Person</label>
                    <div class="relative">
                        <input type="text" name="contact_person" value="{{ old('contact_person', $supplier->contact_person) }}" class="w-full border border-gray-300 rounded-lg pl-10 pr-4 py-2.5 text-sm focus:ring-1 focus:ring-emerald-500 focus:outline-none text-gray-800">
                        <i class="fa-solid fa-user absolute left-3.5 top-3.5 text-gray-400 text-sm"></i>
                    </div>
                </div>

                <!-- Mobile String -->
                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Phone / Mobile Number</label>
                    <div class="relative">
                        <input type="text" name="phone" value="{{ old('phone', $supplier->phone) }}" class="w-full border border-gray-300 rounded-lg pl-10 pr-4 py-2.5 text-sm focus:ring-1 focus:ring-emerald-500 focus:outline-none text-gray-800">
                        <i class="fa-solid fa-phone absolute left-3.5 top-3.5 text-gray-400 text-sm"></i>
                    </div>
                </div>
            </div>

            <!-- Form Action Footer Row -->
            <div class="pt-4 border-t border-gray-100 flex items-center justify-end space-x-3">
                <a href="{{ route('suppliers.index') }}" class="px-5 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 transition">
                    Cancel
                </a>
                <button type="submit" class="px-5 py-2 bg-[#10B981] hover:bg-emerald-600 text-white font-medium rounded-lg text-sm shadow-xs transition inline-flex items-center space-x-2">
                    <i class="fa-regular fa-floppy-disk"></i>
                    <span>Save Changes</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection