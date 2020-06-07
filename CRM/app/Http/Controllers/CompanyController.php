<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $companies = Company::all();

        return view('companies.index')->with('companies', $companies);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        return view('companies/create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'short_name'    => 'required',
            'official_name' => 'required',
        ]);

        Company::create($request->all());

        return Redirect::to(route('companies.index'));
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
        $company = Company::find($id);

        return view('companies.show')
            ->with('company', $company);
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
        $company = Company::find($id);

        return view('companies.edit', compact('company', $company));
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
            'short_name'    => 'required',
            'official_name' => 'required',
        ]);

        $company = Company::find($id);
        $company->update($request->all());

        $request->session()->flash('Successfully updated company!');

        return Redirect::to('companies');
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
