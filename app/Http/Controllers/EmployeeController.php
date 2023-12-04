<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $data['posts'] = Employee::get();

        return view('index', $data);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $post = Employee::Create([
            'name' => $request->name,
            'city' => $request->city
        ]);

        return Response()->json($post);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $where = array('id' => $id);
        $post = Employee::where($where)->first();

        return Response()->json($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $post = Employee::where('id', $request->post_id)->Update([
            'name' => $request->name,
            'city' => $request->city
        ]);

        return Response()->json($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $post = Employee::where('id', $id)->delete();

        return Response()->json($post);
    }
}
