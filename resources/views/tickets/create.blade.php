@extends('layout.layout')
@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white rounded shadow">
 <h2 class="text-2xl font-semibold mb-4">Create a Ticket</h2>
 <form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/
form-data">
 @csrf
 <div class="mb-4">
 <label class="block text-sm font-medium">Title</label>
 <input name="title" value="{{ old('title') }}" required class="w-full
border p-2 rounded" />
 @error('title') <p class="text-red-600 text-sm">{{ $message }}</p>
@enderror
 </div>
 <div class="mb-4">
 <label class="block text-sm font-medium">Category</label>
 <input name="category" value="{{ old('category') }}" class="w-full border
p-2 rounded" />
 </div>
 <div class="mb-4">
 <label class="block text-sm font-medium">Message</label>
 <textarea name="message" rows="6" required class="w-full border p-2
rounded">{{ old('message') }}</textarea>
 @error('message') <p class="text-red-600 text-sm">{{ $message }}</p>
@enderror
 </div>
 <div class="mb-4">
 <label class="block text-sm font-medium">Attachments (optional)</label>
 <input type="file" name="attachments[]" multiple class="w-full" />
 <p class="text-xs text-gray-600 mt-1">Max 10MB per file.</p>
 </div>
 <div class="mb-4 flex items-center gap-4">
 <label class="inline-flex items-center">
 <input type="checkbox" name="high_priority" class="mr-2" />
 <span class="text-sm">High Priority</span>
 </label>
</div>
<div class="flex items-center gap-3">
 <button class="bg-blue-600 text-white px-4 py-2 rounded">Submit Ticket</
button>
 <a href="{{ route('tickets.index') }}" class="text-sm textgray-600">Cancel</a>
 </div>
 </form>
</div>
@endsection