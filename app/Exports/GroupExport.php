<?php
namespace App\Exports;

use App\Models\User;
use App\Models\ClientUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

 class GroupExport implements FromView

{

    public function view(): View
    {


        ///////////////////////////////////
        $vip=User::where('vip', 1)->pluck('id')->toArray();
        $usersids=ClientUser::whereIn('user_id',$vip)->pluck('client_id')->toArray();
        $data = User::where(function ($query)  {
                if(request()->filled('first_name')){
                    $query->where('first_name','like','%'.request('first_name').'%');
                }
                if(request()->filled('mid_name')){
                    $query->where('mid_name','like','%'.request('mid_name').'%');
                }
                if(request()->filled('last_name')){
                    $query->where('last_name','like','%'.request('last_name').'%');
                }
            })
            ->where('type', User::TYPE_CLIENT)
            ->whereIn('users.id', $usersids)
            ->leftJoin('links', function ($query) {
                $query->on('links.user_id', 'users.id')
                    ->orWhere('links.code', 'users.code')
                    ;
            })
           // ->orderBy('links.total','DESC')
            ->groupBy('users.id' , 'users.mid_name' )
            ->select([DB::raw('count(links.id) as amount'), DB::raw('sum(links.total) as total'), 'users.mid_name','users.id as user_id'])
            ->orderByRaw('SUM(links.total) DESC')
            ->get();


            $map=[];
            $total_amount=0;
            $total=0;
            foreach($data as $row){
                $total_amount +=$row->amount;
                $total +=$row->total;
                $name=str_replace("مجمع ", "", $row->mid_name);
                $map[$name][] = [
                    'amount' => $row->amount,
                    'total' => $row->total
                ];
            }



        //////////////////////////////////////

        return view('admin.pages.reports.sallersGroup',['data'=>$map,'total_amount'=>$total_amount,'total_total'=>$total]);

    }



}
