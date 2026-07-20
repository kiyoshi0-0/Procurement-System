@extends('layouts.app')

@section('content')
<!-- Compact container layout -->
<div class="max-w-2xl mx-auto p-5">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
        
        <h1 class="text-xl font-bold text-gray-800 mb-6 tracking-wide">History Log</h1>

        <!-- Timeline Container: Compact spacing -->
        <div class="relative space-y-4">
            
            <!-- Vertical Line: Sentro sa bilog -->
            <div class="absolute left-2.75 top-2 bottom-2 w-0.5 bg-emerald-500 z-0"></div>
            
            @forelse($activityLogs as $log)
                <div class="relative flex items-start gap-6 z-10">
                    
                    <!-- Dot: Nakasentro sa linya -->
                    <div class="w-6 h-6 bg-emerald-500 rounded-full shrink-0 border-4 border-white shadow-sm flex items-center justify-center"></div>
                    
                    <!-- Content: Mas malaking font size (text-sm) -->
                    <div class="text-sm pt-0.5 pb-2">
                        <p class="font-bold text-gray-500">
                            {{ $log->created_at ? $log->created_at->format('M d, Y g:i A') : '' }}
                        </p>
                        <p class="font-medium text-gray-800">{{ $log->details }}</p>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-400 text-sm py-8 font-semibold">
                    No activity logs recorded yet.
                </div>
            @endforelse
        </div>
        
        <!-- Pagination Links -->
        <div class="mt-6">
            {{ $activityLogs->links() }}
        </div>
    </div>
</div>
@endsection