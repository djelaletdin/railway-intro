<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::all();
        return Inertia::render('Company/Index', [
            'companies' => $companies
        ]);

    }

    public function show(Company $company)
    {
        $subCompanies = $company->subCompanies()->get();
//        dd($subCompanies);
        return Inertia::render('Company/Show', [
            'company' => $company,
            'subCompanies' => $subCompanies
        ]);
    }

    public function create()
    {
        return Inertia::render('Company/Create');
    }

    public function store(Request $request)
    {

//        dd("i am called");
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'website' => 'nullable|url',
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
                'slug' => Str::slug($request->name),
                'description' => $request->description,
                'website' => $request->website,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'is_active' => true,
            ]);

            // Handle company logo
            if ($request->hasFile('logo')) {
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
                        'description' => 'Company Media',
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
            return redirect()->route('company.index');
        } catch (\Exception $e) {
            DB::rollBack();
            // Clean up any uploaded files in case of failure
            Storage::disk('public')->deleteDirectory('companies/' . ($company->id ?? ''));
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
