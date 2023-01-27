<?php

namespace App\Http\Controllers;

use App\Http\Requests\BatchStorePropertiesRequest;
use App\Http\Requests\StorePropertyRequest;
use App\Http\Requests\UpdatePropertyRequest;
use App\Models\Property;
use App\Services\v1\Properties\PropertiesService;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    protected $propertiesService;

    /**
     * inject the services required.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct( PropertiesService $propertiesService)
    {
        $this->propertiesService = $propertiesService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->propertiesService->handleFetchingAllProperty($request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePropertyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePropertyRequest $request)
    {
        return $this->propertiesService->handleSavingProperty($request);
    }

    /**
     * Store batch resource in storage.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function storeBatch(BatchStorePropertiesRequest $request)
    {
        return $this->propertiesService->handleBatchStore($request);
    }

}
