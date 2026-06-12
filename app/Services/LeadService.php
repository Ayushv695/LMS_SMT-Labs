<?php

namespace App\Services;

use App\Events\LeadConverted;
use App\Http\Controllers\LeadController;
use App\Models\Lead;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class LeadService{

    public function getLeads(array $filters){

        $sortBy = $filters['sortBy'] ?? 'created_at';
        $sortOrder = $filters['sortOrder'] ?? 'asc';
        $perPage = $filters['perPage'] ?? 1;
        $page = $filters['page'] ?? 1;
        
        $query = Lead::with('creator:id,name,email')->where('user_id',auth()->user()->id);

        if (!empty($filters['search'])) {
            $query->where('name','like','%'.$filters['search'].'%');
        }

        if (!empty($filters['status'])) {
            $query->where('status',$filters['status']);
        }

        $leads = $query->select('user_id','name','email','status','source','followed_up_at')->orderBy($sortBy,$sortOrder)->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Leads fetched successfully',
            'data' => $leads,
        ]);
    }

    public function create(array $data){
        try{

            $data['user_id'] = auth()->user()->id;
            $lead = Lead::create($data);
            $lead->load('creator:id,name,email');

            return response()->json([
                'status' => true,
                'message' => 'Lead created successfully',
                'data' => $lead
            ], 201);

        }catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'data' => []
            ], 404);
        }
    }

    public function view(LeadController $controller, string $lead_id)
    {
        try {
            
            $lead = Lead::with('creator:id,name,email')->select('id','user_id','name','email','phone','status','source','notes','followed_up_at')->findOrFail($lead_id);

            $controller->authorize('view', $lead);

            return response()->json([
                'status' => true,
                'message' => 'Lead Details',
                'data' => $lead
            ]);

        } catch (ModelNotFoundException $e) {

            return response()->json([
                'status' => false,
                'message' => 'Lead not found',
                'data' => []
            ], 404);

        } catch (AuthorizationException $e) {

            return response()->json([
                'status' => false,
                'message' => 'You can only view your own created Lead',
                'data' => []
            ], 404);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'data' => []
            ], 404);
        }
    }

    public function update(LeadController $controller, string $lead_id, array $data)
    {
        try {
            $lead = Lead::findOrFail($lead_id);

            $controller->authorize('update', $lead);

            $oldStatus = $lead->status;
            $lead->update($data);
            $lead->refresh()->load('creator:id,name,email');
            $newStatus = $lead->status;

            if($oldStatus != $newStatus && $newStatus == Lead::CONVERTED){
                event(new LeadConverted($lead));
            }
            
            return response()->json([
                'status' => true,
                'message' => 'Lead updated successfully',
                'data' => $lead
            ]);

        } catch (ModelNotFoundException $e) {

            return response()->json([
                'status' => false,
                'message' => 'Lead not found',
                'data' => []
            ], 404);

        } catch (AuthorizationException $e) {

            return response()->json([
                'status' => false,
                'message' => 'You can only update your own created Lead',
                'data' => []
            ], 404);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'data' => []
            ], 404);
        }
    }

    public function delete(LeadController $controller, string $project_id)
    {
        try {
            DB::beginTransaction();

            $lead = Lead::findOrFail($project_id);
            
            $controller->authorize('delete', $lead);

            if($lead->status == Lead::CONVERTED){
                return response()->json([
                    'status' => false,
                    'message' => 'Converted Lead cannot be deleted',
                    'data' => []
                ]);
            }

            $lead->delete();
            
            DB::commit();
            
            return response()->json([
                'status' => true,
                'message' => 'Lead deleted successfully',
                'data' => []
            ]);

        }catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Lead not found',
                'data' => []
            ], 404);

        } catch (AuthorizationException $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'You can only delete your own created Lead',
                'data' => []
            ], 404);

        }  catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'data' => []
            ], 404);
        }
    }
}