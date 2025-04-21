<?php

namespace App\Http\Controllers\Backend;

use App\Models\CategoryNews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CategoryNewsAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'data' => CategoryNews::all(),
        ];
        return view('pages.backend.category_news.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'data' => null
        ];
        return view('pages.backend.category_news.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, CategoryNews $categoryNews)
    {
        DB::beginTransaction();
        try {
            $title = ucwords(trim($request->title));
            $formdata = [
                'title' => $title,
            ];

            $categoryNews->create($formdata);

            DB::commit();
            return redirect()->route('admin.category.index')->with('success', 'Data successfully created!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage())->withInput();
        } catch (\Exception $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage())->withInput();
        };
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
    public function edit(string $id, CategoryNews $categoryNews)
    {
        $data = [
            'data' => $categoryNews->find($id),
        ];
        return view('pages.backend.category_news.form', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CategoryNews $categoryNews, string $id)
    {
        DB::beginTransaction();
        try {
            $formdata = [
                'title' => $request->title,
            ];
            $categoryNews->where('id', '=', $id)->update($formdata);

            DB::commit();
            return redirect()->route('admin.category.index')->with('success', 'Data successfully edited!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        } catch (\Exception $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, CategoryNews $categoryNews)
    {
        DB::beginTransaction();
        try {
            $categoryNews->where('id', '=', $id)->delete();

            DB::commit();
            return redirect()->route('admin.category.index')->with('success', 'Data successfully deleted!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        } catch (\Exception $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
