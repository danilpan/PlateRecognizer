<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Gate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Exception;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $cars = Car::all();

        return view('cars.index')->with('cars', $cars);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        $gates = Gate::all();

        return view('cars/create', compact('gates', $gates));
    }

    public function store(Request $request)
    {
        $request->validate([
            'plate_number' => 'required',
            'gates'        => 'required|array',
        ]);

        $request->offsetSet('client_hash', md5($request->get('client_hash')));
        try {
            Db::beginTransaction();
            $car = new Car();
            $car->setAttribute('plate_number', $request->get('plate_number'));
            $car->save();
            $car->createGates($request->get('gates'));
            Db::commit();
        } catch (Exception $exception) {
            Db::rollBack();
            throw $exception;
        }

        return Redirect::to(route('cars.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return View
     */
    public function show($id)
    {
        $car = Car::find($id);

        return view('cars.show')
            ->with('car', $car);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return View
     */
    public function edit($id)
    {
        $car   = Car::find($id);
        $gates = Gate::all();
        $gates = $gates->merge($car->gates);
        $view  = view('cars.edit')->with('car', $car)->with('gates', $gates);

        return $view;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'plate_number' => 'required',
            'gates'        => 'array',
        ]);
        try {
            Db::beginTransaction();

            $car = Car::find($id);
            $car->update($request->all());
            $car->updateGates($request->get('gates'));

            Db::commit();

            return Redirect::to('cars');
        } catch (Exception $exception) {
            Db::rollBack();
            $request->session()->flash('Successfully updated car!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
    }
}
