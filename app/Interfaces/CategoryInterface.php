<?php

namespace App\Interfaces;

interface CategoryInterface
{
    public function datatable($orderBy,$direction,$columns,$skip,$take,$search);

    public function store(array $data);

    public function edit(int $id);

    public function update(int $id,array $data);

    public function destroy(int $id);
}

