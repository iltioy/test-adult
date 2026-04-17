<?php

declare(strict_types=1);

namespace App\Controllers;

class ErrorController extends BaseController
{
    public function show404(): void
    {
        $this->notFound();
    }
}
