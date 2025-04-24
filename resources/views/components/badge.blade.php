@props([
    'bg' => 'green-100',
    'dot' => 'green-600',
    'text' => 'green-700',
])

<div class="bg-{{ $bg }} rounded-lg py-2 px-5 text-center flex items-center gap-2 text-{{ $text }}">
    <div class="w-3 h-3 rounded-full bg-{{ $dot }}"></div>
    <span class="font-semibold text-lg">{{ $slot }}</span>
</div>
