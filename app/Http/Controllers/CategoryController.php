<?php

namespace App\Http\Controllers;

use App\Interfaces\CategoryInterface;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class CategoryController extends Controller
{
    public $repo;
    public function __construct(CategoryInterface $interface)
    {
        $this->repo = $interface;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('categories.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            infoLogger('here');
            $data = [
                'name' => $request->name
            ];

            $this->repo->store($data);

            return successResponse(__('messages.category_created'), JsonResponse::HTTP_CREATED);

        } catch (Throwable $th) {
            errorLogger('CategoryController@store', $th);
            return failureResponse($th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }
}
