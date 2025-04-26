@props([
    'bg' => 'green-100',
    'dot' => 'green-600',
    'text' => 'green-700',
    'class' => ''
])

<div class="{{ $bg }} {{ $class }} rounded-lg w-1/5 flex justify-center items-center gap-3 border border-green-500/[0.5] text-{{ $text }}">
    <div class="w-3 h-3 rounded-full bg-{{ $dot }}"></div>
    <span class="font-medium {{ $text }}">{{ $slot }}</span>
</div>
