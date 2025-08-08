@extends('layouts.app')

@section('content')
<h2 class="mb-3">📂 Upload CSV for {{ $website->domain }}</h2>

<form method="POST" action="{{ route('urls.csv.upload', $website->id) }}" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label class="form-label">Upload CSV file (1 URL path per line):</label>
        <input type="file" name="csv_file" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success">Submit URLs from CSV</button>
</form>

<hr>

<p><strong>Example format:</strong></p>
<pre>
/about-us
/contact
/blog/seo-tips
</pre>
@endsection
