<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;

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
  public function index()
  {
    if (request()->ajax()) {
      $data = auth()->user()->links()
      ->orderBy('created_at','desc');
      return DataTables::of($data)
      ->addColumn('shortlnk',function($row){
        return '<button class="btn badge badge-primary get-link" title="Salin Link">'.url($row->shortlink??"/").'</button>';
      })
      ->addColumn('stt',function($row){
        $status = '<span class="badge badge-danger">Tidak Aktif</span>';
        if ($row->active) {
          $status = '<span class="badge badge-success">Aktif</span>';
        }
        return $status;
      })
      ->addColumn('created',function($row){
        return $row->created_at->format('d/m/Y H:i:s');
      })
      ->addColumn('action', function($row){

        $btn = '<div class="table-actions">';

        $btn .= ' <a href="'.route('link.edit',['uuid'=>$row->uuid]).'" class="text-primary m-1" title="Ubah"><i class="fas fa-edit"></i></a>';

        $btn .= ' <a href="'.route('link.destroy',['uuid'=>$row->uuid]).'" class="text-danger m-1 confirm" data-text="Hapus '.$row->name.'?" title="Hapus"><i class="fas fa-trash"></i></a>';

        $btn .= '</div>';

        return $btn;
      })
      ->rawColumns(['shortlnk','stt','action'])
      ->make(true);
    }
    return view('home');
  }
}
