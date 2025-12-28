<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CmsPage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CmsPageController extends Controller
{
    /**
     * Display a listing of CMS pages.
     */
    public function index()
    {
        return view('admin.cms_pages');
    }

    /**
     * Show the form for creating a new page.
     */
    public function create()
    {
        return view('admin.cms_page_form', ['page' => null]);
    }

    /**
     * Show the form for editing the specified page.
     */
    public function edit($id)
    {
        $page = CmsPage::findOrFail($id);
        return view('admin.cms_page_form', ['page' => $page]);
    }

    /**
     * API: Get all CMS pages.
     */
    public function apiIndex()
    {
        $pages = CmsPage::orderBy('sort_order')->orderBy('title')->get();
        return response()->json($pages);
    }

    /**
     * API: Get a single CMS page.
     */
    public function apiShow($id)
    {
        $page = CmsPage::findOrFail($id);
        return response()->json($page);
    }

    /**
     * API: Store a newly created page.
     */
    public function apiStore(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:cms_pages,slug',
            'content' => 'nullable|string',
            'show_in_footer' => 'boolean',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        $page = CmsPage::create($data);

        return response()->json($page, 201);
    }

    /**
     * API: Update the specified page.
     */
    public function apiUpdate(Request $request, $id)
    {
        $page = CmsPage::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:cms_pages,slug,' . $id,
            'content' => 'nullable|string',
            'show_in_footer' => 'boolean',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        $page->update($data);

        return response()->json($page);
    }

    /**
     * API: Remove the specified page.
     */
    public function apiDestroy($id)
    {
        $page = CmsPage::findOrFail($id);
        $page->delete();

        return response()->json(['message' => 'Page deleted successfully']);
    }

    /**
     * API: Get footer pages for frontend.
     */
    public function footerPages()
    {
        $pages = CmsPage::active()->footer()->get(['id', 'title', 'slug']);
        return response()->json($pages);
    }

    /**
     * Display a CMS page on the frontend.
     */
    public function showPage($slug)
    {
        $page = CmsPage::where('slug', $slug)->where('is_active', true)->firstOrFail();
        return view('page', ['page' => $page]);
    }
}
