<?php

namespace App\Http\Controllers;

use App\Repositories\CarRepository;
use App\Car;

class CarsController extends Controller
{
    /**
     * @var CarRepository
     */
    protected $carRepository;

    /**
     * CarsController constructor.
     * @param CarRepository $carRepository
     */
    public function __construct(CarRepository $carRepository)
    {
        $this->carRepository = $carRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
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

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function show($id)
    {
        if(empty($car = $this->carRepository->getById($id))) {
            return response()->json(['error' => 'car not found'], 404);
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