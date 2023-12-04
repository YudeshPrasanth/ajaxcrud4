<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['posts']=Product::paginate(4);
        return view('detail', $data);
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
      $post=Product::create([
        'name' => $request->name,
        'email' => $request->email,
        'password'=>$request->password
      ]);
      return response()->json($post);
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

        $post=Product::where('id',$id)->first();
        return response()->json($post);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)

        {
            $post = Product::where('id', $request->id)->Update([
                'name' => $request->name,
                'email' => $request->email,
                'password'=>$request->password
            ]);

            return Response()->json($post);
        }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $post=Product::where('id',$id)->delete();
        return response()->json($post);
    }
}
