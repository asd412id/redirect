<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = auth()->user()->links();
            $dataTables =  DataTables::of($data)
                ->addColumn('action', function ($row) {

                    $btn = '<div class="table-actions">';

                    $btn .= ' <a href="' . route('link.edit', ['uuid' => $row->uuid]) . '" class="text-primary m-1" title="Ubah"><i class="fas fa-edit"></i></a>';

                    $btn .= ' <a href="' . route('link.destroy', ['uuid' => $row->uuid]) . '" class="text-danger m-1 confirm" data-text="Hapus ' . $row->name . '?" title="Hapus"><i class="fas fa-trash"></i></a>';

                    $btn .= '</div>';

                    return $btn;
                })
                ->rawColumns(['shortlink', 'active', 'case_sensitive', 'action'])
                ->make(true);

            if (!$request->get('order')) {
                $dataTable = $dataTables->order(function ($query) {
                    $query->orderBy('created_at', 'desc');
                });
            }

            return $dataTables;
        }
        return view('home');
    }

    public function profile()
    {
        $data = [
            'title' => 'Pengaturan Akun',
            'data' => auth()->user()
        ];

        return view('profile', $data);
    }

    public function profileUpdate(Request $r)
    {
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . (auth()->user()->id) . ',id',
            'old_password' => 'required',
        ];
        $msgs = [
            'name.required' => 'Nama tidak boleh kosong',
            'name.max' => 'Panjang nama tidak boleh lebih dari 255 karakter',
            'email.required' => 'Alamat email tidak boleh kosong',
            'email.max' => 'Panjang email tidak boleh lebih dari 255 karakter',
            'email.email' => 'Format alamat email tidak benar',
            'email.unique' => 'Alamat email sudah digunakan',
            'old_password.required' => 'Masukkan password untuk mengubah akun',
        ];

        if ($r->password) {
            $rules['password'] = 'confirmed|min:8';
            $msgs['password.confirmed'] = 'Perulangan password tidak benar';
            $msgs['password.min'] = 'Panjang password tidak boleh kurang dari 8 karakter';
        }

        $this->validate($r, $rules, $msgs);

        $user = auth()->user();

        $check = Hash::check($r->old_password, $user->password);

        if (!$check) {
            return redirect()->back()->withErrors('Password tidak benar!')->withInput();
        }

        $oldemail = $user->email;

        $user->name = $r->name;
        $user->email = $r->email;
        if ($r->password) {
            $user->password = bcrypt($r->password);
        }
        if ($oldemail != $r->email) {
            $user->email_verified_at = null;
            event(new Registered($user));
        }

        if ($user->save()) {
            return redirect()->route('profile')->with('status', 'Data akun berhasil diubah')->withInput();
        }
    }
}
