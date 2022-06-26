<?php

namespace App\Http\Controllers;

use App\Models\Supir;
use Illuminate\Http\Request;

class SupirController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $supir = Supir::all();
        if($supir->count() == 0) {
            return Response()->json([
                'status' => 'failed',
                'data' => 'Belum ada data'
            ], 401);
        } else {
            return Response()->json([
                'status' => 'success',
                'message' => 'Data berhasil di load',
                'data' => $supir
            ], 200);
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required|unique:supirs|max:255',
            'umur' => 'required|numeric|min:0',
            'alamat' => 'required',
            'status' => 'required|boolean'
        ]);

        Supir::create([
            'nama' => $request->input('nama'),
            'umur' => $request->input('umur'),
            'alamat' => $request->input('alamat'),
            'status' => $request->input('status')
        ]);
        return Response()->json([
            'status' => 'success',
            'message' => 'data berhasil disimpan',
            'data' => $request->all()
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Supir  $supir
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $supir = Supir::findOrFail($id);
        return Response()->json([
            'status' => 'success',
            'message' => 'Data ada',
            'data' => $supir
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Supir  $supir
     * @return \Illuminate\Http\Response
     */
    public function edit(Supir $supir)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Supir  $supir
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validate = $this->validate($request, [
            'nama' => 'unique:supirs|max:255',
            'umur' => 'numeric|min:0',
            'alamat' => 'required',
            'status' => 'boolean'
        ]);
        $supir = Supir::find($id);

        if(!$supir) {
            return Response()->json([
                'status' => 'failed',
                'message' => 'data tidak ada'
            ], 400);
        }
        
        Supir::where('id', $id)->update([
            'nama' => $request->input('nama'),
            'umur' => $request->input('umur'),
            'alamat' => $request->input('alamat'),
            'status' => $request->input('status')
        ]);

        return Response()->json([
            'status' => 'success',
            'message' => 'data berhasil diubah',
            'data' => $request->all()
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supir  $supir
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supir = Supir::find($id);
        if(!$supir) {
            return Response()->json([
                'status' => 'failed',
                'message' => 'data tidak ada'
            ], 404);
        }

        $supir->delete();

        return Response()->json([
            'status' => 'success',
            'message' => 'data berhasil dihapus'
        ]);
    }
}
