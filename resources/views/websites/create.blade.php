@extends('layouts.app')

@section('content')
<h2 class="mb-3">Add New Website</h2>

<form method="POST" action="{{ route('websites.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label for="domain" class="form-label">Domain</label>
        <input type="url" name="domain" id="domain" class="form-control" placeholder="https://example.com" required>
    </div>

    <div class="mb-3">
        <label for="service_account_file" class="form-label">Google JSON Key</label>
        <input type="file" name="service_account_file" id="service_account_file" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-success">Save Website</button>
</form>
@endsection
