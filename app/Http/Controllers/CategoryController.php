<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use App\Interfaces\CategoryInterface;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use Illuminate\Http\Request;

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
        return view('categories.list');
    }

    /**
     * Get a listing of the resource.
     */
    public function datatable(Request $request)
    {
        try {
            $orderBy = $request->order[0]['column'];
            $direction = $request->order[0]['dir'];

            $columns = ['id', 'name',];
            $skip = $request->start;
            $take = $request->length;
            $search = $request->search['value'];

            $result = $this->repo->datatable(
                orderBy: $orderBy,
                direction: $direction,
                columns: $columns,
                skip: $skip,
                take: $take,
                search: $search
            );

            return response()->json([
                'success' => $result['success'],
                'data' => $result['data'],
                'recordsTotal' => $result['records_total'],
                'recordsFiltered' => $result['records_filtered'],
            ]);
        } catch (Throwable $e) {
            errorLogger('CategoryController@datatable', $e);
            return failureResponse($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryStoreRequest $request)
    {
        try {
            $data = [
                'name' => $request->name
            ];

            $this->repo->store($data);

            return successResponse(__('messages.category_created'), JsonResponse::HTTP_CREATED);
        } catch (Throwable $e) {
            errorLogger('CategoryController@store', $e);
            return failureResponse($e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        try {
            $data = $this->repo->edit($category->id);

            return successResponseWithData([$data], __('messages.category_retrieved'));
        } catch (Throwable $e) {
            errorLogger('CategoryController@edit', $e);
            return failureResponse($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryUpdateRequest $request, Category $category)
    {
        try {
            $data = [
                'name' => $request->name
            ];

            $this->repo->update($category->id, $data);

            return successResponseWithData([$data], __('messages.category_updated'));
        } catch (Throwable $e) {
            errorLogger('CategoryController@update', $e);
            return failureResponse($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try {
            $this->repo->destroy($category->id);

            return successResponse(__('messages.category_deleted'));
        } catch (Throwable $e) {
            errorLogger('CategoryController@delete', $e);
            return failureResponse($e->getMessage());
        }
    }
}
