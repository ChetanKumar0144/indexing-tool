@extends('layouts.app')

@section('content')
<h2 class="mb-3">Your Websites</h2>
<a href="{{ route('websites.create') }}" class="btn btn-success mb-3">+ Add Website</a>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Domain</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($websites as $site)
        <tr>
            <td>{{ $site->domain }}</td>
            <td>
                <a href="{{ route('urls.index', $site->id) }}" class="btn btn-sm btn-primary">Submit URLs</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
