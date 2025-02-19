<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Inertia\Inertia;

class CompanyController extends Controller
{
    public function index()
    {


        $companies = Company::with('logo')->get();

        $companies->each(function ($company) {
            $company->logo_url = $company->logo?->getFullUrl();
            unset($company->media);
        });

        $companies->makeHidden('media');
//        dd($companies);

        return Inertia::render('Company/Index', [
            'companies' => $companies
        ]);

    }

    public function show(Company $company)
    {
        $company->load([
            'media',
            'attributes'
        ]);

//        dd($company->attributes);
        $subCompanies = $company->subCompanies()->with(['media' => function ($query) {
            $query->where('type', 'logo')->select('id', 'file_path', 'mediable_id', 'mediable_type');
        }])->get();

        $subCompanies->each(function ($subCompany) {
            $subCompany->logo_url = $subCompany->media->where('type', 'logo')->first()?->getFullUrl();
            unset($subCompany->media);
        });


        return Inertia::render('Company/Show', [
            'company' => $company,
            'subCompanies' => $subCompanies,
            'logo' => $company->media->where('type', 'logo')->first()?->getFullUrl(),
            'media' => $company->media->where('type', 'media')->map->getFullUrl(),
        ]);
    }
}
