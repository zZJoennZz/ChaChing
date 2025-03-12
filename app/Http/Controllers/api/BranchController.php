<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $user = Auth::user();
        if ($user->type !== "ADMIN" && $user->type !== "DEV") {
            return send401Response();
        }

        $branches = Branch::with('cluster')->get();
        return send200Response($branches);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        try {
            if ($request->clusters === 0 || $request->clusters === "0") {
                return send422Response('Please select a valid cluster!');
            }
            $request->validate([
                'name' => 'required',
            ]);

            DB::beginTransaction();
            $new_branches = new Branch();
            $new_branches->code = $request->code;
            $new_branches->name = $request->name;
            $new_branches->clusters_id = $request->clusters_id;
            $new_branches->save();
            DB::commit();

            return send200Response();
        } catch (\Exception $e) {
            DB::rollBack();
            return send400Response();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function get_branch_profile()
    {
        $user = Auth::user();

        if ($user->type !== "BRANCH_HEAD") {
            return send401Response();
        }

        $branch = Branch::find($user->branches_id);

        return send200Response($branch);
    }

    public function save_branch_details(Request $request)
    {
        $user = Auth::user();

        if ($user->type !== "BRANCH_HEAD") {
            return send401Response();
        }

        try {
            DB::beginTransaction();
            $branch = Branch::find($user->branches_id);
            $branch->agency_name = $request->agency_name;
            $branch->full_addressfull_address = $request->full_address;
            $branch->telephone_number = $request->telephone_number;
            $branch->email_address = $request->email_address;
            $branch->location_of_records = $request->location_of_records;
            $branch->save();
            DB::commit();
            return send200Response();
        } catch (\Exception $e) {
            DB::rollBack();
            return send400Response();
        }
    }
}
