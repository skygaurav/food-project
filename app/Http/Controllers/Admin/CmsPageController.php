<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CmsPage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

/**
 * Controller for managing CMS pages in admin panel.
 *
 * Handles CRUD operations for content management system pages.
 *
 * @package App\Http\Controllers\Admin
 */
class CmsPageController extends Controller
{
    /**
     * Display a listing of CMS pages.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        return view('admin.cms_pages');
    }

    /**
     * Show the form for creating a new page.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        return view('admin.cms_page_form', ['page' => null]);
    }

    /**
     * Show the form for editing the specified page.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit(int $id): View
    {
        $page = CmsPage::findOrFail($id);

        return view('admin.cms_page_form', ['page' => $page]);
    }

    /**
     * API: Get all CMS pages.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiIndex(): JsonResponse
    {
        $pages = CmsPage::orderBy('sort_order')->orderBy('title')->get();

        return response()->json($pages);
    }

    /**
     * API: Get a single CMS page.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiShow(int $id): JsonResponse
    {
        $page = CmsPage::findOrFail($id);

        return response()->json($page);
    }

    /**
     * API: Store a newly created page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiStore(Request $request): JsonResponse
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
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiUpdate(Request $request, int $id): JsonResponse
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
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiDestroy(int $id): JsonResponse
    {
        $page = CmsPage::findOrFail($id);
        $page->delete();

        return response()->json(['message' => 'Page deleted successfully']);
    }

    /**
     * API: Get footer pages for frontend.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function footerPages(): JsonResponse
    {
        $pages = CmsPage::active()->footer()->get(['id', 'title', 'slug']);

        return response()->json($pages);
    }

    /**
     * Display a CMS page on the frontend.
     *
     * @param  string  $slug
     * @return \Illuminate\View\View
     */
    public function showPage(string $slug): View
    {
        $page = CmsPage::where('slug', $slug)->where('is_active', true)->firstOrFail();

        return view('page', ['page' => $page]);
    }
}
