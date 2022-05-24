<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

use Yajra\DataTables\Facades\DataTables;


class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)

    {


        if ($request->ajax()) {
            $data = Brand::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {

                    //   $btn =  '<a href="/products/' . $data->id . '/edit" class="btn btn-primary"><i class="bi bi-pencil"></i></a>';
                    $btn = ' <a href="/brands/' . $data->id . '/edit"  class="btn btn-primary btn-md "><i class="fas fa-pen text-white"></i></a>';
                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->id . '" data-original-title="Delete" class="btn btn-danger btn-md deleteBrand"><i class="far fa-trash-alt text-white" data-feather="delete"></i></a>';

                    return $btn;
                })
                // ->editColumn('cat_id', function ($row) {
                //     return $row->category()->first()->name;
                // })
                ->rawColumns(['action'])->make(true);
        }




        return view('brands.index')
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('brands.index');
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
            $brand = Brand::find($id);


            $brand->name = $request->name;


            $brand->save();

            // $product->categories()->attach($request->category);


            return redirect()->route('brands.index')
                ->with('success', 'Brand updated successfully.');
        } else {


            //Perform Create
            $request->validate([
                'name' => 'required',




            ]);
            Brand::create($request->all());
        }

        return redirect()->route('brands.index')
            ->with('success', 'brand created successfully.');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        return view('brands.show', compact('brand'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // return view('products.index', compact('product'));

        $brand = Brand::find($id);
        $brands = Brand::latest()->paginate(5);


        // $categories = Category::latest()->paginate(5);

        return view('brands.index', compact('brand', 'brands'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Brand $brand)
    {
        $request->validate([

            'name' => 'required',




        ]);

        $brand->update($request->all());

        return redirect()->route('brands.index')
            ->with('success', 'brand updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();

        return redirect()->route('brands.index')
            ->with('success', 'brand deleted successfully');
    }
}
