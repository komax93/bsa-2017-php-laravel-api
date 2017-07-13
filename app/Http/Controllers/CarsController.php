<?php

namespace App\Http\Controllers;

use App\Repositories\CarRepository;
use Illuminate\Http\Request;
use App\Car;

class CarsController extends Controller
{
    private $carRepository;

    public function __construct(CarRepository $carRepository)
    {
        $this->carRepository = $carRepository;
    }

    public function index()
    {
        // First option
        /*return response()->json(

            $this->carRepository->getAll()->map(function($item) {
                return collect($item)->only(['id', 'model', 'year', 'color', 'price']);
            })

        );*/


        // Second option
        return response()->json(

            $this->carRepository->getAll()->map(function(Car $car) {
                return [
                    'id' => $car->getId(),
                    'model' => $car->getModel(),
                    'color' => $car->getColor(),
                    'year' => $car->getYear(),
                    'price' => $car->getPrice()
                ];
            })

        );
    }

    public function show($id)
    {
        if(empty($car = $this->carRepository->getById($id))) {
            return abort(404);
        }

        return response()->json([
            'id' => $car->getId(),
            'model' => $car->getModel(),
            'color' => $car->getColor(),
            'year' => $car->getYear(),
            'mileage' => $car->getMileage(),
            'registration_number' => $car->getRegistrationNumber(),
            'price' => $car->getPrice()
        ]);
    }
}