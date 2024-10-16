<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Motor;

class MotorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $motors = Motor::latest()->get();
        return view ('motor.index', compact('motors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('motor.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|integer',
            'category' => 'required',
            'image' => 'required|mimes:png,jpeg,jpg'
        ]);

        $image = $request->file('image');
        $name = time().'.'.$image->getClientOriginalExtension();
        $destinationPath = public_path('/image');
        $image->move($destinationPath, $name);

        Motor::create([
            'name'=>$request->get('name'),
            'description'=>$request->get('description'),
            'price'=>$request->get('price'),
            'category_id'=>$request->get('category'),
            'image'=>$name
        ]);

        return redirect()->route('motor.index')->with('message', 'Motor berhasil ditambahkan');
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
    public function edit(string $id)
    {
        $motor = Motor::find($id);
        return view('motor.edit', compact('motor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'name'=>'required',
            'description'=>'required',
            'price'=>'required|integer',
            'category'=>'required',
            'image'=>'mimes:jpg,jpeg,png'
        ]);
        
        $motor = Motor::find($id);
        $name = $motor->image;
        if  ($request->hasFile('image')){
            $image = $request->file('image');
                $name = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/image');
                $image->move($destinationPath, $name);
        }

        $motor->name = $request->get('name');
        $motor->description = $request->get('description');
        $motor->price = $request->get('price');
        $motor->category_id = $request->get('category');
        $motor->image = $name;
        $motor->save();
        return redirect()->route('motor.index')->with('message','Motor berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $motor = Motor::find($id);

    // Cek apakah kategori ditemukan
    if ($motor) {
        $motor->delete();
        return redirect()->route('motor.index')->with('message', 'motor berhasil dihapus');
    } else {
        return redirect()->route('motor.index')->with('error', 'motor tidak ditemukan');
    }
    }
}
