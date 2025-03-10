<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

class CompanyController extends Controller
{

    public function index()
    {
        $companies = Company::select(['id', 'name', 'slug', 'is_active'])->paginate(10);
//        dd($companies);
        return Inertia::render('Admin/Company/Index', ['companies' => $companies]);
    }

    public function create()
    {
        $attributes = Attribute::all();
//        dd($attributes);
        return Inertia::render('Admin/Company/Create', ['attributes' => $attributes]);
    }

    public function store(Request $request)
    {

//        dd($request);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
//            'website' => 'nullable|url',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',

            'subCompanies' => 'nullable|array',
            'subCompanies.*.name' => 'required|string|max:255',
            'subCompanies.*.description' => 'nullable|string',
            'subCompanies.*.website' => 'nullable|url',
            'subCompanies.*.email' => 'required|email',
            'subCompanies.*.phone' => 'nullable|string|max:20',
            'subCompanies.*.address' => 'nullable|string',
            'subCompanies.*.logo' => 'nullable|image|max:2048',

            'subCompanies.*.branches' => 'nullable|array',
            'subCompanies.*.branches.*.name' => 'required|string|max:255',
            'subCompanies.*.branches.*.description' => 'nullable|string',
            'subCompanies.*.branches.*.manager_name' => 'nullable|string|max:255',
            'subCompanies.*.branches.*.email' => 'required|email',
            'subCompanies.*.branches.*.phone' => 'nullable|string|max:20',
            'subCompanies.*.branches.*.address' => 'required|string',
            'subCompanies.*.branches.*.latitude' => 'nullable|numeric',
            'subCompanies.*.branches.*.longitude' => 'nullable|numeric',
        ]);

        try {
            DB::beginTransaction();
            $company = Company::create([
                'name' => $request->name,
                'slug' => Company::generateUniqueSlug($request->name),
                'description' => $request->description,
//                'content' => $request->content,
                'website' => $request->website,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'is_active' => true,
            ]);
//            dd("i am called");
            if ($request->input('attributes')) {
                foreach ($request->input('attributes', []) as $attribute) {
                    $company->attributes()->attach(
                        $attribute['attribute_id'],
                        ['value' => $attribute['value']]
                    );
                }
            }

            // Handle company logo
            if ($request->hasFile('logo')) {
//                dd($request->file('logo'));
                $path = $request->file('logo')->store('companies/' . $company->id . '/logo', 'public');
                $company->media()->create([
                    'file_path' => $path,
                    'file_name' => $request->file('logo')->getClientOriginalName(),
                    'file_type' => $request->file('logo')->getMimeType(),
                    'file_size' => $request->file('logo')->getSize(),
                    'title' => $company->name . ' Logo',
                    'description' => 'Company Logo',
                    'order' => 1,
                    'type' => 'logo'
                ]);
            }

            // Handle company media
            if ($request->hasFile('media')) {
                foreach ($request->file('media') as $index => $mediaFile) {
                    $path = $mediaFile->store('companies/' . $company->id . '/media', 'public');
                    $company->media()->create([
                        'file_path' => $path,
                        'file_name' => $mediaFile->getClientOriginalName(),
                        'file_type' => $mediaFile->getMimeType(),
                        'file_size' => $mediaFile->getSize(),
                        'title' => $company->name . ' Media ' . ($index + 1),
                        'description' => $request->input('mediaDescriptions.company.' . $index, ''),
                        'order' => $index + 2,
                        'type' => 'media'
                    ]);
                }
            }
            // Handle sub-companies
            foreach ($request->subCompanies ?? [] as $index => $subCompanyData) {
                $subCompany = $company->subCompanies()->create([
                    'name' => $subCompanyData['name'],
                    'slug' => Str::slug($subCompanyData['name']),
                    'description' => $subCompanyData['description'],
                    'website' => $subCompanyData['website'],
                    'email' => $subCompanyData['email'],
                    'phone' => $subCompanyData['phone'],
                    'address' => $subCompanyData['address'],
                    'is_active' => true,
                ]);

                // Handle sub-company logo
                if (isset($subCompanyData['logo']) && $subCompanyData['logo'] instanceof UploadedFile) {
                    $path = $subCompanyData['logo']->store('companies/' . $company->id . '/sub-companies/' . $subCompany->id . '/logo', 'public');
                    $subCompany->media()->create([
                        'file_path' => $path,
                        'file_name' => $subCompanyData['logo']->getClientOriginalName(),
                        'file_type' => $subCompanyData['logo']->getMimeType(),
                        'file_size' => $subCompanyData['logo']->getSize(),
                        'title' => $subCompany->name . ' Logo',
                        'description' => 'Sub Company Logo',
                        'order' => 1,
                        'type' => 'logo'
                    ]);
                }

                // Handle sub-company media
                if (isset($subCompanyData['media']) && is_array($subCompanyData['media'])) {
//                    dd("subcompany has media");
                    foreach ($subCompanyData['media'] as $mediaIndex => $mediaFile) {
//                        dd($mediaFile);
                        if ($mediaFile instanceof UploadedFile) {
                            $path = $mediaFile->store('companies/' . $company->id . '/sub-companies/' . $subCompany->id . '/media', 'public');
                            $subCompany->media()->create([
                                'file_path' => $path,
                                'file_name' => $mediaFile->getClientOriginalName(),
                                'file_type' => $mediaFile->getMimeType(),
                                'file_size' => $mediaFile->getSize(),
                                'title' => $subCompany->name . ' Media ' . ($mediaIndex + 1),
                                'description' => 'Sub Company Media',
                                'order' => $mediaIndex + 2,
                                'type' => 'media'
                            ]);
                        }
                    }
                }

                // Handle branches
                foreach ($subCompanyData['branches'] ?? [] as $branchIndex => $branchData) {
                    $branch = $subCompany->branches()->create([
                        'name' => $branchData['name'],
                        'slug' => Str::slug($branchData['name']),
                        'description' => $branchData['description'],
                        'manager_name' => $branchData['manager_name'],
                        'email' => $branchData['email'],
                        'phone' => $branchData['phone'],
                        'address' => $branchData['address'],
                        'latitude' => $branchData['latitude'],
                        'longitude' => $branchData['longitude'],
                        'is_active' => true,
                    ]);

                    // Handle branch logo
                    if (isset($branchData['logo']) && $branchData['logo'] instanceof UploadedFile) {
                        $path = $branchData['logo']->store('companies/' . $company->id . '/sub-companies/' . $subCompany->id . '/branches/' . $branch->id . '/logo', 'public');
                        $branch->media()->create([
                            'file_path' => $path,
                            'file_name' => $branchData['logo']->getClientOriginalName(),
                            'file_type' => $branchData['logo']->getMimeType(),
                            'file_size' => $branchData['logo']->getSize(),
                            'title' => $branch->name . ' Logo',
                            'description' => 'Branch Logo',
                            'order' => 1,
                            'type' => 'logo'
                        ]);
                    }

                    // Handle branch media
                    if (isset($branchData['media']) && is_array($branchData['media'])) {
                        foreach ($branchData['media'] as $mediaIndex => $mediaFile) {
                            if ($mediaFile instanceof UploadedFile) {
                                $path = $mediaFile->store('companies/' . $company->id . '/sub-companies/' . $subCompany->id . '/branches/' . $branch->id . '/media', 'public');
                                $branch->media()->create([
                                    'file_path' => $path,
                                    'file_name' => $mediaFile->getClientOriginalName(),
                                    'file_type' => $mediaFile->getMimeType(),
                                    'file_size' => $mediaFile->getSize(),
                                    'title' => $branch->name . ' Media ' . ($mediaIndex + 1),
                                    'description' => 'Branch Media',
                                    'order' => $mediaIndex + 2,
                                    'type' => 'media'
                                ]);
                            }
                        }
                    }
                }
            }

            DB::commit();
            return redirect()->route('admin.companies.index');
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollBack();
            // Clean up any uploaded files in case of failure
            Storage::disk('public')->deleteDirectory('companies/' . ($company->id ?? ''));
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function edit(Company $company)
    {
        $company->load([
            'media',
            'subCompanies.media',
            'subCompanies.branches.media',
        ]);
//        dd($company->media->where('type', 'logo')->map->getFullUrl());
        return Inertia::render('Admin/Company/Edit', [
            'company' => $company,
            'mediaUrls' => [
                'company' => [
                    'logo' => $company->media->where('type', 'logo')->first()?->getFullUrl(),
                    'media' => $company->media->where('type', 'media')->map->getFullUrl(),
                ],
                'subCompanies' => $company->subCompanies->mapWithKeys(function ($subCompany) {
                    return [$subCompany->id => [
                        'logo' => $subCompany->media->where('type', 'logo')->first()?->getFullUrl(),
                        'media' => $subCompany->media->where('type', 'media')->map->getFullUrl(),
                        'branches' => $subCompany->branches->mapWithKeys(function ($branch) {
                            return [$branch->id => [
                                'logo' => $branch->media->where('type', 'logo')->first()?->getFullUrl(),
                                'media' => $branch->media->where('type', 'media')->map->getFullUrl(),
                            ]];
                        }),
                    ]];
                }),
            ],
        ]);
    }

    public function update(Request $request, Company $company)
    {
        try {
            DB::beginTransaction();

            // Update company details
            $company->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'description' => $request->description,
                'website' => $request->website,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
            ]);

            // Handle company logo update
            if ($request->hasFile('logo')) {
                // Delete old logo if exists
                $oldLogo = $company->media()->where('type', 'logo')->first();
                if ($oldLogo) {
                    Storage::disk('public')->delete($oldLogo->file_path);
                    $oldLogo->delete();
                }

                // Store new logo
                $path = $request->file('logo')->store('companies/' . $company->id . '/logo', 'public');
                $company->media()->create([
                    'file_path' => $path,
                    'file_name' => $request->file('logo')->getClientOriginalName(),
                    'file_type' => $request->file('logo')->getMimeType(),
                    'file_size' => $request->file('logo')->getSize(),
                    'title' => $company->name . ' Logo',
                    'description' => 'Company Logo',
                    'order' => 1,
                    'type' => 'logo'
                ]);
            }

            // Handle company media updates
            if ($request->hasFile('media')) {
                foreach ($request->file('media') as $index => $mediaFile) {
                    $path = $mediaFile->store('companies/' . $company->id . '/media', 'public');
                    $company->media()->create([
                        'file_path' => $path,
                        'file_name' => $mediaFile->getClientOriginalName(),
                        'file_type' => $mediaFile->getMimeType(),
                        'file_size' => $mediaFile->getSize(),
                        'title' => $company->name . ' Media ' . ($index + 1),
                        'description' => 'Company Media',
                        'order' => $index + 2,
                        'type' => 'media'
                    ]);
                }
            }

            // Handle media deletions
            if ($request->has('deletedMedia')) {
                foreach ($request->deletedMedia as $mediaId) {
                    $media = $company->media()->find($mediaId);
                    if ($media) {
                        Storage::disk('public')->delete($media->file_path);
                        $media->delete();
                    }
                }
            }

            // Update sub-companies
            $existingSubCompanyIds = $company->subCompanies->pluck('id')->toArray();
            $updatedSubCompanyIds = collect($request->subCompanies ?? [])->pluck('id')->filter()->toArray();
            $deletedSubCompanyIds = array_diff($existingSubCompanyIds, $updatedSubCompanyIds);

            // Delete removed sub-companies
            foreach ($deletedSubCompanyIds as $deletedId) {
                $subCompany = $company->subCompanies()->find($deletedId);
                if ($subCompany) {
                    // Delete all associated media files
                    foreach ($subCompany->media as $media) {
                        Storage::disk('public')->delete($media->file_path);
                    }
                    $subCompany->media()->delete();
                    $subCompany->delete();
                }
            }

            // Update or create sub-companies
            foreach ($request->subCompanies ?? [] as $subCompanyData) {
                $subCompany = isset($subCompanyData['id'])
                    ? $company->subCompanies()->find($subCompanyData['id'])
                    : $company->subCompanies()->create([
                        'name' => $subCompanyData['name'],
                        'slug' => Str::slug($subCompanyData['name']),
                        'description' => $subCompanyData['description'],
                        'website' => $subCompanyData['website'],
                        'email' => $subCompanyData['email'],
                        'phone' => $subCompanyData['phone'],
                        'address' => $subCompanyData['address'],
                        'is_active' => true,
                    ]);

                if ($subCompany) {
                    $subCompany->update([
                        'name' => $subCompanyData['name'],
                        'slug' => Str::slug($subCompanyData['name']),
                        'description' => $subCompanyData['description'],
                        'website' => $subCompanyData['website'],
                        'email' => $subCompanyData['email'],
                        'phone' => $subCompanyData['phone'],
                        'address' => $subCompanyData['address'],
                    ]);

                    // Handle sub-company logo
                    if (isset($subCompanyData['logo']) && $subCompanyData['logo'] instanceof UploadedFile) {
                        // Delete old logo
                        $oldLogo = $subCompany->media()->where('type', 'logo')->first();
                        if ($oldLogo) {
                            Storage::disk('public')->delete($oldLogo->file_path);
                            $oldLogo->delete();
                        }

                        // Store new logo
                        $path = $subCompanyData['logo']->store('companies/' . $company->id . '/sub-companies/' . $subCompany->id . '/logo', 'public');
                        $subCompany->media()->create([
                            'file_path' => $path,
                            'file_name' => $subCompanyData['logo']->getClientOriginalName(),
                            'file_type' => $subCompanyData['logo']->getMimeType(),
                            'file_size' => $subCompanyData['logo']->getSize(),
                            'title' => $subCompany->name . ' Logo',
                            'description' => 'Sub Company Logo',
                            'order' => 1,
                            'type' => 'logo'
                        ]);
                    }

                    // Handle sub-company media
                    if (isset($subCompanyData['media']) && is_array($subCompanyData['media'])) {
                        foreach ($subCompanyData['media'] as $mediaIndex => $mediaFile) {
                            if ($mediaFile instanceof UploadedFile) {
                                $path = $mediaFile->store('companies/' . $company->id . '/sub-companies/' . $subCompany->id . '/media', 'public');
                                $subCompany->media()->create([
                                    'file_path' => $path,
                                    'file_name' => $mediaFile->getClientOriginalName(),
                                    'file_type' => $mediaFile->getMimeType(),
                                    'file_size' => $mediaFile->getSize(),
                                    'title' => $subCompany->name . ' Media ' . ($mediaIndex + 1),
                                    'description' => 'Sub Company Media',
                                    'order' => $mediaIndex + 2,
                                    'type' => 'media'
                                ]);
                            }
                        }
                    }

                    // Handle deleted media
                    if (isset($subCompanyData['deletedMedia'])) {
                        foreach ($subCompanyData['deletedMedia'] as $mediaId) {
                            $media = $subCompany->media()->find($mediaId);
                            if ($media) {
                                Storage::disk('public')->delete($media->file_path);
                                $media->delete();
                            }
                        }
                    }

                    // Update branches
                    $existingBranchIds = $subCompany->branches->pluck('id')->toArray();
                    $updatedBranchIds = collect($subCompanyData['branches'] ?? [])->pluck('id')->filter()->toArray();
                    $deletedBranchIds = array_diff($existingBranchIds, $updatedBranchIds);

                    // Delete removed branches
                    foreach ($deletedBranchIds as $deletedId) {
                        $branch = $subCompany->branches()->find($deletedId);
                        if ($branch) {
                            foreach ($branch->media as $media) {
                                Storage::disk('public')->delete($media->file_path);
                            }
                            $branch->media()->delete();
                            $branch->delete();
                        }
                    }

                    // Update or create branches
                    foreach ($subCompanyData['branches'] ?? [] as $branchData) {
                        $branch = isset($branchData['id'])
                            ? $subCompany->branches()->find($branchData['id'])
                            : $subCompany->branches()->create([
                                'name' => $branchData['name'],
                                'slug' => Str::slug($branchData['name']),
                                'description' => $branchData['description'],
                                'manager_name' => $branchData['manager_name'],
                                'email' => $branchData['email'],
                                'phone' => $branchData['phone'],
                                'address' => $branchData['address'],
                                'latitude' => $branchData['latitude'],
                                'longitude' => $branchData['longitude'],
                                'is_active' => true,
                            ]);

                        if ($branch) {
                            $branch->update([
                                'name' => $branchData['name'],
                                'slug' => Str::slug($branchData['name']),
                                'description' => $branchData['description'],
                                'manager_name' => $branchData['manager_name'],
                                'email' => $branchData['email'],
                                'phone' => $branchData['phone'],
                                'address' => $branchData['address'],
                                'latitude' => $branchData['latitude'],
                                'longitude' => $branchData['longitude'],
                            ]);

                            // Handle branch logo
                            if (isset($branchData['logo']) && $branchData['logo'] instanceof UploadedFile) {
                                // Delete old logo
                                $oldLogo = $branch->media()->where('type', 'logo')->first();
                                if ($oldLogo) {
                                    Storage::disk('public')->delete($oldLogo->file_path);
                                    $oldLogo->delete();
                                }

                                // Store new logo
                                $path = $branchData['logo']->store('companies/' . $company->id . '/sub-companies/' . $subCompany->id . '/branches/' . $branch->id . '/logo', 'public');
                                $branch->media()->create([
                                    'file_path' => $path,
                                    'file_name' => $branchData['logo']->getClientOriginalName(),
                                    'file_type' => $branchData['logo']->getMimeType(),
                                    'file_size' => $branchData['logo']->getSize(),
                                    'title' => $branch->name . ' Logo',
                                    'description' => 'Branch Logo',
                                    'order' => 1,
                                    'type' => 'logo'
                                ]);
                            }

                            // Handle branch media
                            if (isset($branchData['media']) && is_array($branchData['media'])) {
                                foreach ($branchData['media'] as $mediaIndex => $mediaFile) {
                                    if ($mediaFile instanceof UploadedFile) {
                                        $path = $mediaFile->store('companies/' . $company->id . '/sub-companies/' . $subCompany->id . '/branches/' . $branch->id . '/media', 'public');
                                        $branch->media()->create([
                                            'file_path' => $path,
                                            'file_name' => $mediaFile->getClientOriginalName(),
                                            'file_type' => $mediaFile->getMimeType(),
                                            'file_size' => $mediaFile->getSize(),
                                            'title' => $branch->name . ' Media ' . ($mediaIndex + 1),
                                            'description' => 'Branch Media',
                                            'order' => $mediaIndex + 2,
                                            'type' => 'media'
                                        ]);
                                    }
                                }
                            }

                            // Handle deleted media
                            if (isset($branchData['deletedMedia'])) {
                                foreach ($branchData['deletedMedia'] as $mediaId) {
                                    $media = $branch->media()->find($mediaId);
                                    if ($media) {
                                        Storage::disk('public')->delete($media->file_path);
                                        $media->delete();
                                    }
                                }
                            }
                        }
                    }
                }
            }

            DB::commit();
            return redirect()->route('companies.index');
        } catch (\Exception $e) {
            DB::rollBack();
            // Clean up any newly uploaded files
            if (isset($newUploadPaths)) {
                foreach ($newUploadPaths as $path) {
                    Storage::disk('public')->delete($path);
                }
            }
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy(Company $company)
    {
        try {
            DB::beginTransaction();

            foreach ($company->media as $media) {
                Storage::disk('public')->delete($media->file_path);
            }

            foreach ($company->subCompanies as $subCompany) {
                foreach ($subCompany->media as $media) {
                    Storage::disk('public')->delete($media->file_path);
                }

                foreach ($subCompany->branches as $branch) {
                    foreach ($branch->media as $media) {
                        Storage::disk('public')->delete($media->file_path);
                    }
                }
            }

            $company->delete();

            DB::commit();
            return redirect()->route('companies.index');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
