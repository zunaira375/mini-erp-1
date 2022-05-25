<?php

namespace App\Http\Controllers;

use App\Models\CharOfAccounts;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ChartOfAccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)

    {
        if ($request->ajax()) {
            $data = CharOfAccounts::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {

                    //   $btn =  '<a href="/customers/' . $data->id . '/edit" class="btn btn-primary"><i class="bi bi-pencil"></i></a>';
                    $btn = ' <a href="/chartofaccounts/' . $data->id . '/edit"  class="btn btn-primary btn-md "><i class="fas fa-pen text-white"></i></a>';
                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->id . '" data-original-title="Delete" class="btn btn-danger btn-md deleteAccounts"><i class="far fa-trash-alt text-white" data-feather="delete"></i></a>';

                    return $btn;
                })

                ->rawColumns(['action'])->make(true);
        }

        return view('chartofaccounts.index')
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('chartofaccounts.index');
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
            $account = CharOfAccounts::find($id);
            $account->account_name = $request->account_name;
            $account->account_type = $request->account_type;
            $account->is_parent = $request->is_parent;
            $account->parent_account_id = $request->parent_account_id;

            $account->save();
            return redirect()->route('chartofaccounts.index')
                ->with('success', 'Accounts updated successfully.');
        } else {
            //Perform Create
            $request->validate([
                'account_name' => 'required',
                'account_type' => 'required',
                'is_parent' => 'required',
                'parent_account_id' => 'required',
            ]);
            CharOfAccounts::create($request->all());
        }

        return redirect()->route('chartofaccounts.index')
            ->with('success', 'Account created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CharOfAccounts  $charOfAccounts
     * @return \Illuminate\Http\Response
     */
    public function show(CharOfAccounts $chartOfAccounts)
    {
        return view('chartofaccounts.show', compact('chartOfAccounts'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CharOfAccounts  $charOfAccounts
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // return view('products.index', compact('product'));
        $chartOfAccount = CharOfAccounts::find($id);
        $chartOfAccounts = CharOfAccounts::latest()->paginate(5);
        return view('chartofaccounts.index', compact('chartofAccount', 'chartofAccounts'))->with('i', (request()->input('page', 1) - 1) * 5);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CharOfAccounts  $charOfAccounts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CharOfAccounts $chartOfAccount)
    {
        $request->validate([
            'account_name' => 'required',
            'account_type' =>  'required|regex:/(01)[0-9]{09}/',
            'is_parent' => 'required',
            'parent_account_id' => 'required',
        ]);

        $chartOfAccount->update($request->all());

        return redirect()->route('chartofaccounts.index')
            ->with('success', 'Account updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CharOfAccounts  $charOfAccounts
     * @return \Illuminate\Http\Response
     */
    public function destroy(CharOfAccounts $chartOfAccounts)
    {
        $chartOfAccounts->delete();
        return redirect()->route('chartofaccounts.index')
            ->with('success', 'Account deleted successfully');
    }
}
