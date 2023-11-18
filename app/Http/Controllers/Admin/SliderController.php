<?php

namespace App\Http\Controllers\Admin;

use App\Models\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $selectColumns = ['id', 'name', 'caption', 'index', 'status', 'image'];
    
            $data = Slider::select($selectColumns)
                ->orderBy('index', 'asc')
                ->get();

            $recordsTotal = Slider::count();
            $recordsFiltered = $recordsTotal;
            
            // If searching is enabled, adjust the filtered count
            if (!empty($request->input('search.value'))) {
                $data = Slider::select($selectColumns)->where('name', 'like', '%' . $request->input('search.value') . '%')
                ->orWhere('caption', 'like', '%' . $request->input('search.value') . '%')
                ->orWhere('index', 'like', '%' . $request->input('search.value') . '%')
                ->orderBy('index', 'asc')
                ->get();


                $recordsFiltered = Slider::where('name', 'like', '%' . $request->input('search.value') . '%')
                    ->orWhere('caption', 'like', '%' . $request->input('search.value') . '%')
                    ->orWhere('index', 'like', '%' . $request->input('search.value') . '%')
                    ->count();
            }
            
            $filteredData = [];
            
            foreach($data as $slider){
                $filteredData[] = [
                    'id' => $slider->id,
                    'name' => '<img class="img-30 me-2" src="'.asset("storage/images/slider/".$slider->image).'" alt="'.$slider->name.'">' . $slider->name,
                    'caption' => $slider->caption,
                    'index' => $slider->index,
                    'status' => $slider->status ? '<span class="badge badge-success">Aktiv</span>' : '<span class="badge badge-danger">Pasiv</span>',
                    'action' => '<ul class="action"><li class="show"> <a href="'.route('admin.slider.show', ['slider' => $slider->id]).'"><i class="icon-eye"></i></a></li><li class="edit"> <a href="'.route('admin.slider.edit', ['slider' => $slider->id]).'"><i class="icon-pencil-alt"></i></a></li><li class="delete"><a href="javascript:void(0)" class="delete-btn" data-id="'.$slider->id.'"><i class="icon-trash"></i></a></li></ul>'
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
        return view('admin.slider.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.slider.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'image' => 'mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required|max:255',
            'caption' => 'required|max:255',
            'description' => 'required|max:255',
            'status' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect(url()->previous())
                    ->withErrors($validator)
                    ->withInput();
        }

        $maxIndex = Slider::max('index');
        $slider = Slider::create([
            'name' => $request['name'],
            'position' => $request['position'],
            'caption' => $request['caption'],
            'description' => $request['description'],
            'index' => $maxIndex + 1,
            'status' => $request['status'] ? 1 : 0,
            'image' => 'slider-00.png'
        ]);

        // Update image if provided
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file = $request->file('image');

            // Specify the directory path within the disk
            $directoryPath = 'images/slider';
            if($file->store($directoryPath)){
                // Get the encrypted file name (hashed name)
                $encryptedFileName = $file->hashName();
                $slider->update(['image' => $encryptedFileName]);
            }
        } 

        return redirect(route('admin.slider'))->with('success', 'Slideri u shtua me sukses!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Slider $slider)
    {
        return view('admin.slider.show', compact('slider'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Slider $slider)
    {
        return view('admin.slider.edit', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Slider $slider)
    {
        $validator = Validator::make($request->all(),[
            'image' => 'mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required|max:255',
            'caption' => 'required|max:255',
            'description' => 'required|max:255',
            'status' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect(url()->previous())
                    ->withErrors($validator)
                    ->withInput();
        }

        $slider = Slider::findOrFail($slider->id);
        $slider->update([
            'name' => $request['name'],
            'position' => $request['position'],
            'caption' => $request['caption'],
            'description' => $request['description'],
            'status' => $request['status'] ? 1 : 0,
        ]);

        // Update image if provided
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file = $request->file('image');

            // Specify the directory path within the disk
            $directoryPath = 'images/slider';
            if($file->store($directoryPath)){
                // Get the encrypted file name (hashed name)
                $encryptedFileName = $file->hashName();
                // Concatenate the directory path and image name to get the full path
                $filePath = $directoryPath . '/' . $slider->image;
                if (Storage::disk('public')->exists($filePath)) {
                    // Delete the file
                    Storage::disk('public')->delete($filePath);
                    // Save new file to model
                    $slider->update(['image' => $encryptedFileName]);
                }
            }
        } 

        return redirect(route('admin.slider.show', $slider))->with('success', 'Slideri u ndryshua me sukses!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slider $slider)
    {
        // Specify the directory path within the disk
        $directoryPath = 'images/slider';        
        $filePath = $directoryPath . '/' . $slider->image;
        if (Storage::disk('public')->exists($filePath)) { 
            // Delete the file
            Storage::disk('public')->delete($filePath);
        }    
        $slider->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Update index dynamically with drag n drop.
     */
    public function updateOrder(Request $request)
    {
        $newOrder = $request->input('newOrder');
        foreach ($newOrder as $index => $itemId) {
            Slider::where('id', $itemId)->update(['index' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }    
}
