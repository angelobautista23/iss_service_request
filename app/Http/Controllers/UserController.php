<?php

namespace App\Http\Controllers;

// HELPERS
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Auth;

// MODEL
use App\Model\User;
use App\Model\RapidXUser;

// PACKAGE
use DataTables;

class UserController extends Controller
{
    //View Users
    public function view_users(Request $request){
        if($request->ajax()){
	        $data = RapidXUser::where('user_stat', $request->status)
	        			->with([
	        				'user_info',
	        			])
        				->get();

	        return DataTables::of($data)
	            ->addColumn('raw_user_stat', function($row){
	                $result = "";

	                if($row->user_stat == 1){
	                    $result .= '<span class="badge badge-pill bg-success">Active</span>';
	                }
	                else if($row->user_stat == 2){
	                    $result .= '<span class="badge badge-pill bg-danger">Archived</span>';
	                }

	                return $result;
	            })
	            ->addColumn('raw_iss_staff', function($row){
	                $result = "";

	                if($row->user_info != null) {
		                if($row->user_info->iss_staff == 1){
		                    $result .= '<button type="button" class="btn btn-xs btn-success table-btns btnAssign" user-id="' . $row->id . '" val="0" action="1"><i class="fa fa-check" title="Unassign"></i></button>';
		                }
		                else {
		                    $result .= '<button type="button" class="btn btn-xs btn-danger table-btns btnAssign" user-id="' . $row->id . '" val="1" action="1"><i class="fa fa-times" title="Assign"></i></button>';
		                }
	                }
	                else {
	                	$result .= '<button type="button" class="btn btn-xs btn-danger table-btns btnAssign" user-id="' . $row->id . '" val="1" action="1"><i class="fa fa-times" title="Assign"></i></button>';
	                }

	                return $result;
	            })
	            ->addColumn('raw_admin', function($row){
	                $result = "";

	                if($row->user_info != null) {
		                if($row->user_info->admin == 1){
		                    $result .= '<button type="button" class="btn btn-xs btn-success table-btns btnAssign" user-id="' . $row->id . '" val="0" action="2"><i class="fa fa-check" title="Unassign"></i></button>';
		                }
		                else {
		                    $result .= '<button type="button" class="btn btn-xs btn-danger table-btns btnAssign" user-id="' . $row->id . '" val="1" action="2"><i class="fa fa-times" title="Assign"></i></button>';
		                }
	                }
	                else {
	                	$result .= '<button type="button" class="btn btn-xs btn-danger table-btns btnAssign" user-id="' . $row->id . '" val="1" action="2"><i class="fa fa-times" title="Assign"></i></button>';
	                }

	                return $result;
	            })
	            ->addColumn('raw_action', function($row){
	                $result = '';
	                if($row->user_stat == 1){
	                    $result .= '<button type="button" class="btn btn-xs btn-primary table-btns btnEditUser" user-id="' . $row->id . '"><i class="fa fa-edit" title="Edit"></i></button>';

	                    $result .= ' <button type="button" class="btn btn-xs btn-danger table-btns btnActions" action="1" status="2" user-id="' . $row->id . '" title="Archive"><i class="fa fa-lock"></i></button>';
	                }
	                else{
	                    $result .= ' <button type="button" class="btn btn-xs btn-success table-btns btnActions" action="1" status="1" user-id="' . $row->id . '" title="Restore"><i class="fa fa-unlock"></i></button>';
	                }

	                return $result;
	            })
	            ->rawColumns(['raw_user_stat', 'raw_action', 'raw_iss_staff', 'raw_admin'])
	            ->make(true);
        }
    	else{
    		abort(403);
    	}
    }

    public function save_user(Request $request){
        date_default_timezone_set('Asia/Manila');
        session_start();

        if($request->ajax()){
	        if(isset($_SESSION["rapidx_user_id"])){
		        // Add User
		        if(!isset($request->user_id)){
		            $data = [
		                'description' => $request->description,
		            ];

		            $rules = [
		                'description' => 'required|min:2|unique:users',
		            ];

		            $validator = Validator::make($data, $rules);

		            try {
		                if($validator->passes()){
		                    User::insert([
		                        'description' => $request->description,
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
		        // Edit User
		        else{
		            $data = [
		                'user_id' => $request->user_id,
		                'description' => $request->description,
		            ];

		            $rules = [
		                'user_id' => 'required|numeric',
		                'description' => 'required|min:2|unique:users,description,' . $request->user_id,
		            ];

		            $validator = Validator::make($data, $rules);

		            try {
		                if($validator->passes()){
		                    User::where('id', $request->user_id)
		                    	->where('logdel', 0)
		                    	->where('status', 1)
		                        ->update([
		                            'description' => $request->description,
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

    public function get_user_by_id(Request $request){
        date_default_timezone_set('Asia/Manila');
        session_start();
        if($request->ajax()){
	        if(isset($_SESSION["rapidx_user_id"])){
		        $data = [
		            'user_id' => $request->user_id,
		        ];

		        $rules = [
		            'user_id' => 'required',
		        ];

		        $validator = Validator::make($data, $rules);

		        if($validator->passes()){
		            $user_info = User::where('id', $request->user_id)->where('logdel', 0)->first();

		            return response()->json(['auth' => 1, 'user_info' => $user_info, 'result' => 1]);
		        }
		        else{
		            return response()->json(['auth' => 1, 'user_info' => null, 'result' => 0]);  
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

    public function user_action(Request $request){
        date_default_timezone_set('Asia/Manila');
        session_start();

        if($request->ajax()){
	        // Change User Status
	        if(isset($_SESSION["rapidx_user_id"])){
		        if($request->action == 1){
		            $data = [
		                'user_id' => $request->user_id,
		                'status' => $request->status,
		            ];

		            $rules = [
		                'user_id' => 'required',
		                'status' => 'required|numeric',
		            ];

		            $validator = Validator::make($data, $rules);

		            if($validator->passes()){
		                try {
		                    User::where('id', $request->user_id)
		                    	->where('logdel', 0)
		                        ->update([
		                            'status' => $request->status,
		                            'last_updated_by' => $_SESSION["rapidx_user_id"],
		                            'updated_at' => date('Y-m-d H:i:s'),
		                        ]);

		                    return response()->json(['auth' => 1, 'result' => 1, 'error']);
		                } 
		                catch (Exception $e) {
		                    return response()->json(['auth' => 1, 'user_info' => null]); 
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

    public function assign_user(Request $request){
        date_default_timezone_set('Asia/Manila');
        session_start();

        if($request->ajax()){
	        // Change User Status
	        if(isset($_SESSION["rapidx_user_id"])){
	            $data = [
	                'user_id' => $request->user_id,
	                'val' => $request->val,
	            ];

	            $rules = [
	                'user_id' => 'required',
	                'val' => 'required|numeric',
	            ];

	            $validator = Validator::make($data, $rules);

	            if($validator->passes()){
	                try {
	                	$update_data = [
                            'last_updated_by' => $_SESSION["rapidx_user_id"],
                            'updated_at' => date('Y-m-d H:i:s'),
                        ];

                        $insert_data = [
                    		'user_id' => $request->user_id,
                            'last_updated_by' => $_SESSION["rapidx_user_id"],
                            'created_by' => $_SESSION["rapidx_user_id"],
                            'iss_staff' => 0,
                            'admin' => 0,
                            'status' => 1,
                            'updated_at' => date('Y-m-d H:i:s'),
                            'created_at' => date('Y-m-d H:i:s'),
                        ];
	                	if($request->action == 1){
	                		$update_data['iss_staff'] = $request->val;
	                		$insert_data['iss_staff'] = $request->val;
	                	}
	                	else {
	                		$update_data['admin'] = $request->val;
	                		$insert_data['admin'] = $request->val;
	                	}
	                	$user_info = User::where('user_id', $request->user_id)
	                					->first();

	                	if($user_info != null) {
	                		User::where('user_id', $request->user_id)
		                    	->where('logdel', 0)
		                        ->update($update_data);	
	                	}
	                    else {
	                    	User::insert($insert_data);	
	                    }

	                    return response()->json(['auth' => 1, 'result' => 1, 'error']);
	                } 
	                catch (Exception $e) {
	                    return response()->json(['auth' => 1, 'user_info' => null]); 
	                }
	            }
	            else{
	                return response()->json(['auth' => 1, 'result' => 0, 'error' => $validator->messages()]);    
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

    public function get_cbo_user_by_stat(Request $request){
        date_default_timezone_set('Asia/Manila');

        if($request->ajax()){
        	if(isset($_SESSION["rapidx_user_id"])){
		        $search = $request->search;

		        if($search == ''){
		            $users = [];
		        }
		        else{
		            $users = User::orderby('description','asc')->select('id','description')
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

		        foreach($users as $user){
		            $response[] = array(
		                "id" => $user->id,
		                "text" => $user->description,
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

	public function get_cbo_user_staffs_by_stat(Request $request){
        date_default_timezone_set('Asia/Manila');
        session_start();

        if($request->ajax()){
        	if(isset($_SESSION["rapidx_user_id"])){
		        $search = $request->search;

		        if($search == ''){
		            $users = [];
					$iss_staffs = [];
		        }
		        else{
		            $users = RapidXUser::
								with([
									'user_info' => function($query) {
										$query->select('id', 'user_id', 'admin', 'iss_staff');
										$query->where('iss_staff', 1);
									}
								])
								->select('id','name')
								->where('name', 'like', '%' . $search . '%')
		                        ->where('user_stat', 1)
								->orderby('name','asc')
		                        ->get();


					$iss_staffs = collect($users)->where('user_info', '!=', null);
		        }

		        $response = array();
		        $response[] = array(
	                "id" => '',
	                "text" => '',
	            );

		        foreach($iss_staffs as $user){
		            $response[] = array(
		                "id" => $user->id,
		                "text" => $user->name,
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

    public function get_cbo_rx_user_emails(Request $request){
        date_default_timezone_set('Asia/Manila');
        session_start();

        if($request->ajax()){
        	if(isset($_SESSION["rapidx_user_id"])){
		        $search = $request->search;

		        if($search == ''){
		            $users = [];
		        }
		        else{
		            $users = RapidXUser::orderby('name','asc')->select('id','name', 'email')
		                        ->where('name', 'like', '%' . $search . '%')
		                        ->where('user_stat', 1)
		                        ->get();
		        }

		        $response = array();
		        $response[] = array(
	                "id" => '',
	                "text" => '',
	            );

		        foreach($users as $user){
		            $response[] = array(
		                "id" => $user->email,
		                "text" => $user->name,
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
