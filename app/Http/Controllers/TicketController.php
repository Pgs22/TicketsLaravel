<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TicketController extends Controller
{
    protected $file = 'public/tickets.json';

    public static function readTickets(): array
    {
        if (!Storage::exists('public/tickets.json')) {
            Storage::put('public/tickets.json', json_encode([]));
        }
        $json = Storage::get('public/tickets.json');
        return json_decode($json, true) ?? [];
    }

    public static function saveTickets(array $tickets): bool
    {
        return Storage::put('public/tickets.json', json_encode($tickets, JSON_PRETTY_PRINT));
    }

    public function index(Request $request, $status = null)
    {
        $tickets = self::readTickets();

        if ($status) {
            $tickets = array_filter($tickets, fn($t) => $t['status'] === $status);
            $title = "Tickets with status: $status";
        } else if ($request->query('priority')) {
            $priority = $request->query('priority');
            $tickets = array_filter($tickets, fn($t) => $t['priority'] === $priority);
            $title = "Tickets with priority: $priority";
        } else {
            $title = "All Tickets";
        }

        return view('tickets.index', ['tickets' => array_values($tickets), 'title' => $title]);
    }

    public function show($id)
    {
        $tickets = self::readTickets();
        $ticket = array_filter($tickets, fn($t) => $t['id'] == $id);
        if (!$ticket) abort(404);
        $ticket = array_values($ticket)[0];
        $title = "Ticket #$id";
        return view('tickets.show', compact('ticket', 'title'));
    }

    public function store(Request $request)
    {
        $tickets = self::readTickets();

        $newTicket = [
            'id' => count($tickets) ? max(array_column($tickets, 'id')) + 1 : 1,
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'priority' => $request->input('priority'),
            'status' => 'open', // Corregido el nombre y cambio los nuevos en el json
            'price' => $this->calculatePrice($request->input('priority')),
            'created_at' => now()->format('Y-m-d H:i:s'),
        ];  

        $tickets[] = $newTicket;
        self::saveTickets($tickets);

        return redirect('/tickets');
    }

    public function edit($id)
    {
        $tickets = self::readTickets();
        $ticket = array_filter($tickets, fn($t) => $t['id'] == $id);
        if (!$ticket) abort(404);
        $ticket = array_values($ticket)[0];
        $title = "Edit Ticket #$id";
        return view('tickets.edit', compact('ticket', 'title'));
    }

    public function update(Request $request, $id)
    {
        $tickets = self::readTickets();
        $found = false;

        foreach ($tickets as &$ticket) {
            if ($ticket['id'] == $id) {
                $ticket['status'] = $request->input('status');
                $ticket['priority'] = $request->input('priority');
                $ticket['price'] = $this->calculatePrice($ticket['priority']);
                $found = true;
                break;
            }
        }

        if (!$found) abort(404);

        self::saveTickets($tickets);

        return redirect("/tickets/$id");
    }

    public function destroy($id)
    {
        $tickets = self::readTickets();
        $ticketIndex = array_search($id, array_column($tickets, 'id'));

        if ($ticketIndex === false) abort(404);
        if ($tickets[$ticketIndex]['status'] !== 'closed') {
            return view('tickets.error', ['errors' => ['Only closed tickets can be deleted']]);
        }

        array_splice($tickets, $ticketIndex, 1);
        self::saveTickets($tickets);

        return redirect('/tickets');
    }

    private function calculatePrice($priority): int
    {
        return match($priority) {
            'high' => 100,
            'medium' => 50,
            'low' => 20,
            default => 0,
        };
    }
}
