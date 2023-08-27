<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Expense;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Validator;
use PDF;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        try{
            $filter_type = "category";

            $user_id = auth()->user()->id;
            if($request->filter == "")
                $data = Expense::where('user_id', $user_id)->get();
            else
                $data = Expense::where('user_id', $user_id)->where($filter_type, $request->filter)->get();


            $categories = Expense::select('category')->where('user_id', $user_id)->groupBy('category')->get();

            return response()->json([
                'data' => $data,
                'categories' => $categories
            ], 200);

        }catch(Exception $e){
            return response()->json([
                'message' => "Something went wrong"
            ], 400);

        }
        

        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{

            $validator = Validator::make($request->all(), [
            'title'=>'required|string',
            'cost'=>'required|integer',
            'date' => 'required',
            'category' => 'required|string',
            'description' => 'nullable'
            ]);
            if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
            }
            Log::info(Auth::user());
            $expense = Expense::create(array_merge(
                $validator->validated(),
                ['user_id' => auth()->user()->id]
            ));

            return response()->json([
                'message' => "Expense added successfully!"
            ], 201);

        }catch(Exception $e){
            return response()->json([
                'message' => "Something went wrong"
            ], 400);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        try{
            $expenseDetails = $request->only([
            'title',
            'cost',
            'date',
            'category',
            'description',
            ]);
            Expense::whereId($request->expenseId)->update($expenseDetails);

            return response()->json([
                'message' => "Record updated successfully"
            ], 200);

        }catch(Exception $e){
            return response()->json([
                'message' => "Something went wrong"
            ], 400);

        }
        

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try{

            Expense::destroy($request->id);

            return response()->json([
                'message' => "Record deleted successfully"
            ], 200);

        }catch(Exception $e){
            return response()->json([
                'message' => "Something went wrong"
            ], 400);

        }
    }

    public function getPDF(Request $request){
        $user = auth()->user();
        $filter_type = "category";

        $data = array();
        $data['user_name'] = $user->name;
        Log::info($request);
        Log::info(json_decode($request));

        if($request->filter == ""){
            $data['totalExpense'] = Expense::where('user_id', $user->id)->sum('cost');
            $data['expenseList'] = Expense::where('user_id', $user->id)->get();
        }
        else{
            $data['expenseList'] = Expense::where('user_id', $user->id)->where($filter_type, $request->filter)->get();
            $data['totalExpense'] = Expense::where('user_id', $user->id)->where($filter_type, $request->filter)->sum('cost');

        }

        $pdf = PDF::loadView('expensePDF', compact('data'));
        return $pdf->download('expense.pdf');
    }
}
