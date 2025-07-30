<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Package;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\FileService;

class PackageController extends Controller
{
    public function index(Request $request)
    {
        $packages = Package::all();
        return view('dashboard.packages.index', compact('packages'));
    }

    public function create(Request $request)
    {
        return view('dashboard.packages.edit')->with([
            'action' => route('dashboard.packages.store'),
            'method' => 'POST',
            'isMultiple' => false,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'breif' => 'required|string|max:500',
            'sessions_per_week' => 'required|integer|min:1|max:7',
            'type' => 'required|in:Team,Academy,Pre-Team',
            'price_egyptian' => 'required|numeric|min:0',
            'price_other' => 'required|numeric|min:0',
            'one_month_price' => 'required|numeric|min:0',
            'min_age' => 'nullable|integer|min:0|max:100',
            'max_age' => 'nullable|integer|min:0|max:100',
            'image_card' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Validate age range
        if ($request->min_age && $request->max_age && $request->min_age > $request->max_age) {
            return back()->withErrors(['age_range' => 'Minimum age cannot be greater than maximum age.'])->withInput();
        }

        $package = new Package();
        $package->name = $request->name;
        $package->breif = $request->breif;
        $package->sessions_per_week = $request->sessions_per_week;
        $package->type = $request->type;
        $package->price_egyptian = $request->price_egyptian;
        $package->price_other = $request->price_other;
        $package->one_month_price = $request->one_month_price;
        $package->min_age = $request->min_age;
        $package->max_age = $request->max_age;
        $package->image_card = $this->uploadedFiles($request, Package::$storagePath);
        $package->save();
        return redirect('dashboard/packages')
            ->with(
                'success',
                __('dashboard.package_created_successfully')
            );
    }

    public function edit(Request $request, Package $package)
    {
        return view('dashboard.packages.edit')->with([
            'package' => $package,
            'method' => 'PUT',
            'action' => route('dashboard.packages.update', ['package' => $package]),
            'isMultiple' => false,
        ]);
    }

    public function update(Request $request, Package $package)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'breif' => 'required|string|max:500',
            'sessions_per_week' => 'required|integer|min:1|max:7',
            'type' => 'required|in:Team,Academy,Pre-Team',
            'price_egyptian' => 'required|numeric|min:0',
            'price_other' => 'required|numeric|min:0',
            'one_month_price' => 'required|numeric|min:0',
            'min_age' => 'nullable|integer|min:0|max:100',
            'max_age' => 'nullable|integer|min:0|max:100',
            'image_card' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Validate age range
        if ($request->min_age && $request->max_age && $request->min_age > $request->max_age) {
            return back()->withErrors(['age_range' => 'Minimum age cannot be greater than maximum age.'])->withInput();
        }

        $package->name = $request->name;
        $package->breif = $request->breif;
        $package->sessions_per_week = $request->sessions_per_week;
        $package->type = $request->type;
        $package->price_egyptian = $request->price_egyptian;
        $package->price_other = $request->price_other;
        $package->one_month_price = $request->one_month_price;
        $package->min_age = $request->min_age;
        $package->max_age = $request->max_age;
        $package->image_card = $this->uploadedFiles($request, Package::$storagePath);
        $package->save();
        return redirect('dashboard/packages')
            ->with(
                'success',
                __('dashboard.package_updated_successfully')
            );
    }

    public function destroy(Package $package)
    {
        $package->delete();
        return redirect('dashboard/packages')
            ->with(
                'success',
                __('dashboard.package_deleted_successfully')
            );
    }

    public function uploadedFiles(Request $request, string $storagePath, int $id = null): string
    {
        $imageCard = '';
        $fileService = new FileService;

        if ($id) {
            $package = Package::find($id);
            $imageCard = $package->image_card ? $package->image_card : '';

            if ($request->hasFile('image_card')) {
                $imageCard = $fileService->verifyAndUploadFile($request->file('image_card'), $imageCard, 'public', $storagePath);
            }
        } else {
            if ($request->hasFile('image_card')) {
                $imageCard = $fileService->verifyAndUploadFile($request->file('image_card'), $imageCard, 'public', $storagePath);
            }
        }

        return $imageCard;
    }
}
