<?php

namespace App\Http\Controllers\Backend;

use App\Models\News;
use Illuminate\Support\Str;
use App\Models\CategoryNews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class NewsAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'data' => News::all(),
        ];
        return view('pages.backend.news.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(CategoryNews $categoryNews)
    {
        $data = [
            'data' => null,
            'category' => $categoryNews->all(),
        ];
        return view('pages.backend.news.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, News $news)
    {
        DB::beginTransaction();
        try {
            $image = null;

            if ($request->file('file') != "") {
                $file = $request->file('file');
                $fileName = 'news_' .time() . '.' . $file->getClientOriginalExtension();
                $path = $request->file('file')->storeAs('news', $fileName, 'public');
                $image = Storage::url($path);
            }

            $slug = Str::slug($request->title);

            // Periksa apakah slug sudah ada di database
            $originalSlug = $slug; // Simpan slug awal
            $count = 1;

            while ($news::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $count;
                $count++;
            }

            $formdata = [
                'title' => $request->title,
                'slug' => $slug,
                'category_id' => $request->category_id,
                'date' => $request->date,
                'content' => $request->content,
                'image' => $image,
                'caption' => $request->caption,
                'tags' => $request->tags,
                'keyword' => $request->keyword,
                'hit' => $request->hit,
                'status' => $request->status
            ];

            $news->create($formdata);

            DB::commit();
            return redirect()->route('admin.news.index')->with('success', 'Data successfully created!');

        } catch (\Throwable $th) {

            // Hapus file yang sudah diupload jika terjadi error
            if (file_exists('../public_html/' . $image)) {
                unlink($image);
            }

            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        } catch (\Exception $th) {
            // Hapus file yang sudah diupload jika terjadi error
            if (file_exists('../public_html/' . $image)) {
                unlink($image);
            }

            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file = $request->file('image');
            $fileName = 'news_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('news', $fileName, 'public'); // Save to 'storage/app/public/uploads'
            $url = Storage::url($path); // Generate public URL for the image

            return response()->json(['success' => true, 'url' => $url]);
        }

        return response()->json(['success' => false, 'message' => 'Image upload failed.'], 400);
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news, $id, CategoryNews $categoryNews)
    {
        $data = [
            'data' => $news->find($id),
            'category' => $categoryNews->all(),
        ];
        return view('pages.backend.news.form', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, News $news, $id)
    {
        DB::beginTransaction();
        try {
            $data = $news->find($id);
            $image = $data->image;

            if ($request->file('file') != "") {
                $oldFile = '../public_html/' . $image;
                if (file_exists($oldFile)) {
                    unlink($oldFile);
                }

                $file = $request->file('file');
                $fileName = 'news_' .time() . '.' . $file->getClientOriginalExtension();
                $path = $request->file('file')->storeAs('news', $fileName, 'public');
                $image = Storage::url($path); // Hasil: '/storage/thumbnails/thumbnail.jpg'
            }

            if ( $data->title == $request->title ) {
                $slug = $data->slug;
            } else {
                $slug = Str::slug($request->title);
    
                // Periksa apakah slug sudah ada di database
                $originalSlug = $slug; // Simpan slug awal
                $count = 1;
    
                while ($news::where('slug', $slug)->exists()) {
                    $slug = $originalSlug . '-' . $count;
                    $count++;
                }
            }

            $formdata = [
                'title' => $request->title,
                'slug' => $slug,
                'category_id' => $request->category_id,
                'date' => $request->date,
                'content' => $request->content,
                'image' => $image,
                'caption' => $request->caption,
                'tags' => $request->tags,
                'keyword' => $request->keyword,
                'hit' => $request->hit,
                'status' => $request->status
            ];

            $news->where('id', '=', $id)->update($formdata);

            DB::commit();
            return redirect()->route('admin.news.index')->with('success', 'Data successfully updated!');

        } catch (\Throwable $th) {

            // Hapus file yang sudah diupload jika terjadi error
            if (file_exists('../public_html/' . $image)) {
                unlink($image);
            }

            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        } catch (\Exception $th) {
            // Hapus file yang sudah diupload jika terjadi error
            if (file_exists('../public_html/' . $image)) {
                unlink($image);
            }

            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news, $id)
    {
        DB::beginTransaction();
        try {
            $file = $news->find($id)->image;
            $image = '../public_html/' . $file;
            if (file_exists($image)) {
                unlink($image);
            }
            $news->where('id', '=', $id)->delete();

            DB::commit();
            return redirect()->route('admin.news.index')->with('success', 'Data successfully deleted!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        } catch (\Exception $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
