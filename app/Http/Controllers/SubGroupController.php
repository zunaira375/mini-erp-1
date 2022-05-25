<?php

namespace App\Http\Controllers;

use App\Models\SubGroup;
use Illuminate\Http\Request;

use Yajra\DataTables\Facades\DataTables;

class SubGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)

    {
        if ($request->ajax()) {
            $data = SubGroup::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {

                    //   $btn =  '<a href="/products/' . $data->id . '/edit" class="btn btn-primary"><i class="bi bi-pencil"></i></a>';
                    $btn = ' <a href="/subgroups/' . $data->id . '/edit"  class="btn btn-primary btn-md "><i class="fas fa-pen text-white"></i></a>';
                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->id . '" data-original-title="Delete" class="btn btn-danger btn-md deleteSubGroup"><i class="far fa-trash-alt text-white" data-feather="delete"></i></a>';

                    return $btn;
                })
                // ->editColumn('cat_id', function ($row) {
                //     return $row->category()->first()->name;
                // })
                ->rawColumns(['action'])->make(true);
        }

        return view('subgroups.index')
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('subgroups.index');
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
            $subgroup = SubGroup::find($id);
            $subgroup->name = $request->name;
            $subgroup->save();
            return redirect()->route('subgroups.index')
                ->with('success', 'subGroup updated successfully.');
        } else {
            //Perform Create
            $request->validate([
                'name' => 'required',
            ]);
            SubGroup::create($request->all());
        }

        return redirect()->route('subgroups.index')
            ->with('success', 'SubGroup created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SubGroup  $subGroup
     * @return \Illuminate\Http\Response
     */
    public function show(SubGroup $subgroup)
    {
        return view('subgroups.show', compact('subgroup'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SubGroup  $subGroup
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // return view('products.index', compact('product'));

        $subgroup = SubGroup::find($id);
        $subgroups = SubGroup::latest()->paginate(5);
        // $categories = Category::latest()->paginate(5);

        return view('subgroups.index', compact('subgroup', 'subgroups'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SubGroup  $subGroup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubGroup $subgroup)
    {
        $request->validate([

            'name' => 'required',
        ]);

        $subgroup->update($request->all());

        return redirect()->route('subgroups.index')
            ->with('success', 'subgroup updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubGroup  $subGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubGroup $subgroup)
    {
        $subgroup->delete();

        return redirect()->route('subgroups.index')
            ->with('success', 'Subgroup deleted successfully');
    }
}
