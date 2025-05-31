<?php

namespace App\Services;

use App\Repositories\Interfaces\EmailRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmailService
{
    protected $emailRepository;

    public function __construct(EmailRepositoryInterface $emailRepository)
    {
        $this->emailRepository = $emailRepository;
    }

    /**
     * @throws \Exception
     */

    public function getAll()
    {
        try {
            return $this->emailRepository->all();
        } catch (\Exception $exception) {
            throw new \Exception("Error fetching emails: " . $exception->getMessage());
        }
    }

    /**
     * @throws \Exception
     */
    public function getEmailByReceiver($receiver)
    {
        $validate = Validator::make(
            ['receiver' => $receiver],
            ['receiver' => 'required|email']
        );

        if ($validate->fails()) {
            throw new \Exception("Invalid email");
        }

        return $this->emailRepository->findByReceiver($receiver);

    }

    /**
     * @throws \Exception
     */
    public function create(array $data)
    {
        $validate = Validator::make(
            $data,
            [
                'receiver' => 'required|email',
                'subject' => 'required|string|max:255',
                'body' => 'required|string',
            ]
        );

        if ($validate->fails()) {
            throw new \Exception("Validation failed: " . implode(", ", $validate->errors()->all()));
        }

        return $this->emailRepository->create($data);
    }

}
