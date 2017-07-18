<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\CarRepository;
use App\Car;

class AdminController extends Controller
{
    /**
     * @var CarRepository
     */
    protected $carRepository;

    /**
     * AdminController constructor.
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result = $request->all();

        return $this->carRepository->addItem(new Car($result));
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(empty($carArray = $this->carRepository->getById($id))) {
            return response()->json(['error' => 'car not found'], 404);
        }

        $carArray = $carArray->toArray();
        $requestArray = $request->toArray();

        foreach($requestArray as $key => $value) {
            $carArray[$key] = $value;
        }

        return $this->carRepository->update(new Car($carArray));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(empty($carArray = $this->carRepository->getById($id))) {
            return response()->json(['error' => 'car not found'], 404);
        }

        return $this->carRepository->delete($id);
    }
}
