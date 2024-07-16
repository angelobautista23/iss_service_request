<?php 

namespace App\Traits;

use Illuminate\Http\Request;
use App\Model\Brand;
use App\Model\Capacity;
use App\Model\Category;
use App\Model\Color;
use App\Model\Connector;
use App\Model\Device;
use App\Model\Model1;
use App\Model\Pin;
use App\Model\Resolution;
use App\Model\Size;
use App\Model\SubModel;
use App\Model\Type;

trait ItemSetupTrait
{
    public function validate_duplicate(Request $request){
    	$results = [];

    	$results[] = ['brand' => Brand::where('description', 'like', '%' . $request->search . '%')->where('logdel', 0)->count()];
    	$results[] = ['capacity' => Capacity::where('description', 'like', '%' . $request->search . '%')->where('logdel', 0)->count()];
    	$results[] = ['category' => Category::where('description', 'like', '%' . $request->search . '%')->where('logdel', 0)->count()];
    	$results[] = ['color' => Color::where('description', 'like', '%' . $request->search . '%')->where('logdel', 0)->count()];
    	$results[] = ['connector' => Connector::where('description', 'like', '%' . $request->search . '%')->where('logdel', 0)->count()];
    	$results[] = ['device' => Device::where('description', 'like', '%' . $request->search . '%')->where('logdel', 0)->count()];
    	$results[] = ['model' => Model1::where('description', 'like', '%' . $request->search . '%')->where('logdel', 0)->count()];
    	$results[] = ['pin' => Pin::where('description', 'like', '%' . $request->search . '%')->where('logdel', 0)->count()];
    	$results[] = ['resolution' => Resolution::where('description', 'like', '%' . $request->search . '%')->where('logdel', 0)->count()];
    	$results[] = ['size' => Size::where('description', 'like', '%' . $request->search . '%')->where('logdel', 0)->count()];
    	$results[] = ['sub_model' => SubModel::where('description', 'like', '%' . $request->search . '%')->where('logdel', 0)->count()];
    	$results[] = ['type' => Type::where('description', 'like', '%' . $request->search . '%')->where('logdel', 0)->count()];

    	$total_count = collect($results)->flatten(1)->sum();

    	return response()->json(['results' => $results, 'total_count' => $total_count]);
    }
}