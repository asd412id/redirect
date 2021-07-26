<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Links;
use Validator;
use Str;

class LinksController extends Controller
{
  public function index()
  {
    return view('welcome');
  }

  public function goto($custom)
  {
    $link = Links::where(function ($q) use ($custom) {
      $q->where(\DB::raw('BINARY `shortlink`'), Str::titleSlug($custom))
        ->where('case_sensitive', 1);
    })->orWhere(function ($q) use ($custom) {
      $q->where('shortlink', Str::titleSlug($custom))
        ->where('case_sensitive', 0);
    })->first();
    if ($link) {
      if (!$link->active) {
        return view('goto', [
          'title' => $link->name,
          'data' => $link,
        ]);
      }
      $link->hits += 1;
      $link->save();
      return redirect($link->destination, 302);
    }
    return response()->view('goto', [
      'title' => 'Link tidak ditemukan'
    ])->setStatusCode(404);
  }

  public function create()
  {
    $data = [
      'title' => 'Link Baru'
    ];

    return view('links.create', $data);
  }

  public function generate($length = 5, $count = 1)
  {
    $slug = Str::random($length);
    $cek = Links::where(\DB::raw('BINARY `shortlink`'), $slug)->first();
    if ($cek) {
      if ($count == ($length * 62)) {
        $length++;
      }
      $count++;
      return $this->generate($length, $count);
    }
    return $slug;
  }

  public function store(Request $r)
  {
    $role = [
      'destination' => 'required|url',
      'active' => 'required',
    ];
    $msgs = [
      'destination.required' => 'Link Tujuan tidak boleh kosong!',
      'destination.url' => 'Link Tujuan harus berupa url!',
      'active.required' => 'Status link tidak boleh kosong!',
    ];

    Validator::make($r->all(), $role, $msgs)->validate();

    $cek = Links::where(\DB::raw('BINARY `shortlink`'), Str::titleSlug($r->shortlink))->count();

    if ($cek || Str::titleSlug($r->shortlink) == 'signin' || Str::titleSlug($r->shortlink) == 'signup' || Str::titleSlug($r->shortlink) == 'login' || Str::titleSlug($r->shortlink) == 'register') {
      return redirect()->back()->withInput()->withErrors('Short link telah digunakan!');
    }

    $insert = new Links;
    $insert->uuid = Str::uuid();
    $insert->name = $r->name ?? $r->shortlink;
    $insert->shortlink = Str::titleSlug($r->shortlink ?? $this->generate());
    $insert->case_sensitive = $r->case_sensitive ?? false;
    $insert->destination = $r->destination;
    $insert->active = $r->active;
    $insert->user_id = auth()->user()->id;

    if ($insert->save()) {
      return redirect()->route('home')->with('status', 'Link berhasil ditambahkan!');
    }
    return redirect()->back()->withInput()->withErrors('Link gagal ditambahkan!');
  }

  public function edit($uuid)
  {
    $data = auth()->user()->links()->where('uuid', $uuid)->first();

    if (!$data) {
      return redirect()->route('home')->withErrors('Data tidak ditemukan!');
    }

    $data = [
      'title' => 'Ubah Link',
      'data' => $data
    ];

    return view('links.edit', $data);
  }

  public function update($uuid, Request $r)
  {
    $role = [
      'destination' => 'required|url',
      'active' => 'required',
    ];
    $msgs = [
      'destination.required' => 'Link Tujuan tidak boleh kosong!',
      'destination.url' => 'Link Tujuan harus berupa url!',
      'active.required' => 'Status link tidak boleh kosong!',
    ];

    Validator::make($r->all(), $role, $msgs)->validate();

    $cek = Links::where(\DB::raw('BINARY `shortlink`'), Str::titleSlug($r->shortlink))
      ->where('uuid', '!=', $uuid)
      ->count();

    if ($cek || Str::titleSlug($r->shortlink) == 'signin' || Str::titleSlug($r->shortlink) == 'signup' || Str::titleSlug($r->shortlink) == 'login' || Str::titleSlug($r->shortlink) == 'register') {
      return redirect()->back()->withInput()->withErrors('Short link telah digunakan!');
    }

    $insert = auth()->user()->links()->where('uuid', $uuid)->first();

    if (!$insert) {
      return redirect()->route('home')->withErrors('Data tidak ditemukan!');
    }

    $insert->name = $r->name ?? $r->shortlink;
    $insert->shortlink = Str::titleSlug($r->shortlink ?? $this->generate());
    $insert->case_sensitive = $r->case_sensitive ?? false;
    $insert->destination = $r->destination;
    $insert->active = $r->active;

    if ($insert->save()) {
      return redirect()->route('home')->with('status', 'Link berhasil diubah!');
    }
    return redirect()->back()->withInput()->withErrors('Link gagal diubah!');
  }

  public function destroy($uuid)
  {
    $link = auth()->user()->links()->where('uuid', $uuid)->first();

    if (!$link) {
      return redirect()->route('home')->withErrors('Data tidak ditemukan!');
    }

    if ($link->delete()) {
      return redirect()->route('home')->with('status', 'Link berhasil dihapus!');
    }
    return redirect()->back()->withInput()->withErrors('Link gagal dihapus!');
  }
}
