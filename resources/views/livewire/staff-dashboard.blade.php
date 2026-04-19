<div>
    <div class="mb-6">
        <h2 class="text-xl font-bold text-gray-900">Welcome, {{ auth()->user()->staff?->fname }}!</h2>
        <p class="text-sm text-gray-500">Use this page to signify your attendance at the HSST Reunion 2026.</p>
    </div>

    <livewire:upcoming-events />
</div>
