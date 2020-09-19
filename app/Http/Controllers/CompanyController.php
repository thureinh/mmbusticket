<?php

namespace App\Http\Controllers;

use App\Company;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    use RegistersUsers;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::all()->map(function ($company) {
            $company->logo = url('storage/' . $company->logo);
            $company['url'] = url('companies');
            $company['user'] = $company->user;
            return $company;
        });
        return view('backend.company.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('backend.company.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $customAttributes = [
            'company_name' => 'Name of the Company',
        ];
        $request->validate([
            'image' => 'required|file|image',
            'company_name' => ['required', 'unique:companies,name'],//unique:table,column
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [], $customAttributes);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ]);
            $company = new Company;
            $company->logo = $request->file('image')->store('images/logos', 'public');
            $company->name = $request->input('company_name');
            $user->company()->save($company);
            $user->assignRole('company-manager');
        });
        return redirect()->route('companies.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        $company->logo = url('storage/' . $company->logo);
        $company['url'] = url('companies');
        $company['user'] = $company->user;
        return response()->json($company);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        $customAttributes = [
            'company_name' => 'Name of the Company',
        ];
        $validator = Validator::make($request->all(), [
            'company_name' => 'required',
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
        ], [], $customAttributes);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()]);
        } 
        else
        {
            DB::transaction(function () use ($request, $company) {
            $company->user->name = $request->input('name');
            $company->user->email = $request->input('email');
            if ($request->hasFile('image')) {
                Storage::disk('public')->delete($location->image);
                $company->logo = $request->file('image')->store('images/logos', 'public');  
            }
            $company->name = $request->input('company_name');
            $company->push();
            });
            $companies = Company::all()->map(function ($company) {
                $company->logo = url('storage/' . $company->logo);
                $company['url'] = url('companies');
                $company['user'] = $company->user;
                return $company;
            });
            return response()->json($companies);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        Storage::disk('public')->delete($company->image);
        DB::transaction(function () use ($company) {
            $company->user->delete();
            $company->delete();
        });
        $companies = Company::all()->map(function ($company) {
            $company->logo = url('storage/' . $company->logo);
            $company['url'] = url('companies');
            $company['user'] = $company->user;
            return $company;
        });
        return response()->json($companies);
    }
}
