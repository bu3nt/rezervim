<?php

namespace App\Http\Controllers\Admin;

use App\Models\Navigation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class NavigationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $selectColumns = ['id', 'title', 'parent_id', 'url', 'target', 'index', 'status'];
    
            $data = Navigation::select($selectColumns)
                ->orderBy('index', 'asc')
                ->get();

            $recordsTotal = Navigation::count();
            $recordsFiltered = $recordsTotal;
            
            // If searching is enabled, adjust the filtered count
            if (!empty($request->input('search.value'))) {
                $data = Navigation::select($selectColumns)->where('title', 'like', '%' . $request->input('search.value') . '%')
                ->orWhere('index', 'like', '%' . $request->input('search.value') . '%')
                ->orderBy('index', 'asc')
                ->get();


                $recordsFiltered = Navigation::where('title', 'like', '%' . $request->input('search.value') . '%')
                    ->orWhere('index', 'like', '%' . $request->input('search.value') . '%')
                    ->count();
            }
          
            $filteredData = [];

            foreach($data as $navigation){
                $filteredData[] = [
                    'id' => $navigation->id,
                    'title' => $navigation->title,
                    'url' => $navigation->url,
                    'parent' => $navigation->parent ? $navigation->parent->title : '',
                    'target' => $navigation->target,
                    'index' => $navigation->index,
                    'status' => $navigation->status ? '<span class="badge badge-success">'. __('navigation.active') .'</span>' : '<span class="badge badge-danger">'. __('navigation.inactive') .'</span>',
                    'action' => '<ul class="action"><li class="show"> <a href="'.route('admin.navigation.show', ['navigation' => $navigation->id]).'"><i class="icon-eye"></i></a></li><li class="edit"> <a href="'.route('admin.navigation.edit', ['navigation' => $navigation->id]).'"><i class="icon-pencil-alt"></i></a></li><li class="delete"><a href="javascript:void(0)" class="delete-btn" data-id="'.$navigation->id.'"><i class="icon-trash"></i></a></li></ul>'
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
        return view('admin.navigation.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.navigation.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'required|max:255',
            'url' => 'required|max:255',
            'parent_id' => 'numeric|different:id',
            'target' => 'max:255',
            'status' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect(url()->previous())
                    ->withErrors($validator)
                    ->withInput();
        }

        $maxIndex = Navigation::max('index');
        $plan = Navigation::create([
            'title' => $request['title'],
            'url' => $request['url'],
            'parent_id' => $request['parent_id'],
            'target' => $request['target'],
            'index' => $maxIndex + 1,
            'status' => $request['status'] ? 1 : 0,
        ]);

        return redirect(route('admin.navigation'))->with('success', 'Navigimi u shtua me sukses!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Navigation $navigation)
    {
        return view('admin.navigation.show', compact('navigation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Navigation $navigation)
    {
        $parent = Navigation::where('id', '!=', $navigation->id)->get();
        return view('admin.navigation.edit', compact('navigation', 'parent'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Navigation $navigation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Navigation $navigation)
    {
        $navigation->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Update index dynamically with drag n drop.
     */
    public function updateOrder(Request $request)
    {
        $newOrder = $request->input('newOrder');
        foreach ($newOrder as $index => $itemId) {
            Navigation::where('id', $itemId)->update(['index' => $index + 1]);
        }

        return response()->json(['success' => true]);
    } 
}
