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
        ]);
    }

    public function store(Request $request)
    {
        $package = new Package();
        $package->name = $request->name;
        $package->breif = $request->breif;
        $package->image_card = $this->uploadedFiles($request, Package::$storagePath);
        $package->sessions_number = $request->sessions_number;
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
        ]);
    }

    public function update(Request $request, Package $package)
    {
        $package->name = $request->name;
        $package->breif = $request->breif;
        $package->sessions_number = $request->sessions_number;
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
