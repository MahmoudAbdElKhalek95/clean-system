<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\ClientUser;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {

        return view('admin.pages.users.index', get_defined_vars());
    }

    public function create()
    {
        $userRoles = [];
        return view('admin.pages.users.create_edit', get_defined_vars());
    }

    public function edit($id)
    {

        $item = User::findOrFail($id);
        $usersids=ClientUser::where('client_id', $item->id)->pluck('user_id')->toArray();
        $users= User::whereIn('id', $usersids)->get();
        $userRoles = $item->roles->pluck('id')->toArray();

        return view('admin.pages.users.create_edit', get_defined_vars());
    }

    public function show($id)
    {
        $item = User::findOrFail($id);
        return view('admin.pages.users.show', get_defined_vars());
    }

    public function destroy($id)
    {
        $item = User::where('id', '!=', auth()->id())->findOrFail($id);
        if ($item->delete()) {
            flash(__('users.messages.deleted'))->success();
        }
        return redirect()->route('users.index');
    }

    public function store(UserRequest $request)
    {
        if ($this->processForm($request)) {
            flash(__('users.messages.created'))->success();
        }
        return redirect()->route('users.index');
    }

    public function update(UserRequest $request, $id)
    {

        User::findOrFail($id);
        if ($this->processForm($request, $id)) {
            flash(__('users.messages.updated'))->success();
        }
        return redirect()->route('users.index');
    }

    protected function processForm($request, $id = null)
    {
        $item = $id == null ? new User() : User::find($id);
        $data= $request->except(['_token', '_method', 'password']);
        $item = $item->fill($data);

        if ($item->save()) {
            if ($request->filled('password')) {
                $item->password = Hash::make($request->password);
                $item->save();
            }
            $item->clients()->detach();
            $item->clients()->attach($request->user_id);

            $item->roles()->detach();
            if ($request->filled('role_id')) {
                $item->syncRoles([$request->role_id]);
            }
            return $item;
        }
        return null;
    }

    public function list(Request $request)
    {
        $usersids = [];
        if (session()->has('responsiveId')) {
            $usersids=ClientUser::where('user_id', session('responsiveId'))->pluck('client_id')->toArray();
        }
        $data = User::with('targettype')->where(function ($query) use ($usersids) {
            if (session()->has('responsiveId')) {
                $query->whereIn('id', $usersids);
            }
        })
        ->select('*');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('type', function ($item) {
                return __('users.types.' . $item->type);
            })
            ->addColumn('targettype', function ($item) {
                return $item->targettype ? $item->targettype->name : '';
            })

            ->rawColumns(['users','targettype'])
            ->make(true);
    }

    public function select(Request $request)
    {

        $data = User::distinct()
             ->where(function ($query) use ($request) {
                 if ($request->filled('q')) {
                     $query->where('first_name', 'LIKE', '%' . $request->q . '%');
                     $query->orWhere('mid_name', 'LIKE', '%' . $request->q . '%');
                     $query->orWhere('last_name', 'LIKE', '%' . $request->q . '%');
                 }
             })->where('type', User::TYPE_RESPONSIBLE)
             ->select('id', DB::raw("CONCAT(COALESCE(first_name,''),' ',COALESCE(mid_name,''),' ',COALESCE(last_name,'')) AS text"))
             ->get();
        return response()->json($data);
    }
    public function selectClient(Request $request)
    {

        $data = User::distinct()
             ->where(function ($query) use ($request) {
                 if ($request->filled('q')) {
                     $query->where('name', 'LIKE', '%' . $request->q . '%');
                 }
             })->where('type', User::TYPE_Supervisor)
             ->select('id', 'name as text')
              ->take(10)
             ->get();
        return response()->json($data);
    }

      protected function userpermission()
      {
          if(auth()->user()->type==User::TYPE_RESPONSIBLE) {
              flash(__('admin.messages.you_dont_have_permission'))->error();
              return back();
          }
      }

}
