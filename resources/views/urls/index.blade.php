@extends('layouts.app')

@section('content')
<a href="{{ route('urls.csv.form', $website->id) }}" class="btn btn-secondary mb-3">Upload CSV</a>

<h2 class="mb-3">Submit URLs for {{ $website->domain }}</h2>

<form method="POST" action="{{ route('urls.store', $website->id) }}">
    @csrf
    <div class="mb-3">
        <label>Enter Page URLs (one per line):</label>
        <textarea name="paths" class="form-control" rows="6" required></textarea>
    </div>
    <button type="submit" class="btn btn-success">Submit to Google</button>
</form>

@if($urls->count())
<hr>
<h4 class="mt-4">Submitted URLs:</h4>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Path</th>
            <th>Status</th>
            <th>Indexed At</th>
        </tr>
    </thead>
    <tbody>
        @foreach($urls as $url)
        <tr>
            <td>{{ $url->path }}</td>
            <td>
                <span class="badge bg-{{ $url->status == 'success' ? 'success' : 'danger' }}">{{ $url->status }}</span>
            </td>
            <td>{{ $url->indexed_at }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif
@endsection
