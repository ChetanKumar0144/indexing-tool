@extends('layouts.app')

@section('content')
<h2 class="mb-4">📊 Your Dashboard</h2>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-primary shadow-sm">
            <div class="card-body">
                <h5 class="card-title">🌐 Websites</h5>
                <p class="fs-3 fw-bold">{{ $totalWebsites }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-secondary shadow-sm">
            <div class="card-body">
                <h5 class="card-title">🔗 Total URLs</h5>
                <p class="fs-3 fw-bold">{{ $totalUrls }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success shadow-sm">
            <div class="card-body">
                <h5 class="card-title">✅ Indexed</h5>
                <p class="fs-3 fw-bold">{{ $totalIndexed }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-danger shadow-sm">
            <div class="card-body">
                <h5 class="card-title">❌ Failed</h5>
                <p class="fs-3 fw-bold">{{ $totalFailed }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Recent Submissions -->
<h4 class="mb-3">🕒 Recent Submissions</h4>

@if($recentUrls->isEmpty())
    <div class="alert alert-warning" role="alert">
        💤 No recent URL submissions yet. Start by submitting URLs from the <a href="{{ route('websites.index') }}">Websites</a> section.
    </div>
@else
    <table class="table table-bordered table-hover table-sm align-middle">
        <thead class="table-light">
            <tr>
                <th>Website</th>
                <th>Path</th>
                <th>Status</th>
                <th>Indexed At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recentUrls as $url)
            <tr>
                <td>{{ $url->website->domain }}</td>
                <td>{{ $url->path }}</td>
                <td>
                    <span class="badge bg-{{ $url->status === 'success' ? 'success' : 'danger' }}">
                        {{ ucfirst($url->status) }}
                    </span>
                </td>
                <td>{{ $url->indexed_at ? \Carbon\Carbon::parse($url->indexed_at)->format('d M Y, h:i A') : '—' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endif

<!-- Charts -->
<h4 class="mt-5 mb-3">📈 URL Trends</h4>
<div class="row g-4">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">Status Breakdown</div>
            <div class="card-body">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">Daily Submissions</div>
            <div class="card-body">
                <canvas id="trendChart"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Status Chart
    const ctx1 = document.getElementById('statusChart').getContext('2d');
    new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: ['Indexed', 'Failed'],
            datasets: [{
                label: 'URL Status',
                data: [{{ $totalIndexed }}, {{ $totalFailed }}],
                backgroundColor: ['#198754', '#dc3545']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            }
        }
    });

    // Trend Chart
    const ctx2 = document.getElementById('trendChart').getContext('2d');
    new Chart(ctx2, {
        type: 'line',
        data: {
            labels: {!! json_encode($urlsByDate->pluck('date')) !!},
            datasets: [{
                label: 'Submitted URLs per day',
                data: {!! json_encode($urlsByDate->pluck('count')) !!},
                borderColor: '#0d6efd',
                fill: false,
                tension: 0.2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endpush
