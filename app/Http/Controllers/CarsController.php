<?php

namespace App\Http\Controllers;

use App\Repositories\CarRepository;
use Illuminate\Http\Request;

class CarsController extends Controller
{
    private $carRepository;

    public function __construct(CarRepository $carRepository)
    {
        $this->carRepository = $carRepository;
    }

    public function index()
    {
        return response()->json(

            $this->carRepository->getAll()->map(function($item) {
                return collect($item)->only(['id', 'model', 'year', 'color', 'price']);
            })

        );
    }

    public function show($id)
    {

    }
}
