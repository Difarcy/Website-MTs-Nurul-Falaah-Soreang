@props(['items'])

<nav class="mb-6" aria-label="Breadcrumb">
    <ol class="flex items-center space-x-2 text-sm text-gray-600 flex-wrap">
        @foreach($items as $index => $item)
            @if($index > 0)
                <li>
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </li>
            @endif
            <li>
                @if(isset($item['url']) && !$loop->last)
                    <a href="{{ $item['url'] }}" class="hover:text-green-700 transition-colors">
                        {{ $item['label'] }}
                    </a>
                @else
                    <span class="text-gray-900 font-medium" title="{{ $item['label'] }}">
                        {{ str()->limit($item['label'], 60) }}
                    </span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>

