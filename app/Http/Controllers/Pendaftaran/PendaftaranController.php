<?php

namespace App\Http\Controllers\Pendaftaran;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class PendaftaranController extends Controller
{
    public function store(Request $request)
    {

        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telepon' => 'required|numeric',
        ]);

        $requestData = $request->except('_token');

        if (isset($requestData['id'])) {
            $pendaftaran = Pendaftaran::findOrFail($requestData['id']);
            $pendaftaran->update($requestData);
            $message = 'Data berhasil diupdate!';
        } else {
            Pendaftaran::updateOrCreate(
                ['nama' => $requestData['nama']],
                $requestData
            );
            $message = 'Data berhasil disimpan!';
        }
        Session::flash('success', $message);
        return redirect()->route('pendaftaran.create');
    }
    public function storeNew(Request $request)
    {
        Pendaftaran::create($request->all());
        Session::flash('success', 'Data baru berhasil ditambahkan!');
        return redirect()->route('pendaftaran.create');
    }

    public function index(Request $request)
    {
        $pendaftaran = Pendaftaran::paginate(5);
        if ($request->ajax()) {
            $data = Pendaftaran::latest()->get();

            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('pendaftaran.show', $row->id) . '" class="btn btn-info btn-sm">Details</a>';
                    $btn .= '<a href="' . route('pendaftaran.edit', $row->id) . '" class="btn btn-warning btn-sm">Edit</a>';
                    $btn .= '<form action="' . route('pendaftaran.destroy', $row->id) . '" method="post" class="d-inline">
                               ' . csrf_field() . '
                               ' . method_field('DELETE') . '
                               <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure?\')">Delete</button>
                           </form>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pendaftaran.index', compact('pendaftaran'));
    }

    public function show($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        return view('pendaftaran.show', compact('pendaftaran'));
    }

    public function edit($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        return view('pendaftaran.edit', compact('pendaftaran'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telepon' => 'required|numeric',
        ]);

        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->update($request->all());

        Session::flash('success', 'Data berhasil diupdate!');
        return redirect()->route('pendaftaran.index');
    }

    public function destroy($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->delete();

        Session::flash('success', 'Data berhasil dihapus!');
        return redirect()->route('pendaftaran.index');
    }

    public function create()
    {
        $pendaftaran = Pendaftaran::all();
        return view('pendaftaran.create', compact('pendaftaran'));
    }
}
