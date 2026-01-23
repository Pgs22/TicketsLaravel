<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        body { font-family: Arial; background:#020617; color:#e5e7eb; padding:2rem; }
        h1 { color:#7dd3fc; }
        .box { background:#1e293b; padding:2rem; border-radius:10px; max-width:600px; }
        p { margin:.6rem 0; }
        a, button { margin-right:.5rem; padding:.5rem 1rem; border:none; border-radius:6px; }
        a { background:#38bdf8; color:#0f172a; text-decoration:none; }
        button { background:#ef4444; color:white; cursor:pointer; }
    </style>
</head>
<body>

<h1>{{ $title }}</h1>

<div class="box">
    <p><strong>Title:</strong> {{ $ticket['title'] }}</p>
    <p><strong>Description:</strong> {{ $ticket['description'] }}</p>
    <p><strong>Priority:</strong> {{ ucfirst($ticket['priority']) }}</p>
    <p><strong>Status:</strong> {{ ucfirst($ticket['status']) }}</p>
    <p><strong>Price:</strong> {{ $ticket['price'] }} €</p>
    <p><strong>Created at:</strong> {{ $ticket['created_at'] }}</p>
    <br>

    <a href="{{ url('/tickets') }}">Back</a>
    <a href="{{ url('/tickets/'.$ticket['id'].'/edit') }}">Edit</a>

    @if ($ticket['status'] === 'closed')
        <form action="{{ url('/tickets/'.$ticket['id']) }}" method="POST" style="display:inline">
            @csrf
            @method('DELETE')
            <button>Delete</button>
        </form>
    @endif
</div>

</body>
</html>
