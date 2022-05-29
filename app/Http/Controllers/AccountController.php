<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Validator;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = Account::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $btn = ' <a href="/accounts/' . $data->id . '/edit"  class="btn btn-primary btn-md "><i class="fas fa-pen text-white"></i></a>';
                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->id . '" data-original-title="Delete" class="btn btn-danger btn-md deleteAccount"><i class="far fa-trash-alt text-white" data-feather="delete"></i></a>';

                    return $btn;
                })
                ->editColumn('parent_id', function ($row) {
                    return $row->account_name;
                })
                ->rawColumns(['action'])->make(true);
        }
        $existing = null;
        $accounts = Account::where('is_parent', '=', true)->get();
        return view('accounts.index', compact('existing', 'accounts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('accounts.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'account_name' => 'required|max:120|min:3',
        ]);
        if ($request->input('account_type') == '0') {
            $validator->after(function ($validator) {
                $validator->errors()->add('account_type', 'Account Type Field is required');
            });
        }
        $is_parent = $request->has('is_parent') ? true : false;
        if ($is_parent == false) {
            if ($request->input('parent_id') == '0') {
                $validator->after(function ($validator) {
                    $validator->errors()->add('parent_id', 'Parent Account is Required');
                });
            }
        }
        if ($validator->fails()) {
            return redirect(route('accounts.index'))->withErrors($validator)->withInput();
        }
        if ($request->input('id')) {
            $id = $request->input('id');
            $existing = Account::find($id);
            if ($existing) {
                $existing->account_name = $request->input('account_name');
                $existing->account_type = $request->input('account_type');
                $existing->is_parent = $is_parent;
                $existing->parent_id = $request->input('parent_id');
                //  $existing->user_id = Auth::user()->id; //this->id;
                $existing->save();
            }
            return redirect(route('accounts.index'));
        }
        $account = new Account();
        $account->account_name = $request->input('account_name');
        $account->account_type = $request->input('account_type');
        $account->is_parent = $is_parent;
        $account->parent_id = $request->input('parent_id');
        //$account->user_id = Auth::user()->id; //this->id;
        $account->save();
        return redirect(route('accounts.index'));
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $existing = Account::find($id);
        $accounts = Account::where('is_parent', '=', true)->get();
        if ($existing) {
            return view('accounts.index', compact('existing', 'accounts'));
        }
        return "Error";
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $existing = Account::find($id);
        if ($existing) {
            $existing->delete();
            Account::where('parent_id', $id)->delete();
            return response()->json(['data' => true]);
        } else {
            return response()->json(['data' => false]);
        }
    }
}
