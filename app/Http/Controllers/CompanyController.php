<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Inertia\Inertia;

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
        $company->load([
            'media',
            'attributes'
        ]);

//        dd($company->attributes);
        $subCompanies = $company->subCompanies()->get();
        return Inertia::render('Company/Show', [
            'company' => $company,
            'subCompanies' => $subCompanies,
            'logo' => $company->media->where('type', 'logo')->first()?->getFullUrl(),
            'media' => $company->media->where('type', 'media')->map->getFullUrl(),
        ]);
    }
}
