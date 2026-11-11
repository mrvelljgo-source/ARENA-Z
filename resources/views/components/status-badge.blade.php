@props(['status'])

@php
    $statusClass = match(strtolower($status ?? '')) {
        'registration_open', 'open' => 'badge-open',
        'upcoming' => 'badge-upcoming',
        'live', 'ongoing', 'active' => 'badge-live',
        'registration_closed', 'closed' => 'badge-closed',
        'completed', 'finished' => 'badge-completed',
        default => 'badge-upcoming',
    };

    $statusLabel = match(strtolower($status ?? '')) {
        'registration_open', 'open' => 'Pendaftaran Dibuka',
        'upcoming' => 'Segera Hadir',
        'live', 'ongoing', 'active' => 'Sedang Berlangsung',
        'registration_closed', 'closed' => 'Pendaftaran Ditutup',
        'completed', 'finished' => 'Selesai',
        default => ucfirst($status ?? 'Upcoming'),
    };
@endphp

<span class="badge {{ $statusClass }}">
    {{ $statusLabel }}
</span>

