<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLeadRequest;
use App\Http\Requests\UpdateLeadRequest;
use App\Services\LeadService;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    protected LeadService $service;

    public function __construct(LeadService $service){
        $this->service = $service;
    }

    public function store(CreateLeadRequest $request)
    {
        return $this->service->create($request->validated());
    }

    public function update(UpdateLeadRequest $request, string $lead_id) {

        return $this->service->update(new LeadController($this->service), $lead_id, $request->validated());
    }

    public function destroy(string $lead_id)
    {
        return $this->service->delete(new LeadController($this->service), $lead_id);
    }

    public function show(string $lead_id)
    {
        return $this->service->view(new LeadController($this->service),$lead_id);
    }

    public function index(Request $request){
        return $this->service->getLeads($request->all());
    }
}
