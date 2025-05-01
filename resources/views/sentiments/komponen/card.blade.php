<div class="glass-card card-hover rounded-xl shadow-xl {{ $glowClass }}">
    <div class="{{ $headerClass }} p-6">
        <h2 class="text-xl font-bold">{{ $title }}</h2>
    </div>
    <div class="p-6">
        {{ $slot }}
    </div>
</div>
