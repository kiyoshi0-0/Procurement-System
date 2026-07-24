@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Add New Supplier</h1>
        <div class="flex items-center space-x-2 text-sm text-gray-500 mt-1">
            <span>Dashboard</span>
            <i class="fa-solid fa-chevron-right text-xs"></i>
            <span>Supplier Management</span>
            <i class="fa-solid fa-chevron-right text-xs"></i>
            <span class="text-gray-800 font-medium">Add Supplier</span>
        </div>
    </div>

    <!-- Error Summary Alert Block -->
    @if($errors->any())
        <div class="bg-rose-50 border border-rose-200 text-rose-700 p-4 rounded-lg text-sm shadow-xs">
            <div class="flex items-center space-x-2 font-semibold mb-1">
                <i class="fa-solid fa-triangle-exclamation"></i>
                <span>Please correct the errors below:</span>
            </div>
            <ul class="list-disc pl-5 space-y-0.5 text-xs text-rose-600">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Container -->
    <form action="{{ route('suppliers.store') }}" method="POST" class="space-y-6">
        @csrf
        
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-xs">
            <h3 class="text-sm font-semibold text-gray-800 mb-5 pb-2 border-b border-gray-100">
                <i class="fa-solid fa-circle-info text-emerald-500 mr-1"></i> Supplier Profile Details
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Left Column Fields -->
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Supplier Company Name *</label>
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="e.g. Intel Corporation" class="w-full border rounded-lg p-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-emerald-500 {{ $errors->has('name') ? 'border-rose-400' : 'border-gray-300' }}" required>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Primary Category *</label>
                            <select name="category" class="w-full border border-gray-300 rounded-lg p-2.5 bg-white text-sm text-gray-700 focus:outline-none focus:ring-1 focus:ring-emerald-500" required>
                                <option value="Components" {{ old('category') == 'Components' ? 'selected' : '' }}>Components</option>
                                <option value="Graphics" {{ old('category') == 'Graphics' ? 'selected' : '' }}>Graphics</option>
                                <option value="Power Supply" {{ old('category') == 'Power Supply' ? 'selected' : '' }}>Power Supply</option>
                                <option value="Storage" {{ old('category') == 'Storage' ? 'selected' : '' }}>Storage</option>
                                <option value="Cooling" {{ old('category') == 'Cooling' ? 'selected' : '' }}>Cooling</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Sub-Categories</label>
                            <input type="text" name="sub_categories" value="{{ old('sub_categories') }}" placeholder="e.g. Processors, Chipsets" class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-emerald-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Contact Representative Name *</label>
                            <input type="text" name="contact_person" value="{{ old('contact_person') }}" placeholder="John Doe" class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-emerald-500" required>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Email Address</label>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="johndoe@supplier.com" class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-emerald-500">
                        </div>
                    </div>
                </div>

                <!-- Right Column Fields -->
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Phone Number *</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" placeholder="+63 912 345 6789" class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-emerald-500" required>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Complete Corporate Address *</label>
                        <textarea name="address" rows="2" placeholder="Building Number, Street Name, City, Country" class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-emerald-500 resize-none" required>{{ old('address') }}</textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Payment Terms</label>
                            <select name="payment_terms" class="w-full border border-gray-300 rounded-lg p-2.5 bg-white text-sm text-gray-700 focus:outline-none focus:ring-1 focus:ring-emerald-500">
                                <option value="Net 30" {{ old('payment_terms') == 'Net 30' ? 'selected' : '' }}>Net 30</option>
                                <option value="Net 60" {{ old('payment_terms') == 'Net 60' ? 'selected' : '' }}>Net 60</option>
                                <option value="COD" {{ old('payment_terms') == 'COD' ? 'selected' : '' }}>COD (Cash on Delivery)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Delivery Schedule</label>
                            <select name="delivery_schedule" class="w-full border border-gray-300 rounded-lg p-2.5 bg-white text-sm text-gray-700 focus:outline-none focus:ring-1 focus:ring-emerald-500">
                                <option value="Weekly" {{ old('delivery_schedule') == 'Weekly' ? 'selected' : '' }}>Weekly</option>
                                <option value="Bi-Weekly" {{ old('delivery_schedule') == 'Bi-Weekly' ? 'selected' : '' }}>Bi-Weekly</option>
                                <option value="Monthly" {{ old('delivery_schedule') == 'Monthly' ? 'selected' : '' }}>Monthly</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Footer Row -->
        <div class="bg-white p-4 rounded-xl border border-gray-200 flex items-center justify-end space-x-3 shadow-xs">
            <a href="{{ route('suppliers.index') }}" class="px-8 py-2.5 border border-gray-300 text-gray-600 rounded-lg font-medium text-sm text-center hover:bg-gray-50 transition">
                Cancel
            </a>
            <button type="submit" class="px-8 py-2.5 bg-[#10B981] hover:bg-emerald-600 text-white rounded-lg font-medium text-sm transition shadow-xs">
                Save Supplier
            </button>
        </div>
    </form>
</div>
@endsection