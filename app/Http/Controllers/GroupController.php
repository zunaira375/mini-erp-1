<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)

    {


        if ($request->ajax()) {
            $data = Group::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {

                    //   $btn =  '<a href="/products/' . $data->id . '/edit" class="btn btn-primary"><i class="bi bi-pencil"></i></a>';
                    $btn = ' <a href="/groups/' . $data->id . '/edit"  class="btn btn-primary btn-md "><i class="fas fa-pen text-white"></i></a>';
                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->id . '" data-original-title="Delete" class="btn btn-danger btn-md deleteGroup"><i class="far fa-trash-alt text-white" data-feather="delete"></i></a>';

                    return $btn;
                })
                // ->editColumn('cat_id', function ($row) {
                //     return $row->category()->first()->name;
                // })
                ->rawColumns(['action'])->make(true);
        }




        return view('groups.index')
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('groups.index');
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
            $group = Group::find($id);


            $group->name = $request->name;

            $group->pct_code = $request->pct_code;

            $group->save();

            // $product->categories()->attach($request->category);


            return redirect()->route('groups.index')
                ->with('success', 'Group updated successfully.');
        } else {


            //Perform Create
            $request->validate([
                'name' => 'required',
                'pct_code' => 'required',



            ]);
            Group::create($request->all());
        }

        return redirect()->route('groups.index')
            ->with('success', 'Group created successfully.');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        return view('groups.show', compact('group'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // return view('products.index', compact('product'));

        $group = Group::find($id);
        $groups = Group::latest()->paginate(5);


        // $categories = Category::latest()->paginate(5);

        return view('groups.index', compact('group', 'groups'))->with('i', (request()->input('page', 1) - 1) * 5);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        $request->validate([

            'name' => 'required',
            'pct_code' => 'required',



        ]);

        $group->update($request->all());

        return redirect()->route('groups.index')
            ->with('success', 'group updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        $group->delete();

        return redirect()->route('groups.index')
            ->with('success', 'group deleted successfully');
    }
}
