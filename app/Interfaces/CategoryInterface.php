<?php

namespace App\Interfaces;

interface CategoryInterface
{
    public function datatable();

    public function store($data);

    public function edit($id);
}

