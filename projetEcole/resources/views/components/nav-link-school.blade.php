@props(['active' => false, 'icon' => '', 'href' => '#'])

@php
$classes = ($active ?? false)
    ? 'flex items-center gap-3 px-3 py-2.5 rounded-xl bg-blue-50 text-blue-700 border-l-[3px] border-blue-600 transition-all duration-200 group'
    : 'flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 transition-all duration-200 group';
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
    <span class="material-symbols-outlined text-[22px] {{ ($active ?? false) ? 'text-blue-600' : 'group-hover:text-blue-600' }}"
          style="{{ ($active ?? false) ? "font-variation-settings: 'FILL' 1;" : '' }}">
        {{ $icon }}
    </span>
    <span class="{{ ($active ?? false) ? 'font-semibold' : 'font-medium' }} text-[14px]">{{ $slot }}</span>
</a>
