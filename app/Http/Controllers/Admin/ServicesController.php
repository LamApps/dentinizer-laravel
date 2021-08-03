<?php

namespace App\Http\Controllers\Admin;

use App\Models\Doctor;
use App\Models\Service;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Library\Helpers\Helper;
use App\models\service_category;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Procedureserviceitem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Library\Services\DbHelperTools;
use Illuminate\Support\Facades\Storage;

class ServicesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $services = DB::select("SELECT services.id, services.service_name, services.price, services.note, services.category_id, service_categories.name AS s_name FROM services
        LEFT JOIN service_categories ON service_categories.id = services.category_id");

        $data = DB::select("SELECT * FROM service_categories");
        $cat_arrs = array();
        foreach($data as $row) { 
            $cat_arrs[] = array(
               "id"     => $row->id,
               "parent" => $row->parent_id,
               "text"   => $row->name
            );
        }

        $datas = json_encode($cat_arrs);
        return view('admin.services', compact('services', 'datas'));
    }


    public function store(Request $data) 
    {
        
        Service::updateOrCreate(
            [
                'id' => $data['id']
            ],
            [
            'service_name' => $data['service_name'],
            'price' => $data['price'],
            'note' => $data['note'],
            'category_id' => $data['category']
        ]);

        service_category::updateOrCreate(
            [
                'id' => $data['id']
            ],
            [
            'name'      => $data['service_name'],
            'parent_id' => $data['category']
        ]);

        return response()->json(['success'=>'Ajax request submitted successfully']);
    }


    public function root_category_store(Request $data) 
    {   
        $id = DB::table('service_categories')->insertGetId(
            ['parent_id' => '#', 'name' => $data['name']]
        );

        return response()->json(['success'=> true, 'id' => $id, 'name' => $data['name']]);
    }

    public function category_store(Request $data) 
    {
        // DB::table('service_categories')->insert([
        //     'parent_id'        => $data['parent_id'],
        //     'name'          => $data['name']
        // ]);
        // return response()->json(['success'=>'Ajax request submitted successfully']);

        $id = DB::table('service_categories')->insertGetId([
            'parent_id' => $data['parent_id'], 
            'name' => $data['name']
            ]);

        return response()->json(['success'=> true, 'id' => $id ]);
    }

    public function category_update(Request $data) 
    {
        DB::table('service_categories')
            ->where('id', $data['id'])
            ->update(['name' => $data['name']]);

        return response()->json(['success'=>'Ajax request submitted successfully']);
    }


    

    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();

        return redirect('/admin/services')->with('success', 'Staff Data is successfully deleted');
    }

    public function category_delete(Request $data)
    {
        DB::table('service_categories')->delete($data['id']);

        return redirect('/admin/services')->with('success', 'Staff Data is successfully deleted');
    }

    public function sdtServices(Request $request,$category_id)
    {
        $data=$meta=[];
        if($category_id>0){
            $services = Service::where('category_id',$category_id)->orderByDesc('id')->get();
        }else{
            $services = Service::orderByDesc('id')->get(); 
        }
        
        foreach ($services as $d) {
            $row=array();
                //<th>Code</th>
                $row[]='<a style="cursor:pointer;" onclick="_formService('.$d->id.')">'.$d->code.'</a>';
                //<th>Name</th>
                $en_name='<p class="mb-0">'.$d->service_name.'</p>';
                $ar_name='<p class="mb-0">'.$d->service_name_ar.'</p>';
                $row[]=$en_name.$ar_name;
                //<th>Price</th>
                $row[]=$d->price;
                //<th>Category</th>
                $en_cat_name='<p class="mb-0">'.$d->category->name.'</p>';
                $ar_cat_name='<p class="mb-0">'.$d->category->name_ar.'</p>';
                $row[]=$en_cat_name.$ar_cat_name;
                //Actions
                $btn_edit='<button class="btn btn-icon btn-sm btn-outline-primary mr-1" onclick="_formService('.$d->id.')" title="Edit">'.Helper::getSvgIconeByAction('EDIT').'</button>';
                $btn_delete='<button class="btn btn-icon btn-sm btn-outline-danger" onclick="_deleteService('.$d->id.')" title="Delete">'.Helper::getSvgIconeByAction('DELETE').'</button>';
                $row[]='<p class="mb-0">'.$btn_edit.$btn_delete.'</p>';
            $data[]=$row;
        }    
        $result = [
            'data' => $data,
        ];
        return response()->json($result);
    }
    public function formService($service_id){
        $service=null;
        if ($service_id > 0) {
            $service = Service::find ( $service_id );
        }
        return view('admin.form.service',compact('service'));
    }
    public function storeFormService(Request $request) {
		$success = false;
        $msg = 'Oops, something went wrong !';
        $id = 0;
        $resultPath='';
        if ($request->isMethod('post')) {
            //dd($request->all());
            $DbHelperTools=new DbHelperTools();
            $service_id=$DbHelperTools->manageService($request->all());
            $success = true;
            $msg = 'Your service have been saved successfully';
        }         
        return response ()->json ( [ 
                'success' => $success,
                'msg' => $msg 
        ] );
    }
    public function deleteService($id){
        /**
         * forceDelete
         */
        $success = false;
        $DbHelperTools=new DbHelperTools();
        if($id){
            //delete from database
            $deletedRows = $DbHelperTools->massDeletes([$id],'service',0);
            if($deletedRows>0){
              $success = true;
            }
        }
        return response()->json(['success'=>$success]);
    }
    public function selectCategoriesOptions(){
        $result=[];
        $rows=Category::select('id','name')->get();
        if(count($rows)>0){
            foreach($rows as $row){
                $result[]=['id'=>$row['id'],'name'=>$row['name']];
            }
        }
        return response()->json($result);
    }
    public function listCategories(){
        $categories = Category::all ();
        return view('admin.category.list',compact('categories'));
    }

    public function formCategory($category_id){
        $category=null;
        if ($category_id > 0) {
            $category = Category::find ( $category_id );
        }
        return view('admin.form.category',compact('category'));
    }
    public function storeFormCategory(Request $request) {
		$success = false;
        $msg = 'Oops, something went wrong !';
        $id = 0;
        $iconPath='';
        if($request->hasFile('file')){
            $uploadedFile = $request->file ( 'file' );
            $original_name=time().'_'.$uploadedFile->getClientOriginalName();
            
            $path = 'uploads/files/svg/';
            $filePath='files/svg/';
            if(!File::exists($path)) {
                File::makeDirectory($path, 0755, true, true);
            }

			$iconPath=Storage::disk('public_uploads')->putFileAs ( $filePath, $uploadedFile, $original_name );
			$exists = Storage::disk ( 'public_uploads' )->exists ( $filePath."{$original_name}" );
			if(!$exists) {
				$iconPath=null;
			}
        }
        if ($request->isMethod('post')) {
            //dd($request->all());
            $DbHelperTools=new DbHelperTools();
            $iconPath=($iconPath)?base64_encode('uploads/'.$iconPath):null;
            $data=array(
                'id'=>$request->id,
                'name'=>$request->name,
                'name_ar'=>$request->name_ar,
                'path_icon'=>$iconPath,
                'order_show'=>$request->order_show,
                'is_active'=>$request->is_active,
            );
            $category_id=$DbHelperTools->manageServiceCategorie($data);
            $success = true;
            $msg = 'Your category have been saved successfully';
        }         
        return response ()->json ( [ 
                'success' => $success,
                'msg' => $msg 
        ] );
    }
    public function deleteCategory($id){
        /**
         * forceDelete
         */
        $success = false;
        $DbHelperTools=new DbHelperTools();
        if($id){
            //delete from database
            $deletedRows = $DbHelperTools->massDeletes([$id],'category',0);
            if($deletedRows>0){
              $success = true;
            }
        }
        return response()->json(['success'=>$success]);
    }
    public function sdtProcedures(Request $request,$patient_id)
    {
        $canDelete=(Auth::user()->user_type=='admin')?true:false;
        $data=$meta=$procedureItems=[];
        if($patient_id>0){
            $procedureItems = Procedureserviceitem::where('patient_id',$patient_id)->orderByDesc('id')->get();
        }
        
        foreach ($procedureItems as $d) {
            $row=array();
                //th
                $row[]='<label class="checkbox checkbox-single"><input type="checkbox" value="'.$d->id.'" class="checkable"/><span></span></label>';
                //<th>Teeth ID</th>
                $invoice='';
                if($d->invoice_id>0){
                    $invoice='<p class="mb-0"><span class="badge badge-light-info">INV#'.$d->invoice->number.'</span></p>';
                }
                $doctor='<p class="mb-0"><span class="badge badge-light-primary">Dr : '.$d->doctor->name.'</span></p>';
                $row[]='<p class="mb-0">'.$d->teeth_id.'</p>'.$invoice.$doctor;
                //<th>Service Name</th>
                $tabHelperType=Helper::getcssClassByType($d->type);
                $type='<span class="badge badge-'.$tabHelperType[0].'">'.$tabHelperType[1].'</span> ';
                $code='<span class="badge badge-light-info">'.$d->service->code.'</span> ';
                $row[]=$type.$code.$d->service->service_name;
                //<th>quantity</th>
                $row[]=$d->quantity;
                //<th>rate</th>
                $row[]=$d->rate.' '.env('CURRENCY_SYMBOL');
                //<th>total</th>
                $row[]=$d->total.' '.env('CURRENCY_SYMBOL');
                //<th>Note</th>
                $row[]=$d->note;
                //Actions
                $btn_edit='<button class="btn btn-icon btn-sm btn-outline-primary mr-1" onclick="_formProcedureServiceItem('.$d->id.','.$d->teeth_id.')" title="Edit">'.Helper::getSvgIconeByAction('EDIT').'</button>';
                $btn_delete='';
                if($canDelete)
                    $btn_delete='<button class="btn btn-icon btn-sm btn-outline-danger" onclick="_deleteProcedureServiceItem('.$d->id.')" title="Delete">'.Helper::getSvgIconeByAction('DELETE').'</button>';
                if($d->invoice_id>0){
                    $btn_edit=$btn_delete=''; 
                }
                $btn_group_actions='<div class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle hide-arrow mr-1" id="invoiceActions"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        '.Helper::getSvgIconeByAction('MORE-VERTICAL').'
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="invoiceActions">
                        <a class="dropdown-item sort-asc" target="_blank" href="/procedures/pdf/'.$d->doctor_id.'/'.$d->patient_id.'/'.$d->id.'/stream">'.Helper::getSvgIconeByAction('FILE').' Pdf</a>
                        <a class="dropdown-item sort-asc" target="_blank" href="/procedures/pdf/'.$d->doctor_id.'/'.$d->patient_id.'/'.$d->id.'/download">'.Helper::getSvgIconeByAction('DOWNLOAD').' Download</a>
                    </div>
            </div>';
                $row[]='<p class="mb-0">'.$btn_edit.$btn_delete.'</p>';
            $data[]=$row;
        }    
        $result = [
            'data' => $data,
        ];
        return response()->json($result);
    }
    public function formProcedureServiceItem($procedure_service_item_id,$teeth_id,$patient_id,$doctor_id){
        $item=null;
        if ($procedure_service_item_id > 0) {
            $item = Procedureserviceitem::find ( $procedure_service_item_id );
            if($item){
                $teeth_id=$item->teeth_id;
                $patient_id=$item->patient_id;
                $doctor_id=$item->doctor_id;
            }
        }
        return view('admin.form.procedure-service-item',compact('item','teeth_id','patient_id','doctor_id'));
    }
    public function storeFormProcedureServiceItem(Request $request) {
		$success = false;
        $msg = 'Oops, something went wrong !';
        $id = 0;
        if ($request->isMethod('post')) {
            //dd($request->all());
            $DbHelperTools=new DbHelperTools();
            $data=array(
                'id'=>$request->id,
                'patient_id'=>$request->patient_id,
                'teeth_id'=>$request->teeth_id,
                'doctor_id'=>$request->doctor_id,
                'service_id'=>$request->service_id,
                'quantity'=>$request->quantity,
                'rate'=>$request->rate,
                'total'=>$request->total,
                'note'=>$request->note,
                'type'=>$request->type,
                //'invoiced'=>$request->invoiced,
            );
            //dd($data);
            $item_id=$DbHelperTools->manageProcedureServiceItem($data);
            $success = true;
            $msg = 'Your item have been saved successfully';
        }         
        return response ()->json ( [ 
                'success' => $success,
                'msg' => $msg 
        ] );
    }
    public function selectServicesOptions($category_id){
        $result=[];
        if($category_id>0){
            $rows=Service::select('id','code','service_name','price')->where('category_id',$category_id)->get();
        }else{
           $rows=Service::select('id','code','service_name')->get(); 
        }
        
        if(count($rows)>0){
            foreach($rows as $row){
                $result[]=['id'=>$row['id'],'name'=>$row['code'].' - '.$row['service_name'].' - '.$row['price'].' '.env('CURRENCY_SYMBOL')];
            }
        }
        return response()->json($result);
    }
    public function selectDoctorsOptions($doctor_id){
        $result=[];
        if($doctor_id>0){
            $rows=Doctor::where('user_id',$doctor_id)->get();
        }else{
           $rows=Doctor::all(); 
        }
        
        if(count($rows)>0){
            foreach($rows as $row){
                $result[]=['id'=>$row['user_id'],'name'=>$row->user->name];
            }
        }
        return response()->json($result);
    }
    //admin/get/price/service
    public function getPriceService($service_id){
        $price=0;
        if($service_id>0){
            $row=Service::select('id','price')->where('id',$service_id)->first();
            $price=$row['price'];
        }
        return response()->json(['price' => $price]);
    }
}
