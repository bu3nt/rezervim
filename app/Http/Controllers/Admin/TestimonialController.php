<?php

namespace App\Http\Controllers\Admin;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $selectColumns = ['id', 'name', 'position', 'rating', 'status', 'image'];
            $orderColumns = ['name', 'position', 'rating', 'status'];
            $limit = $request->input('length');
            $start = $request->input('start');
            $order = $orderColumns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');
    
            $data = Testimonial::select($selectColumns)
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $recordsTotal = Testimonial::count();
            $recordsFiltered = $recordsTotal;
            
            // If searching is enabled, adjust the filtered count
            if (!empty($request->input('search.value'))) {
                $data = Testimonial::select($selectColumns)->where('name', 'like', '%' . $request->input('search.value') . '%')
                ->orWhere('position', 'like', '%' . $request->input('search.value') . '%')
                ->orWhere('rating', 'like', '%' . $request->input('search.value') . '%')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();


                $recordsFiltered = Testimonial::where('name', 'like', '%' . $request->input('search.value') . '%')
                    ->orWhere('position', 'like', '%' . $request->input('search.value') . '%')
                    ->orWhere('rating', 'like', '%' . $request->input('search.value') . '%')
                    ->count();
            }
            
            $filteredData = [];
            
            foreach($data as $testimonial){
                $rating = '';
                for($i=1; $i<=$testimonial->rating; $i++){
                    $rating .= '<i class="fa fa-star" style="color:orange"></i>';
                }
                $filteredData[] = [
                    'name' => '<img class="img-30 me-2" src="'.asset("storage/images/testimonial/".$testimonial->image).'" alt="'.$testimonial->name.'">' . $testimonial->name,
                    'position' => $testimonial->position,
                    'rating' => $rating,
                    'status' => $testimonial->status ? '<span class="badge badge-success">Aktiv</span>' : '<span class="badge badge-danger">Pasiv</span>',
                    'action' => '<ul class="action"><li class="show"> <a href="'.route('admin.testimonial.show', ['testimonial' => $testimonial->id]).'"><i class="icon-eye"></i></a></li><li class="edit"> <a href="'.route('admin.testimonial.edit', ['testimonial' => $testimonial->id]).'"><i class="icon-pencil-alt"></i></a></li><li class="delete"><a href="javascript:void(0)" class="delete-btn" data-id="'.$testimonial->id.'"><i class="icon-trash"></i></a></li></ul>'
                ];
            }

            $response = [
                "draw" => intval($request->input('draw')),
                "recordsTotal" => $recordsTotal,
                "recordsFiltered" => $recordsFiltered,
                "data" => $filteredData,
            ];
    
            return response()->json($response);
        }
        return view('admin.testimonial.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.testimonial.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'image' => 'mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required|max:255',
            'position' => 'required|max:255',
            'message' => 'required',
            'rating' => 'required|numeric|between:1,5',
            'status' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect(url()->previous())
                    ->withErrors($validator)
                    ->withInput();
        }

        $testimonial = Testimonial::create([
            'name' => $request['name'],
            'position' => $request['position'],
            'message' => $request['message'],
            'rating' => $request['rating'],
            'status' => $request['status'] ? 1 : 0,
            'image' => 'author-00.png'
        ]);

        // Update image if provided
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file = $request->file('image');

            // Specify the directory path within the disk
            $directoryPath = 'images/testimonial';
            if($file->store($directoryPath)){
                // Get the encrypted file name (hashed name)
                $encryptedFileName = $file->hashName();
                $testimonial->update(['image' => $encryptedFileName]);
            }
        } 

        return redirect(route('admin.testimonial'))->with('success', 'Dëshmia u shtua me sukses!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Testimonial $testimonial)
    {
        $rating = ''; 
        for($i=1; $i<=$testimonial->rating; $i++){ 
            $rating .= '<i class="fa fa-star" style="color:orange"></i>'; 
        } 
        return view('admin.testimonial.show', compact('testimonial', 'rating'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonial.edit', compact('testimonial'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        $validator = Validator::make($request->all(),[
            'image' => 'mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required|max:255',
            'position' => 'required|max:255',
            'message' => 'required',
            'rating' => 'required|numeric|between:1,5',
            'status' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect(url()->previous())
                    ->withErrors($validator)
                    ->withInput();
        }

        $testimonial = Testimonial::findOrFail($testimonial->id);
        $testimonial->update([
            'name' => $request['name'],
            'position' => $request['position'],
            'message' => $request['message'],
            'rating' => $request['rating'],
            'status' => $request['status'] ? 1 : 0,
        ]);

        // Update image if provided
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file = $request->file('image');

            // Specify the directory path within the disk
            $directoryPath = 'images/testimonial';
            if($file->store($directoryPath)){
                // Get the encrypted file name (hashed name)
                $encryptedFileName = $file->hashName();
                // Concatenate the directory path and image name to get the full path
                $filePath = $directoryPath . '/' . $testimonial->image;
                if (Storage::disk('public')->exists($filePath)) {
                    // Delete the file
                    Storage::disk('public')->delete($filePath);
                    // Save new file to model
                    $testimonial->update(['image' => $encryptedFileName]);
                }
            }
        } 

        return redirect(route('admin.testimonial.show', $testimonial))->with('success', 'Dëshmia u ndryshua me sukses!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Testimonial $testimonial)
    {
        // Specify the directory path within the disk
        $directoryPath = 'images/testimonial';        
        $filePath = $directoryPath . '/' . $testimonial->image;
        if (Storage::disk('public')->exists($filePath)) { 
            // Delete the file
            Storage::disk('public')->delete($filePath);
        }    
        $testimonial->delete();
        return response()->json(['success' => true]);
    }
}
