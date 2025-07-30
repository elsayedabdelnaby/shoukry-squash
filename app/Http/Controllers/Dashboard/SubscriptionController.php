<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\Player;
use App\Models\Package;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $subscriptions = Subscription::with(['player', 'package', 'branch'])
            ->when($request->status, function($query, $status) {
                return $query->where('status', $status);
            })
            ->when($request->player_id, function($query, $playerId) {
                return $query->where('player_id', $playerId);
            })
            ->when($request->package_id, function($query, $packageId) {
                return $query->where('package_id', $packageId);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $players = Player::select('id', 'name')->get();
        $packages = Package::select('id', 'name')->get();

        return view('dashboard.subscriptions.index', compact('subscriptions', 'players', 'packages'));
    }

    public function create(Request $request)
    {
        $players = Player::select('id', 'name', 'nationality')->get();
        $packages = Package::select('id', 'name', 'type', 'price_egyptian', 'price_other')->get();
        $branches = Branch::select('id', 'name')->get();
        $selectedPlayerId = $request->get('player_id');

        return view('dashboard.subscriptions.edit')->with([
            'action' => route('dashboard.subscriptions.store'),
            'method' => 'POST',
            'players' => $players,
            'packages' => $packages,
            'branches' => $branches,
            'selectedPlayerId' => $selectedPlayerId,
            'isMultiple' => false,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'player_id' => 'required|exists:players,id',
            'package_id' => 'required|exists:packages,id',
            'branch_id' => 'nullable|exists:branches,id',
            'start_date' => 'required|date|after_or_equal:today',
            'price_paid' => 'required|numeric|min:0',
            'payment_method' => 'required|in:visa,fawry,cash,transfer',
            'payment_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'notes' => 'nullable|string|max:1000',
        ]);

                    // Check if player already has an active subscription
            $existingActive = Subscription::where('player_id', $request->player_id)
                ->where('status', 'active')
                ->first();

            if ($existingActive) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['player_id' => __('dashboard.player_already_has_active_subscription')]);
            }

            // Check age eligibility
            $player = Player::find($request->player_id);
            $package = Package::find($request->package_id);
            
            if (!$package->isEligibleForPlayer($player)) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['package_id' => $package->getAgeRestrictionMessage($player)]);
            }

        // Calculate end date (1 month from start date)
        $startDate = Carbon::parse($request->start_date);
        $endDate = $startDate->copy()->addMonth()->subDay();

        $subscription = new Subscription();
        $subscription->player_id = $request->player_id;
        $subscription->package_id = $request->package_id;
        $subscription->branch_id = $request->branch_id;
        $subscription->start_date = $startDate;
        $subscription->end_date = $endDate;
        $subscription->price_paid = $request->price_paid;
        $subscription->payment_method = $request->payment_method;
        $subscription->status = 'active';
        $subscription->notes = $request->notes;

        // Handle payment document upload
        if ($request->hasFile('payment_document')) {
            $subscription->payment_document = $this->uploadPaymentDocument($request->file('payment_document'));
        }

        $subscription->save();

        return redirect()->route('dashboard.subscriptions.index')
            ->with('success', __('dashboard.subscription_created_successfully'));
    }

    public function show(Subscription $subscription)
    {
        $subscription->load(['player', 'package', 'branch']);
        return view('dashboard.subscriptions.show', compact('subscription'));
    }

    public function edit(Request $request, Subscription $subscription)
    {
        $players = Player::select('id', 'name', 'nationality')->get();
        $packages = Package::select('id', 'name', 'type', 'price_egyptian', 'price_other')->get();
        $branches = Branch::select('id', 'name')->get();

        return view('dashboard.subscriptions.edit')->with([
            'subscription' => $subscription,
            'method' => 'PUT',
            'action' => route('dashboard.subscriptions.update', ['subscription' => $subscription]),
            'players' => $players,
            'packages' => $packages,
            'branches' => $branches,
            'isMultiple' => false,
        ]);
    }

    public function update(Request $request, Subscription $subscription)
    {
        $request->validate([
            'player_id' => 'required|exists:players,id',
            'package_id' => 'required|exists:packages,id',
            'branch_id' => 'nullable|exists:branches,id',
            'start_date' => 'required|date',
            'price_paid' => 'required|numeric|min:0',
            'payment_method' => 'required|in:visa,fawry,cash,transfer',
            'payment_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'status' => 'required|in:active,expired,cancelled',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Check if player already has an active subscription (excluding current)
        if ($request->status === 'active') {
            $existingActive = Subscription::where('player_id', $request->player_id)
                ->where('status', 'active')
                ->where('id', '!=', $subscription->id)
                ->first();

            if ($existingActive) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['player_id' => __('dashboard.player_already_has_active_subscription')]);
            }
        }

        // Calculate end date (1 month from start date)
        $startDate = Carbon::parse($request->start_date);
        $endDate = $startDate->copy()->addMonth()->subDay();

        $subscription->player_id = $request->player_id;
        $subscription->package_id = $request->package_id;
        $subscription->branch_id = $request->branch_id;
        $subscription->start_date = $startDate;
        $subscription->end_date = $endDate;
        $subscription->price_paid = $request->price_paid;
        $subscription->payment_method = $request->payment_method;
        $subscription->status = $request->status;
        $subscription->notes = $request->notes;

        // Handle payment document upload
        if ($request->hasFile('payment_document')) {
            // Delete old document if exists
            if ($subscription->payment_document) {
                Storage::disk('public')->delete('subscriptions/' . $subscription->payment_document);
            }
            $subscription->payment_document = $this->uploadPaymentDocument($request->file('payment_document'));
        }

        $subscription->save();

        return redirect()->route('dashboard.subscriptions.index')
            ->with('success', __('dashboard.subscription_updated_successfully'));
    }

    public function destroy(Subscription $subscription)
    {
        // Delete payment document if exists
        if ($subscription->payment_document) {
            Storage::disk('public')->delete('subscriptions/' . $subscription->payment_document);
        }

        $subscription->delete();

        return redirect()->route('dashboard.subscriptions.index')
            ->with('success', __('dashboard.subscription_deleted_successfully'));
    }

    public function getPackagePrice(Request $request)
    {
        $request->validate([
            'player_id' => 'required|exists:players,id',
            'package_id' => 'required|exists:packages,id',
        ]);

        $player = Player::find($request->player_id);
        $package = Package::find($request->package_id);

        $price = $player->nationality === 'Egyptian' ? $package->price_egyptian : $package->price_other;

        return response()->json([
            'price' => $price,
            'nationality' => $player->nationality,
        ]);
    }

    private function uploadPaymentDocument($file)
    {
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('subscriptions', $fileName, 'public');
        return $fileName;
    }
}
