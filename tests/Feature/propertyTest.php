<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Imports\PropertiesImport;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\RefreshDatabase;

class propertyTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test for creating property.
     *
     * @return void
     */
    public function testsPropertyAreCreatedCorrectly()
    {
        $payload = [
            "name" => "Property 1",
            "owner" => "Test Owner",
            'address' => ["line_1" => "10", "line_2" => "Test Street", "postcode" => "E11AA"],
        ];

        $this->postJson('/api/v1/properties', $payload)
            ->assertStatus(201)
            ->assertJson([
                "code" => 201,
                "message" => 'Property ' . $payload['name'] . ' was created successfully!',
                "data" => [
                    "address_1" => $payload["address"]["line_1"],
                    "address_2" => $payload["address"]["line_2"],
                    "postcode" => $payload["address"]["postcode"]
                ]
            ]);

        $this->assertDatabaseHas('properties', [
            "name" => $payload["name"],
            "owner" => $payload["owner"],
            "address_1" => $payload["address"]["line_1"],
            "address_2" => $payload["address"]["line_2"],
            "postcode" => $payload["address"]["postcode"]
        ]);
    }

    /**
     * A basic feature test retriving properties.
     *
     * @return void
     */
    public function  testPropertyAreListedCorrectly()
    {
        $this->get('/api/v1/properties')
            ->assertStatus(200)
            ->assertJson([
                'code' => '200',
                'message' => 'Properties retrived successfully.'
            ])
            ->assertJsonStructure([
                'data' => [
                    'current_page',
                    'data' => ['*' => ["id", "name", "owner", "address_1", "address_2", "postcode"]],
                    'from',
                    'per_page',
                    'path',
                    'to',
                    'total'
                ],
            ]);
    }


    protected function getTestFile($fileName)
    {
        $file = new UploadedFile(
            base_path($fileName),
            'myfile.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );

        return $file;
    }



    /**
     * A basic feature test bulk property creation.
     *
     * @return void
     */
    public function  testBulkPropertyCreation()
    {
        Excel::fake();
        $this->post('/api/v1/properties/batch', [
            'uploadedFile' => $this->getTestFile('Sample Bulk Upload.xlsx')
        ]);

        Excel::assertImported('Sample Bulk Upload.xlsx');
    }
}
