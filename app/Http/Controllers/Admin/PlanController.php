<?php

namespace App\Http\Controllers\Admin;

use App\Models\Plan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $selectColumns = ['id', 'name', 'monthly', 'yearly', 'popular', 'index', 'status'];
    
            $data = Plan::select($selectColumns)
                ->orderBy('index', 'asc')
                ->get();

            $recordsTotal = Plan::count();
            $recordsFiltered = $recordsTotal;
            
            // If searching is enabled, adjust the filtered count
            if (!empty($request->input('search.value'))) {
                $data = Plan::select($selectColumns)->where('name', 'like', '%' . $request->input('search.value') . '%')
                ->orWhere('index', 'like', '%' . $request->input('search.value') . '%')
                ->orderBy('index', 'asc')
                ->get();


                $recordsFiltered = Plan::where('name', 'like', '%' . $request->input('search.value') . '%')
                    ->orWhere('index', 'like', '%' . $request->input('search.value') . '%')
                    ->count();
            }
            
            $filteredData = [];
            
            foreach($data as $plan){
                $filteredData[] = [
                    'id' => $plan->id,
                    'name' => $plan->name,
                    'monthly' => __('plan.currency', ['value' => $plan->monthly]),
                    'yearly' => __('plan.currency', ['value' => $plan->yearly]),
                    'popular' => $plan->popular,
                    'index' => $plan->index,
                    'status' => $plan->status ? '<span class="badge badge-success">Aktiv</span>' : '<span class="badge badge-danger">Pasiv</span>',
                    'action' => '<ul class="action"><li class="show"> <a href="'.route('admin.plan.show', ['plan' => $plan->id]).'"><i class="icon-eye"></i></a></li><li class="edit"> <a href="'.route('admin.plan.edit', ['plan' => $plan->id]).'"><i class="icon-pencil-alt"></i></a></li><li class="delete"><a href="javascript:void(0)" class="delete-btn" data-id="'.$plan->id.'"><i class="icon-trash"></i></a></li></ul>'
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
        return view('admin.plan.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.plan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:255',
            'monthly' => 'required|decimal:0,2',
            'yearly' => 'required|decimal:0,2',
            'popular' => 'boolean',
            'status' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect(url()->previous())
                    ->withErrors($validator)
                    ->withInput();
        }

        $maxIndex = Plan::max('index');
        $plan = Plan::create([
            'name' => $request['name'],
            'monthly' => $request['monthly'],
            'yearly' => $request['yearly'],
            'popular' => $request['popular'] ? 1 : 0,
            'index' => $maxIndex + 1,
            'status' => $request['status'] ? 1 : 0,
        ]);

        return redirect(route('admin.plan'))->with('success', 'Plani u shtua me sukses!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Plan $plan)
    {
        return view('admin.plan.show', compact('plan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Plan $plan)
    {
        return view('admin.plan.edit', compact('plan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Plan $plan)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:255',
            'monthly' => 'required|decimal:0,2',
            'yearly' => 'required|decimal:0,2',
            'popular' => 'boolean',
            'status' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect(url()->previous())
                    ->withErrors($validator)
                    ->withInput();
        }

        $plan = Plan::findOrFail($plan->id);
        $plan->update([
            'name' => $request['name'],
            'monthly' => $request['monthly'],
            'yearly' => $request['yearly'],
            'popular' => $request['popular'] ? 1 : 0,
            'status' => $request['status'] ? 1 : 0,
        ]);

        return redirect(route('admin.plan.show', $plan))->with('success', 'Plani u ndryshua me sukses!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Plan $plan)
    {
        $plan->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Update index dynamically with drag n drop.
     */
    public function updateOrder(Request $request)
    {
        $newOrder = $request->input('newOrder');
        foreach ($newOrder as $index => $itemId) {
            Plan::where('id', $itemId)->update(['index' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }     
}
