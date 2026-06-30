{{--
    resources/views/components/badge-tingkat.blade.php
    Pakai: <x-badge-tingkat :tingkat="$konsultasi->tingkatStres" />
--}}
@props(['tingkat'])

@php
    $colorMap = [
        'S00' => ['bg' => 'bg-level-normal/10', 'text' => 'text-level-normal', 'ring' => 'ring-level-normal/20'],
        'S01' => ['bg' => 'bg-level-ringan/10', 'text' => 'text-level-ringan', 'ring' => 'ring-level-ringan/20'],
        'S02' => ['bg' => 'bg-level-sedang/10', 'text' => 'text-level-sedang', 'ring' => 'ring-level-sedang/20'],
        'S03' => ['bg' => 'bg-level-berat/10', 'text' => 'text-level-berat', 'ring' => 'ring-level-berat/20'],
        'S04' => ['bg' => 'bg-level-kritis/10', 'text' => 'text-level-kritis', 'ring' => 'ring-level-kritis/20'],
    ];
    $c = $colorMap[$tingkat->kode] ?? ['bg' => 'bg-ink/10', 'text' => 'text-ink', 'ring' => 'ring-ink/20'];
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center gap-1.5 rounded-full ring-1 px-3 py-1 text-xs font-medium {$c['bg']} {$c['text']} {$c['ring']}"]) }}>
    <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
    {{ $tingkat->nama }}
</span>