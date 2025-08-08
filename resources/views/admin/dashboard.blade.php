@extends('layouts.app')

@section('content')
<h2 class="mb-4">🧑‍💼 Admin Dashboard</h2>
@foreach($clients as $client)
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <div>
                <strong>{{ $client->name }}</strong> <small>({{ $client->email }})</small>
            </div>
            <span class="badge bg-primary">
                {{ $client->websites->count() }} Website{{ $client->websites->count() > 1 ? 's' : '' }}
            </span>
        </div>

        <div class="card-body">
            @forelse($client->websites as $wIndex => $website)
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-2">🌐 {{ $website->domain }}</h5>
                        <div>
                            <span class="badge bg-success me-1">
                                ✅ {{ $website->urls->where('status', 'success')->count() }} Success
                            </span>
                            <span class="badge bg-danger">
                                ❌ {{ $website->urls->where('status', 'failed')->count() }} Failed
                            </span>
                        </div>
                    </div>

                    @if($website->urls->count())
                        <button class="btn btn-sm btn-outline-secondary mb-2" data-bs-toggle="collapse" data-bs-target="#urls-{{ $client->id }}-{{ $wIndex }}">
                            🔽 Show/Hide URLs
                        </button>

                        <div class="collapse" id="urls-{{ $client->id }}-{{ $wIndex }}">
                            <table class="table table-bordered table-sm align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Path</th>
                                        <th>Status</th>
                                        <th>Indexed At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($website->urls as $index => $url)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $url->path }}</td>
                                            <td>
                                                <span class="badge bg-{{ $url->status == 'success' ? 'success' : 'danger' }}">
                                                    {{ ucfirst($url->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $url->indexed_at ? $url->indexed_at->format('d M Y, h:i A') : '—' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">No URLs submitted for this website.</p>
                    @endif
                </div>
                <hr>
            @empty
                <p class="text-muted">No websites found for this client.</p>
            @endforelse
        </div>
    </div>
@endforeach

@endsection
