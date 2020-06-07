<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Office;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class OfficeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $offices = Office::all();

        return view('offices.index')->with('offices', $offices);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        $companies = Company::all();

        return view('offices/create', compact('companies', $companies));
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_address' => 'required',
            'company_id'   => 'required',
        ]);

        Office::create($request->all());
        $request->session()->flash('Successfully created office!');

        return Redirect::to(route('offices.index'));
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
        $office = Office::find($id);

        return view('offices.show')
            ->with('office', $office);
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
        $office    = Office::find($id);
        $companies = Company::all();

        $view = view('offices.edit')->with('office', $office)->with('companies', $companies);

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
            'full_address' => 'required',
            'company_id'   => 'required',
        ]);

        $office = Office::find($id);
        $office->update($request->all());

        $request->session()->flash('Successfully updated office!');

        return Redirect::to('offices');
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
