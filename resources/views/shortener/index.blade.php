<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Encurtador OTel (dev)</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <div class="container">
    <h1>Encurtador de URL</h1>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('shorten') }}" method="POST" class="mb-3">
      @csrf
      <div class="input-group">
        <input type="text" name="url" class="form-control" placeholder="https://exemplo.com" required>
        <button class="btn btn-primary">Encurtar</button>
      </div>
      @error('url') <div class="text-danger mt-1">{{ $message }}</div> @enderror
    </form>

    <h4>Últimos URLs</h4>
    <table class="table">
      <thead><tr><th>Short</th><th>Target</th><th>Clicks</th></tr></thead>
      <tbody>
      @foreach($urls as $u)
        <tr>
          <td><a href="{{ url($u->code) }}">{{ url($u->code) }}</a></td>
          <td><a href="{{ $u->target_url }}" target="_blank">{{ Str::limit($u->target_url, 60) }}</a></td>
          <td>{{ $u->clicks }}</td>
        </tr>
      @endforeach
      </tbody>
    </table>
  </div>
</body>
</html>
