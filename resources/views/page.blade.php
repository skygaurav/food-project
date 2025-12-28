@extends('layouts.frontend')

@section('title', $page->title)

@push('styles')
<style>
    .page-container {
        max-width: 800px;
        margin: 0 auto;
    }
    
    .page-header {
        text-align: center;
        margin-bottom: 2.5rem;
        padding-bottom: 2rem;
        border-bottom: 1px solid #e2e8f0;
    }
    
    .page-title {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--text-dark);
        margin: 0 0 0.5rem 0;
    }
    
    .page-meta {
        color: var(--text-muted);
        font-size: 0.9rem;
    }
    
    .page-content {
        background: #fff;
        border-radius: 16px;
        padding: 2.5rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.08);
        line-height: 1.8;
        color: var(--text-dark);
    }
    
    .page-content h1,
    .page-content h2,
    .page-content h3,
    .page-content h4,
    .page-content h5,
    .page-content h6 {
        font-family: 'Playfair Display', Georgia, serif;
        margin-top: 1.5em;
        margin-bottom: 0.75em;
        color: var(--text-dark);
    }
    
    .page-content h2 {
        font-size: 1.75rem;
        border-bottom: 1px solid #e2e8f0;
        padding-bottom: 0.5rem;
    }
    
    .page-content h3 {
        font-size: 1.5rem;
    }
    
    .page-content p {
        margin-bottom: 1.25em;
    }
    
    .page-content ul,
    .page-content ol {
        margin-bottom: 1.25em;
        padding-left: 1.5em;
    }
    
    .page-content li {
        margin-bottom: 0.5em;
    }
    
    .page-content a {
        color: var(--primary);
        text-decoration: underline;
    }
    
    .page-content a:hover {
        color: var(--primary-dark);
    }
    
    .page-content blockquote {
        border-left: 4px solid var(--primary);
        margin: 1.5em 0;
        padding: 1em 1.5em;
        background: #fff7ed;
        border-radius: 0 8px 8px 0;
        font-style: italic;
    }
    
    .page-content img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 1.5em 0;
    }
    
    .page-content table {
        width: 100%;
        border-collapse: collapse;
        margin: 1.5em 0;
    }
    
    .page-content th,
    .page-content td {
        padding: 0.75rem 1rem;
        border: 1px solid #e2e8f0;
        text-align: left;
    }
    
    .page-content th {
        background: #f8fafc;
        font-weight: 600;
    }
    
    .page-content code {
        background: #f1f5f9;
        padding: 2px 6px;
        border-radius: 4px;
        font-size: 0.9em;
    }
    
    .page-content pre {
        background: #1e293b;
        color: #e2e8f0;
        padding: 1.5em;
        border-radius: 8px;
        overflow-x: auto;
        margin: 1.5em 0;
    }
    
    .page-content pre code {
        background: none;
        padding: 0;
    }
    
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--text-muted);
        text-decoration: none;
        margin-bottom: 2rem;
        font-size: 0.9rem;
        transition: color 0.2s;
    }
    
    .back-link:hover {
        color: var(--primary);
    }
</style>
@endpush

@section('content')
    <div class="page-container">
        <a href="/" class="back-link">← Back to Home</a>
        
        <div class="page-header">
            <h1 class="page-title">{{ $page->title }}</h1>
            <p class="page-meta">Last updated {{ $page->updated_at->format('F j, Y') }}</p>
        </div>
        
        <div class="page-content">
            {!! $page->content !!}
        </div>
    </div>
@endsection
