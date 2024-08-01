<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.pages.contacts.index', get_defined_vars());
    }



    public function list(Request $request)
    {
        $data = Contact::with('doner')->select('*');
        return DataTables::of($data)
            ->addIndexColumn()
             ->editColumn('doner', function ($item) {
                 return $item->doner ? $item->doner->name : '';
             })

            ->rawColumns(['phone'])
            ->make(true);
    }



}
