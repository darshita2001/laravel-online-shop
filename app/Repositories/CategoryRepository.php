<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Exceptions\NotFoundException;
use App\Interfaces\CategoryInterface;

class CategoryRepository implements CategoryInterface
{
    protected $model, $request;

    public function __construct(Category $category, Request $request)
    {
        $this->model = $category;
        $this->request = $request;
    }

    public function datatable($orderBy,$direction,$columns,$skip,$take,$search)
    {
        $categories = $this->model->query()
            ->orderBy($columns[$orderBy], $direction)
            ->select($columns);

        $recordsTotal = $recordsFiltered = $categories->count();

        if ($search) {
            $categories = $categories->where('name', 'like', '%' . $search . '%');
        }

        $recordsFiltered = $categories->count();

        $categories = $categories
            ->skip($skip)
            ->take($take)
            ->get();

        return [
            'success' => true,
            'data' => $categories ?? [],
            'records_total' => $recordsTotal ?? null,
            'records_filtered' => $recordsFiltered ?? null,
        ];
    }

    public function store(array $data)
    {
        $this->model->create($data);
    }

    public function edit(int $id)
    {
        $category = $this->model->find($id);

        if(empty($category))
        {
            throw new NotFoundException(__('messages.category_not_found'));
        }

        return $category;
    }

    public function update(int $id, array $data)
    {
        $category = $this->model->find($id);

        if(empty($category))
        {
            throw new NotFoundException(__('messages.category_not_found'));
        }

        $category->update($data);

        return $category;
    }

    public function destroy(int $id)
    {
        $category = $this->model->find($id);

        if(empty($category))
        {
            throw new NotFoundException(__('messages.category_not_found'));
        }

        $category->delete();

    }
}
