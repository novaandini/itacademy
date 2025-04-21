<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;


// inheritance (semua controller turunan dari class Controller, dimana semuanya itu memiliki AuthorizesRequest dan ValidateRequest)
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
