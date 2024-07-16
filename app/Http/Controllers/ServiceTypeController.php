<?php

namespace App\Http\Controllers;

// HELPERS
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Auth;

// MODEL
use App\Model\ServiceType;

// PACKAGE
use DataTables;

class ServiceTypeController extends Controller
{
    //View ServiceTypes
    public function view_service_types(Request $request){
        if($request->ajax()){
	        $data = ServiceType::where('logdel', 0)
	        			->where('status', $request->status)
        				->get();

	        return DataTables::of($data)
	            ->addColumn('raw_status', function($row){
	                $result = "";

	                if($row->status == 1){
	                    $result .= '<span class="badge badge-pill bg-success">Active</span>';
	                }
	                else if($row->status == 2){
	                    $result .= '<span class="badge badge-pill bg-danger">Archived</span>';
	                }

	                return $result;
	            })
	            ->addColumn('raw_task_type', function($row){
	                $result = "";

	                if($row->task_type == 1){
	                    $result .= 'Software Task';
	                }
	                else if($row->task_type == 2){
	                    $result .= 'Hardware Task';
	                }

	                return $result;
	            })
	            ->addColumn('raw_suggested_trt', function($row){
	                $result = "";

	                if($row->suggested_trt == 0){
	                    $result .= 'N/A';
	                }
	                else if($row->suggested_trt == 0.4){
	                    $result .= 'E4';
	                }
	                else if($row->suggested_trt == 1){
	                    $result .= 'R1';
	                }
	                else if($row->suggested_trt == 2){
	                    $result .= 'R2';
	                }
	                else if($row->suggested_trt == 3){
	                    $result .= 'R3';
	                }
	                else if($row->suggested_trt == 4){
	                    $result .= 'R4';
	                }
	                else if($row->suggested_trt == 5){
	                    $result .= 'R5';
	                }

	                return $result;
	            })
	            ->addColumn('raw_action', function($row){
	                $result = '';
	                if($row->status == 1){
	                    $result .= '<button type="button" class="btn btn-xs btn-primary table-btns btnEditServiceType" service-type-id="' . $row->id . '"><i class="fa fa-edit" title="Edit"></i></button>';

	                    $result .= ' <button type="button" class="btn btn-xs btn-danger table-btns btnActions" action="1" status="2" service-type-id="' . $row->id . '" title="Archive"><i class="fa fa-lock"></i></button>';
	                }
	                else{
	                    $result .= ' <button type="button" class="btn btn-xs btn-success table-btns btnActions" action="1" status="1" service-type-id="' . $row->id . '" title="Restore"><i class="fa fa-unlock"></i></button>';
	                }

	                return $result;
	            })
	            ->rawColumns(['raw_status', 'raw_action'])
	            ->make(true);
        }
    	else{
    		abort(403);
    	}
    }

    public function save_service_type(Request $request){
        date_default_timezone_set('Asia/Manila');
        session_start();

        if($request->ajax()){
	        if(isset($_SESSION["rapidx_user_id"])){
		        // Add ServiceType
		        if(!isset($request->service_type_id)){
		            $data = $request->all();

		            $rules = [
		                'description' => 'required|min:2|unique:service_types',
		                'task_type' => 'required',
		                'suggested_trt' => 'required',
		            ];

		            $validator = Validator::make($data, $rules);

		            try {
		                if($validator->passes()){
		                    ServiceType::insert([
		                        'description' => $request->description,
		                        'task_type' => $request->task_type,
		                        'suggested_trt' => $request->suggested_trt,
		                        'status' => 1,
		                        'created_by' => $_SESSION["rapidx_user_id"],
		                        'last_updated_by' => $_SESSION["rapidx_user_id"],
		                        'created_at' => date('Y-m-d H:i:s'),
		                        'updated_at' => date('Y-m-d H:i:s'),
		                    ]);
		                    return response()->json(['auth' => 1, 'result' => 1, 'error' => null]);
		                }
		                else{
		                    return response()->json(['auth' => 1, 'result' => 0, 'error' => $validator->messages()]);    
		                }
		            }
		            catch(\Exception $e) {
		                return response()->json(['auth' => 1, 'result' => 0, 'error' => $e]);
		            }
		        }
		        // Edit ServiceType
		        else{
		            $data = $request->all();

		            $rules = [
		                'service_type_id' => 'required|numeric',
		                'description' => 'required|min:2|unique:service_types,description,' . $request->service_type_id,
		                'task_type' => 'required',
		                'suggested_trt' => 'required',
		            ];

		            $validator = Validator::make($data, $rules);

		            try {
		                if($validator->passes()){
		                    ServiceType::where('id', $request->service_type_id)
		                    	->where('logdel', 0)
		                    	->where('status', 1)
		                        ->update([
		                            'description' => $request->description,
			                        'task_type' => $request->task_type,
			                        'suggested_trt' => $request->suggested_trt,
		                            'last_updated_by' => $_SESSION["rapidx_user_id"],
		                            'updated_at' => date('Y-m-d H:i:s'),
		                        ]);
		                    return response()->json(['auth' => 1, 'result' => 1, 'error' => null]);
		                }
		                else{
		                    return response()->json(['auth' => 1, 'result' => 0, 'error' => $validator->messages()]);    
		                }
		            }
		            catch(\Exception $e) {
		                return response()->json(['auth' => 1, 'result' => 0, 'error' => $e]);
		            }
		        }
	        }
	        else{
	        	return response()->json(['auth' => 0, 'result' => 0, 'error' => null]);
	        }
	    }
    	else{
    		abort(403);
    	}
    }

    public function get_service_type_by_id(Request $request){
        date_default_timezone_set('Asia/Manila');
        session_start();
        if($request->ajax()){
	        if(isset($_SESSION["rapidx_user_id"])){
		        $data = [
		            'service_type_id' => $request->service_type_id,
		        ];

		        $rules = [
		            'service_type_id' => 'required',
		        ];

		        $validator = Validator::make($data, $rules);

		        if($validator->passes()){
		            $service_type_info = ServiceType::where('id', $request->service_type_id)->where('logdel', 0)->first();

		            return response()->json(['auth' => 1, 'service_type_info' => $service_type_info, 'result' => 1]);
		        }
		        else{
		            return response()->json(['auth' => 1, 'service_type_info' => null, 'result' => 0]);  
		        }
		    }
		    else{
	        	return response()->json(['auth' => 0, 'result' => 0, 'error' => null]);
		    }
		}
    	else{
    		abort(403);
    	}
    }

    public function service_type_action(Request $request){
        date_default_timezone_set('Asia/Manila');
        session_start();

        if($request->ajax()){
	        // Change ServiceType Status
	        if(isset($_SESSION["rapidx_user_id"])){
		        if($request->action == 1){
		            $data = [
		                'service_type_id' => $request->service_type_id,
		                'status' => $request->status,
		            ];

		            $rules = [
		                'service_type_id' => 'required',
		                'status' => 'required|numeric',
		            ];

		            $validator = Validator::make($data, $rules);

		            if($validator->passes()){
		                try {
		                    ServiceType::where('id', $request->service_type_id)
		                    	->where('logdel', 0)
		                        ->update([
		                            'status' => $request->status,
		                            'last_updated_by' => $_SESSION["rapidx_user_id"],
		                            'updated_at' => date('Y-m-d H:i:s'),
		                        ]);

		                    return response()->json(['auth' => 1, 'result' => 1, 'error']);
		                } 
		                catch (Exception $e) {
		                    return response()->json(['auth' => 1, 'service_type_info' => null]); 
		                }
		            }
		            else{
		                return response()->json(['auth' => 1, 'result' => 0, 'error' => $validator->messages()]);    
		            }
		        }
	        } // Session Expired
		    else{
	        	return response()->json(['auth' => 0, 'result' => 0, 'error' => null]);
		    }  
		}
    	else{
    		abort(403);
    	}
    }

    public function get_cbo_service_type_by_stat(Request $request){
		session_start();
        date_default_timezone_set('Asia/Manila');

        if($request->ajax()){
        	if(isset($_SESSION["rapidx_user_id"])){
		        $search = $request->search;

		        if($search == ''){
		            $service_types = [];
		        }
		        else{
		            $service_types = ServiceType::orderby('description','asc')->select('id','description', 'task_type', 'suggested_trt')
		                        ->where('description', 'like', '%' . $search . '%')
		                        ->where('status', 1)
		                        ->where('logdel', 0)
		                        ->get();
		        }

		        $response = array();
		        $response[] = array(
	                "id" => '',
	                "text" => '',
	            );

		        foreach($service_types as $service_type){
					$desc = "";

					if($service_type->task_type == 1) {
						$desc .= "SWT | ";
					}
					else {
						$desc .= "HWT | ";
					}
					$desc .= $service_type->description;
		            $response[] = array(
		                "id" => $service_type->id . ' - ' . $service_type->suggested_trt,
		                "text" => $desc,
		            );
		        }

		        echo json_encode($response);
		        exit;
        	}
        	else{
        		$response = array();
		            $response[] = array(
		                "id" => '',
		                "text" => 'Please reload again.',
		            );

		        echo json_encode($response);
        	}
        }
    	else{
    		abort(403);
    	}
    }
}
