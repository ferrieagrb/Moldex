@extends('layout.layout')
@section('content')
<div class="ticket-form-container">
    <h2 class="form-title">Create a Ticket</h2>
    
    <form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label>Title</label>
            <input name="title" value="{{ old('title') }}" required class="form-input" />
            @error('title') <p class="form-error">{{ $message }}</p> @enderror
        </div>

        <div class="form-group">
            <label>Category</label>
            <input name="category" value="{{ old('category') }}" class="form-input" />
        </div>

        <div class="form-group">
            <label>Message</label>
            <textarea name="message" rows="6" required class="form-input">{{ old('message') }}</textarea>
            @error('message') <p class="form-error">{{ $message }}</p> @enderror
        </div>

        <div class="form-group">
            <label>Attachments (optional)</label>
            <input type="file" name="attachments[]" multiple class="form-input-file" />
            <p class="form-note">Max 10MB per file.</p>
        </div>

        <div class="form-group checkbox-group">
            <label>
                <input type="checkbox" name="high_priority" />
                <span>High Priority</span>
            </label>
        </div>

        <div class="form-actions">
            <button class="btn-submit">Submit Ticket</button>
            <a href="{{ route('tickets.index') }}" class="btn-cancel">Cancel</a>
        </div>
    </form>
</div>
@endsection