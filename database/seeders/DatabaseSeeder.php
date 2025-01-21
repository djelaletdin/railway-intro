<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\SubCompany;
use App\Models\Branch;
use App\Models\Attribute;
use App\Models\Media;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Companies Data
        $companies = [
            [
                'name' => 'Global Tech Industries',
                'description' => 'A leading technology conglomerate specializing in innovation and digital transformation.',
                'website' => 'https://gti.example.com',
                'email' => 'info@gti.example.com',
                'phone' => '+1-555-0123',
                'address' => '123 Innovation Drive, Silicon Valley, CA 94025',
                'sub_companies' => [
                    [
                        'name' => 'GTI Software Solutions',
                        'description' => 'Enterprise software development and cloud services.',
                        'website' => 'https://software.gti.example.com',
                        'email' => 'info@software.gti.example.com',
                        'phone' => '+1-555-0125',
                        'address' => '789 Code Lane, Silicon Valley, CA 94025',
                        'branches' => [
                            [
                                'name' => 'Silicon Valley HQ',
                                'description' => 'Main development center and headquarters',
                                'manager_name' => 'John Smith',
                                'email' => 'sv@software.gti.example.com',
                                'phone' => '+1-555-0129',
                                'address' => '789 Code Lane, Silicon Valley, CA 94025',
                                'latitude' => 37.4419,
                                'longitude' => -122.1419,
                            ],
                            [
                                'name' => 'Seattle Development Center',
                                'description' => 'Cloud services and AI development',
                                'manager_name' => 'Emma Wilson',
                                'email' => 'seattle@software.gti.example.com',
                                'phone' => '+1-555-0130',
                                'address' => '404 Cloud Street, Seattle, WA 98101',
                                'latitude' => 47.6062,
                                'longitude' => -122.3321,
                            ],
                        ],
                    ],
                    [
                        'name' => 'GTI Hardware Systems',
                        'description' => 'Innovative hardware and IoT device manufacturing.',
                        'website' => 'https://hardware.gti.example.com',
                        'email' => 'info@hardware.gti.example.com',
                        'phone' => '+1-555-0126',
                        'address' => '101 Circuit Road, Austin, TX 78701',
                    ],
                ],
            ],
            [
                'name' => 'Eco Solutions Group',
                'description' => 'Sustainable energy and environmental solutions provider with global reach.',
                'website' => 'https://ecosolutions.example.com',
                'email' => 'contact@ecosolutions.example.com',
                'phone' => '+1-555-0124',
                'address' => '456 Green Avenue, Portland, OR 97201',
                'sub_companies' => [
                    [
                        'name' => 'Solar Power Systems',
                        'description' => 'Residential and commercial solar power solutions.',
                        'website' => 'https://solar.ecosolutions.example.com',
                        'email' => 'solar@ecosolutions.example.com',
                        'phone' => '+1-555-0127',
                        'address' => '202 Sun Street, Phoenix, AZ 85001',
                        'branches' => [
                            [
                                'name' => 'Phoenix Installation Center',
                                'description' => 'Main solar installation and service hub',
                                'manager_name' => 'Maria Rodriguez',
                                'email' => 'phoenix@solar.ecosolutions.example.com',
                                'phone' => '+1-555-0131',
                                'address' => '505 Sun Avenue, Phoenix, AZ 85001',
                                'latitude' => 33.4484,
                                'longitude' => -112.0740,
                            ],
                            [
                                'name' => 'Las Vegas Operations',
                                'description' => 'Desert solar farm operations',
                                'manager_name' => 'David Chen',
                                'email' => 'vegas@solar.ecosolutions.example.com',
                                'phone' => '+1-555-0132',
                                'address' => '606 Desert Road, Las Vegas, NV 89101',
                                'latitude' => 36.1699,
                                'longitude' => -115.1398,
                            ],
                        ],
                    ],
                    [
                        'name' => 'Wind Energy Division',
                        'description' => 'Wind farm development and maintenance.',
                        'website' => 'https://wind.ecosolutions.example.com',
                        'email' => 'wind@ecosolutions.example.com',
                        'phone' => '+1-555-0128',
                        'address' => '303 Breeze Road, Chicago, IL 60601',
                    ],
                ],
            ],
        ];

        // Create Companies with SubCompanies and Branches
        foreach ($companies as $companyData) {
            $subCompanies = $companyData['sub_companies'];
            unset($companyData['sub_companies']);

            $company = Company::create(array_merge($companyData, [
                'slug' => Str::slug($companyData['name']),
                'is_active' => true,
            ]));

            foreach ($subCompanies as $subCompanyData) {
                $branches = $subCompanyData['branches'] ?? [];
                unset($subCompanyData['branches']);

                $subCompany = $company->subCompanies()->create(array_merge($subCompanyData, [
                    'slug' => Str::slug($subCompanyData['name']),
                    'is_active' => true,
                ]));

                foreach ($branches as $branchData) {
                    $subCompany->branches()->create(array_merge($branchData, [
                        'slug' => Str::slug($branchData['name']),
                        'is_active' => true,
                    ]));
                }
            }
        }

        // Create and Assign Attributes
        $attributes = [
            [
                'name' => 'Employee Count',
                'type' => 'number',
                'description' => 'Total number of employees',
            ],
            [
                'name' => 'Founded Year',
                'type' => 'number',
                'description' => 'Year the entity was established',
            ],
            [
                'name' => 'Annual Revenue',
                'type' => 'number',
                'description' => 'Annual revenue in millions USD',
            ],
            [
                'name' => 'Certifications',
                'type' => 'text',
                'description' => 'Industry certifications and standards',
            ],
        ];

        foreach ($attributes as $attribute) {
            Attribute::create($attribute);
        }

        // Assign attributes to all entities
        Company::all()->each(function ($company) {
            $company->attributes()->attach(1, ['value' => rand(5000, 50000)]);
            $company->attributes()->attach(2, ['value' => rand(1980, 2010)]);
            $company->attributes()->attach(3, ['value' => rand(100, 1000)]);
            $company->attributes()->attach(4, ['value' => 'ISO 9001, ISO 27001']);
        });

        SubCompany::all()->each(function ($subCompany) {
            $subCompany->attributes()->attach(1, ['value' => rand(1000, 5000)]);
            $subCompany->attributes()->attach(2, ['value' => rand(1990, 2015)]);
            $subCompany->attributes()->attach(3, ['value' => rand(10, 100)]);
            $subCompany->attributes()->attach(4, ['value' => 'ISO 9001']);
        });

        Branch::all()->each(function ($branch) {
            $branch->attributes()->attach(1, ['value' => rand(50, 500)]);
            $branch->attributes()->attach(2, ['value' => rand(2000, 2023)]);
        });

        // Create Media for all entities
        Company::all()->each(function ($company) {
            $company->media()->createMany([
                [
                    'file_path' => 'companies/' . $company->id . '/logo.png',
                    'file_name' => 'logo.png',
                    'file_type' => 'image/png',
                    'file_size' => rand(50000, 100000),
                    'title' => $company->name . ' Logo',
                    'description' => 'Official company logo',
                    'order' => 1,
                ],
                [
                    'file_path' => 'companies/' . $company->id . '/building.jpg',
                    'file_name' => 'building.jpg',
                    'file_type' => 'image/jpeg',
                    'file_size' => rand(2000000, 5000000),
                    'title' => $company->name . ' Headquarters',
                    'description' => 'Main office building',
                    'order' => 2,
                ],
            ]);
        });

        SubCompany::all()->each(function ($subCompany) {
            $subCompany->media()->create([
                'file_path' => 'sub-companies/' . $subCompany->id . '/logo.png',
                'file_name' => 'logo.png',
                'file_type' => 'image/png',
                'file_size' => rand(40000, 80000),
                'title' => $subCompany->name . ' Logo',
                'description' => 'Division logo',
                'order' => 1,
            ]);
        });

        Branch::all()->each(function ($branch) {
            $branch->media()->create([
                'file_path' => 'branches/' . $branch->id . '/facility.jpg',
                'file_name' => 'facility.jpg',
                'file_type' => 'image/jpeg',
                'file_size' => rand(1000000, 3000000),
                'title' => $branch->name . ' Facility',
                'description' => 'Branch location and facilities',
                'order' => 1,
            ]);
        });
    }
}
