@props(['type' => 'success', 'message'])

<div class="mb-4 px-4 py-3 rounded-md text-sm font-medium
    {{ $type == 'success' ? 'bg-green-100 text-green-700 border border-green-300' : 'bg-red-100 text-red-700 border border-red-300' }}">
    {{ $message }}
</div>
