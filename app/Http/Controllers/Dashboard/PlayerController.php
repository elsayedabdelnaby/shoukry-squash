<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Player;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function index(Request $request)
    {
        $players = Player::paginate(10);
        return view('dashboard.players.index', compact('players'));
    }

    public function create(Request $request)
    {
        return view('dashboard.players.edit')->with([
            'action' => route('dashboard.players.store'),
            'method' => 'POST',
            'isMultiple' => false,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|unique:players,phone|max:20',
            'birth_date' => 'required|date|before:today',
            'nationality' => 'required|in:Egyptian,Other',
            'gender' => 'required|in:male,female',
            'parents_contact_number' => 'nullable|string|max:20',
        ]);

        $player = new Player();
        $player->name = $request->name;
        $player->phone = $request->phone;
        $player->birth_date = $request->birth_date;
        $player->nationality = $request->nationality;
        $player->gender = $request->gender;
        $player->parents_contact_number = $request->parents_contact_number;
        $player->save();

        return redirect()->route('dashboard.players.index')
            ->with('success', __('dashboard.player_created_successfully'));
    }

    public function show(Player $player)
    {
        return view('dashboard.players.show', compact('player'));
    }

    public function edit(Request $request, Player $player)
    {
        return view('dashboard.players.edit')->with([
            'player' => $player,
            'method' => 'PUT',
            'action' => route('dashboard.players.update', ['player' => $player]),
            'isMultiple' => false,
        ]);
    }

    public function update(Request $request, Player $player)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:players,phone,' . $player->id,
            'birth_date' => 'required|date|before:today',
            'nationality' => 'required|in:Egyptian,Other',
            'gender' => 'required|in:male,female',
            'parents_contact_number' => 'nullable|string|max:20',
        ]);

        $player->name = $request->name;
        $player->phone = $request->phone;
        $player->birth_date = $request->birth_date;
        $player->nationality = $request->nationality;
        $player->gender = $request->gender;
        $player->parents_contact_number = $request->parents_contact_number;
        $player->save();

        return redirect()->route('dashboard.players.index')
            ->with('success', __('dashboard.player_updated_successfully'));
    }

    public function destroy(Player $player)
    {
        $player->delete();
        return redirect()->route('dashboard.players.index')
            ->with('success', __('dashboard.player_deleted_successfully'));
    }
}
