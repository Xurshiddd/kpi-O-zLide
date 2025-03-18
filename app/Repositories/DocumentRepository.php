<?php

namespace App\Repositories;

use App\Models\Criterion;
use App\Models\Department;
use App\Models\Document;
use App\Models\User;

class DocumentRepository
{
    public function getAllUser()
    {
        $document = Document::where('user_id', auth()->id())->get();
        return $document;
    }

    public function save($data)
    {
        $document = Document::create($data);
        return $document;
    }
    public function update($data, $id)
    {

    }
    public function delete($id)
    {

    }

    public function getById($id)
    {
        $document = Document::find($id);
        return $document;
    }

    public function getByCritery()
    {
        $id = User::where('id', auth()->id())->first();
        return Criterion::where('department_id', $id->department->id)->get();
    }
}
