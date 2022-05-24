<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)

    {


        if ($request->ajax()) {
            $data = Company::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {

                    //   $btn =  '<a href="/products/' . $data->id . '/edit" class="btn btn-primary"><i class="bi bi-pencil"></i></a>';
                    $btn = ' <a href="/companies/' . $data->id . '/edit"  class="btn btn-primary btn-md "><i class="fas fa-pen text-white"></i></a>';
                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->id . '" data-original-title="Delete" class="btn btn-danger btn-md deleteCompany"><i class="far fa-trash-alt text-white" data-feather="delete"></i></a>';

                    return $btn;
                })
                // ->editColumn('cat_id', function ($row) {
                //     return $row->category()->first()->name;
                // })
                ->rawColumns(['action'])->make(true);
        }




        return view('companies.index')
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('companies.index');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->get('id') != '') {
            //perform Edit
            $id = $request->get('id');
            $company = Company::find($id);


            $company->name = $request->name;

            $company->description = $request->description;

            $company->save();

            // $product->categories()->attach($request->category);


            return redirect()->route('companies.index')
                ->with('success', 'Company updated successfully.');
        } else {


            //Perform Create
            $request->validate([
                'name' => 'required',
                'description' => 'required',



            ]);
            Company::create($request->all());
        }

        return redirect()->route('companies.index')
            ->with('success', 'Company created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Company  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        return view('companies.show', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // return view('products.index', compact('product'));

        $company = Company::find($id);
        $companies = Company::latest()->paginate(5);


        // $categories = Category::latest()->paginate(5);

        return view('companies.index', compact('company', 'companies'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        $request->validate([

            'name' => 'required',
            'description' => 'required',



        ]);

        $company->update($request->all());

        return redirect()->route('companies.index')
            ->with('success', 'company updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        $company->delete();

        return redirect()->route('companies.index')
            ->with('success', 'company deleted successfully');
    }
}
