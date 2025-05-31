<?php

namespace App\Repositories\Eloquent;

use App\Models\Email;
use App\Repositories\Interfaces\EmailRepositoryInterface;

class EmailRepository implements EmailRepositoryInterface
{
    public function all()
    {
        return Email::latest()->get();
    }

    public function find($id)
    {
        return Email::findOrFail($id);
    }

    public function findByReceiver($receiver)
    {
        return Email::where('receiver', $receiver)->get();
    }

    public function create(array $data)
    {
        return Email::create($data);
    }

    public function update($id, array $data)
    {
        $email = $this->find($id);
        $email->update($data);
        return $email;
    }

    public function delete($id)
    {
        $email = $this->find($id);
        $email->delete();
    }
}
