@props(['tag' => null, 'title', 'desc' => null])

<div class="section-heading-wrap">
    @if ($tag)
        <span class="section-tag">{{ $tag }}</span>
    @endif
    <h2 class="section-title">{{ $title }}</h2>
    @if ($desc)
        <p class="section-desc">{{ $desc }}</p>
    @endif
</div>

