<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\GenerateFrequentItemSetsRequest;
use App\Models\Order;
use Phpml\Association\Apriori;

class AprioriController extends Controller
{
    public function index(GenerateFrequentItemSetsRequest $request)
    {
        $support = number_format($request->support / 100, 2);
        $confidence = number_format($request->confidence / 100, 2);

        $orders = Order::all();

        $samples = [];
        foreach ($orders as $order) {
            if (!empty($order->products)) {
                $sample = [];
                foreach ($order->products as $product) {
                    $sample[] = $product->name;
                }
            }
            if (!empty($sample)) {
                $samples[] = $sample;
            }
        }

        //$samples = [['alpha', 'beta', 'epsilon'], ['alpha', 'beta', 'theta'], ['alpha', 'beta', 'epsilon'], ['alpha', 'beta', 'theta'], ['alpha', 'beta', 'theta', 'gama']];
        $labels  = [];

        $associator = new Apriori($support, $confidence);
        $associator->train($samples, $labels);

        // PREDICT
        $associator->predict(['alpha','theta']);
        $associator->predict([['alpha','epsilon'],['beta','theta']]);

        // ASSOCIATING
        $rules = $associator->getRules();

        // FREQUENT ITEMS SETS
        $frequent_items_sets = $associator->apriori();

        $data = [
            'success' => true,
            'message' => 'Pyetësori përmban gabime. Ju lutem rishikoni dhe provoni përsëri!',
            'frequent_items_sets' => $frequent_items_sets
        ];

        return response()->json($data);
    }
}
