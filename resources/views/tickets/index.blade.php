<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        body { font-family: Arial; background:#0f172a; color:#e5e7eb; padding:2rem; }
        h1 { color:#38bdf8; }
        table { width:100%; border-collapse: collapse; margin-top:1rem; }
        th, td { padding:.8rem; border-bottom:1px solid #334155; text-align:left; }
        th { background:#1e293b; }
        a { color:#38bdf8; text-decoration:none; }
        .btn { padding:.4rem .8rem; border-radius:6px; background:#38bdf8; color:#0f172a; }
        .actions a { margin-right:.5rem; }
    </style>
</head>
<body>

<h1>{{ $title }}</h1>

<p>
    <a class="btn" href="{{ url('/') }}">Home</a>
    <a class="btn" href="{{ url('/tickets/create') }}">New Ticket</a>
</p>

<table>
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Priority</th>
        <th>Status</th>
        <th>Price</th>
        <th>Actions</th>
    </tr>

    @forelse ($tickets as $ticket)
        <tr>
            <td>{{ $ticket['id'] }}</td>
            <td>{{ $ticket['title'] }}</td>
            <td>{{ ucfirst($ticket['priority']) }}</td>
            <td>{{ ucfirst($ticket['status']) }}</td>
            <td>{{ $ticket['price'] }} €</td>
            <td class="actions">
                <a href="{{ url('/tickets/'.$ticket['id']) }}">View</a>
                <a href="{{ url('/tickets/'.$ticket['id'].'/edit') }}">Edit</a>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="6">No tickets found</td>
        </tr>
    @endforelse
</table>

</body>
</html>
