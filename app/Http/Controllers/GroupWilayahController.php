<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GroupWilayah;

class GroupWilayahController extends Controller
{
    public function index()
    {
        $groups = GroupWilayah::all();
        return view('group_wilayah.index', compact('groups'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_group_wilayah' => 'required|string|max:3|unique:group_wilayah',
            'nama_group_wilayah' => 'required|string|max:255',
            'kelurahan' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'koor_group_wilayah' => 'nullable|string|max:255',
        ]);

        GroupWilayah::create($request->all());
        return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_group_wilayah' => 'required|string|max:255',
            'kelurahan' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'koor_group_wilayah' => 'nullable|string|max:255',
        ]);

        $group = GroupWilayah::findOrFail($id);
        $group->update($request->all());

        return redirect()->back()->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        GroupWilayah::destroy($id);
        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }
}
