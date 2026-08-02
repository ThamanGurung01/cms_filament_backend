<style>
    .seo-preview-wrapper {
        font-family: Arial, sans-serif;
        margin-top: 0.5rem;
    }
    .seo-preview-stats {
        display: flex;
        align-items: center;
        gap: 1rem;
        font-size: 0.875rem;
        font-weight: 500;
        margin-bottom: 1rem;
        color: #9ca3af; /* Default gray for stats text */
    }
    .seo-preview-card {
        padding: 1rem;
        border-radius: 0.75rem;
        background-color: #202124;
        border: 1px solid #3c4043;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        max-width: 42rem;
        text-align: left;
    }
    .seo-preview-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.5rem;
    }
    .seo-preview-icon-container {
        width: 1.75rem;
        height: 1.75rem;
        border-radius: 9999px;
        background-color: #303134;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    .seo-preview-icon-container img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }
    .seo-preview-site-info {
        display: flex;
        flex-direction: column;
        line-height: 1.2;
    }
    .seo-preview-site-name {
        font-size: 0.875rem;
        color: #dadce0;
    }
    .seo-preview-site-url {
        font-size: 0.75rem;
        color: #bdc1c6;
    }
    .seo-preview-title {
        font-size: 1.25rem;
        color: #8ab4f8;
        cursor: pointer;
        margin-bottom: 0.25rem;
        margin-top: 0;
        font-weight: 400;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .seo-preview-title:hover {
        text-decoration: underline;
    }
    .seo-preview-desc {
        font-size: 0.875rem;
        color: #bdc1c6;
        line-height: 1.5;
        margin: 0;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;  
        overflow: hidden;
        word-wrap: break-word;
    }
    /* Dynamic color classes for the counters */
    .seo-text-danger { color: #f87171; }
    .seo-text-success { color: #4ade80; }
    .seo-text-warning { color: #facc15; }
</style>

<div class="seo-preview-wrapper">
    <div class="seo-preview-stats">
        <div>Title: <span class="{{ strlen($title) > 60 ? 'seo-text-danger' : 'seo-text-success' }}">{{ strlen($title) }}/60</span></div>
        <div>Description: <span class="{{ strlen($description) > 160 ? 'seo-text-danger' : 'seo-text-warning' }}">{{ strlen($description) }}/160</span></div>
    </div>
    
    <div class="seo-preview-card">
        <div class="seo-preview-header">
            <div class="seo-preview-icon-container">
                @if($favicon = \App\Models\Setting::where('key', 'site_favicon')->value('value'))
                    <img src="{{ Storage::url($favicon) }}" alt="Favicon" />
                @else
                    <svg style="width: 1rem; height: 1rem; color: #8ab4f8;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                @endif
            </div>
            <div class="seo-preview-site-info">
                <span class="seo-preview-site-name">{{ config('app.name', 'Langtang Trails') }}</span>
                <span class="seo-preview-site-url">{{ request()->getHost() }} &rsaquo; {{ ltrim($slug, '/') }}</span>
            </div>
        </div>
        
        <h3 class="seo-preview-title">
            {{ $title ?: 'Add a meta title' }}
        </h3>
        
        <p class="seo-preview-desc">
            {{ $description ?: 'Add a meta description to see how this page might appear in search results.' }}
        </p>
    </div>
</div>
