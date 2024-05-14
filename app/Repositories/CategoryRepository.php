<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Interfaces\CategoryInterface;

class CategoryRepository implements CategoryInterface
{
    protected $model,$request;

    public function __construct(Category $category,Request $request)
    {
        $this->model = $category;
        $this->request = $request;
    }

    public function datatable()
    {
        $orderBy = $this->request->order[0]['column'];
        $direction = $this->request->order[0]['dir'];

        $columns = ['id', 'name',];
        $skip = $this->request->start;
        $take = $this->request->length;
        $search = $this->request->search['value'];

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

    public function store($data)
    {
        $this->model->create($data);
    }

    public function edit($id)
    {
        return $this->model->find($id);
    }
}
