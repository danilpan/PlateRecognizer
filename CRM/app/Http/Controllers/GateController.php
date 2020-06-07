<?php

namespace App\Http\Controllers;

use App\Models\Gate;
use App\Models\Office;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class GateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $gates = Gate::all();

        return view('gates.index')->with('gates', $gates);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        $offices = Office::all();

        return view('gates/create', compact('offices', $offices));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required',
            'client_hash' => 'required',
            'office_id'   => 'required|integer',
        ]);
        $request->offsetSet('client_hash', md5($request->get('client_hash')));
        Gate::create($request->all());
        $request->session()->flash('Successfully created gate!');

        return Redirect::to(route('gates.index'));
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
        $gate = Gate::find($id);

        return view('gates.show')
            ->with('gate', $gate);
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
        $gate    = Gate::find($id);
        $offices = Office::all();

        $view = view('gates.edit')->with('gate', $gate)->with('offices', $offices);

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
            'name'        => 'required',
            'client_hash' => 'required',
            'office_id'   => 'required|integer',
        ]);
        $request->offsetSet('client_hash', md5($request->get('client_hash')));

        $gate = Gate::find($id);
        $gate->update($request->all());

        $request->session()->flash('Successfully updated gate!');

        return Redirect::to('gates');
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
