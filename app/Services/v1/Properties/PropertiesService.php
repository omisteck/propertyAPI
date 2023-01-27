<?php
namespace App\Services\v1\Properties;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\ApiResponseTrait;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Resources\CreatePropertyResource;
use App\Http\Resources\ListPropertiesResource;
use App\Imports\PropertiesImport;

class PropertiesService
{
    use ApiResponseTrait;

    public function handleSavingProperty(Request $request)
    {
        $createdProperty = Property::create([
            'name' => $request->name,
            'owner' => $request->owner,
            'address_1' => $request->address['line_1'],
            'address_2'=> $request->address['line_2'],
            'postcode' => $request->address['postcode']
        ]);

        return $this->successResponse(
            new CreatePropertyResource($createdProperty),
            'Property ' . $request->name . ' was created successfully!',
            Response::HTTP_CREATED
        );
    }


    public function handleFetchingAllProperty(Request $request){
        
        $limit = $request->limit ?? config('system.pagination');
        $listOfProperties = Property::paginate($limit);

        return $this->successResponse(
            $listOfProperties,
            'Properties retrived successfully.',
            Response::HTTP_OK
        );
    }

    public function handleBatchStore($request)
    {

        Excel::import(new PropertiesImport,$request->file('uploadedFile'));
        
        return $this->successResponse(
            [],
            'Bulk Property creation successfully.',
            Response::HTTP_CREATED
        );
    }
}
