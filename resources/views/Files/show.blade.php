@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">File Details</h5>
            <a href="{{ route('files.download', $file->id) }}" class="btn btn-light">
                <i class="fas fa-download"></i> Download
            </a>
        </div>
        <div class="card-body">
            <h4 class="mb-3">{{ $file->name }}</h4>
            <p class="text-muted">Uploaded on: {{ $file->created_at->format('Y-m-d') }}</p>
            <p><strong>Description:</strong> {{ $file->long_description ?? 'No description available.' }}</p>
            
            <div class="text-center">
                @if(in_array($file->type, ['image', 'video', 'audio', 'pdf']))
                    @if($file->type == 'image')
                        <img src="{{ asset('storage/' . $file->path) }}" alt="{{ $file->name }}" class="img-fluid" style="max-height: 400px;">
                    @elseif($file->type == 'video')
                        <video controls class="w-100" style="max-height: 400px;">
                            <source src="{{ asset('storage/' . $file->path) }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    @elseif($file->type == 'audio')
                        <audio controls class="w-100">
                            <source src="{{ asset('storage/' . $file->path) }}" type="audio/mpeg">
                            Your browser does not support the audio element.
                        </audio>
                    @elseif($file->type == 'pdf')
                        <iframe src="{{ asset('storage/' . $file->path) }}" width="100%" height="500px"></iframe>
                    @endif
                @else
                    <p class="text-center text-muted">Preview not available for this file type.</p>
                @endif
            </div>
            
            <div class="mt-4 text-center">
                <button class="btn btn-outline-primary" onclick="copyToClipboard('{{ route('files.show', $file->id) }}')">
                    <i class="fas fa-share"></i> Copy Share Link
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            alert('Share link copied to clipboard!');
        }).catch(err => {
            console.error('Failed to copy: ', err);
        });
    }
</script>
@endsection
