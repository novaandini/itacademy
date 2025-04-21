<?php

namespace App\Http\Controllers\Backend;

use App\Models\Menumanager;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MenumanagerAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'data' => Menumanager::all(),
        ];
        return view('pages.backend.menumanager.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'parent_id' => Menumanager::where('parent_id', '=', null)
        ];
        return view('pages.backend.menumanager.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Menumanager $menumanager)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menumanager $menumanager)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menumanager $menumanager)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menumanager $menumanager)
    {
        //
    }
}
