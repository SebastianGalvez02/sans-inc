<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['categoryId' => Category::where('categoryName', 'Business Technology')->first()->categoryId,       'name' => 'Cloud Collaboration Suite',       'description' => 'Secure tools for shared files, messaging, and team workflows',             'price' => 249.99,  'tag' => 'software',   'active' => true],
            ['categoryId' => Category::where('categoryName', 'Business Technology')->first()->categoryId,       'name' => 'Endpoint Security Package',       'description' => 'Protection for company devices, users, and business data',                 'price' => 399.50,  'tag' => 'security',   'active' => true],
            ['categoryId' => Category::where('categoryName', 'Business Technology')->first()->categoryId,       'name' => 'Network Performance Kit',         'description' => 'Hardware and monitoring tools for dependable connectivity',                'price' => 649.00,  'tag' => 'hardware',   'active' => true],
            ['categoryId' => Category::where('categoryName', 'Office Solutions')->first()->categoryId,          'name' => 'Executive Workstation Bundle',    'description' => 'Desk equipment package for professional work environments',                'price' => 899.99,  'tag' => 'bundle',     'active' => true],
            ['categoryId' => Category::where('categoryName', 'Office Solutions')->first()->categoryId,          'name' => 'Document Management Station',     'description' => 'Scanning, printing, and document workflow equipment',                      'price' => 549.75,  'tag' => 'office',     'active' => true],
            ['categoryId' => Category::where('categoryName', 'Office Solutions')->first()->categoryId,          'name' => 'Meeting Room Essentials',         'description' => 'Presentation and conferencing tools for business meetings',                'price' => 725.00,  'tag' => 'meetings',   'active' => true],
            ['categoryId' => Category::where('categoryName', 'Consulting Services')->first()->categoryId,       'name' => 'Operations Assessment',           'description' => 'Professional review of business processes and improvement areas',          'price' => 1200.00, 'tag' => 'consulting', 'active' => true],
            ['categoryId' => Category::where('categoryName', 'Consulting Services')->first()->categoryId,       'name' => 'Digital Transformation Plan',     'description' => 'Strategic roadmap for technology adoption and workflow modernization',     'price' => 2500.00, 'tag' => 'strategy',   'active' => true],
            ['categoryId' => Category::where('categoryName', 'Consulting Services')->first()->categoryId,       'name' => 'Compliance Readiness Review',     'description' => 'Guidance for internal controls, documentation, and audit preparation',     'price' => 1800.00, 'tag' => 'compliance', 'active' => true],
            ['categoryId' => Category::where('categoryName', 'Managed Support')->first()->categoryId,           'name' => 'Help Desk Support Plan',          'description' => 'Monthly support coverage for user requests and technical incidents',       'price' => 799.00,  'tag' => 'support',    'active' => true],
            ['categoryId' => Category::where('categoryName', 'Managed Support')->first()->categoryId,           'name' => 'Infrastructure Monitoring',       'description' => 'Continuous monitoring for servers, applications, and network services',    'price' => 950.00,  'tag' => 'monitoring', 'active' => true],
            ['categoryId' => Category::where('categoryName', 'Managed Support')->first()->categoryId,           'name' => 'Maintenance Retainer',            'description' => 'Scheduled maintenance and priority response for business systems',         'price' => 1100.00, 'tag' => 'retainer',   'active' => true],
            ['categoryId' => Category::where('categoryName', 'Training and Development')->first()->categoryId,  'name' => 'Leadership Workshop',             'description' => 'Instructor-led program for managers and emerging team leaders',            'price' => 650.00,  'tag' => 'training',   'active' => true],
            ['categoryId' => Category::where('categoryName', 'Training and Development')->first()->categoryId,  'name' => 'Software Adoption Training',      'description' => 'Practical training sessions for business software rollouts',               'price' => 475.00,  'tag' => 'software',   'active' => true],
            ['categoryId' => Category::where('categoryName', 'Training and Development')->first()->categoryId,  'name' => 'Customer Service Program',        'description' => 'Professional development program for client-facing teams',                 'price' => 525.00,  'tag' => null,         'active' => true],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
