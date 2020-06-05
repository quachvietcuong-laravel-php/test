<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\ContractsModel;
use App\User;
use App\ShareModel;

class ShareController extends Controller
{
    //
    public function getShareContracts($id){
    	$current_user = Auth::user()->id;
        $user = User::orderBy('id' , 'DESC')->whereNotIn('id' , [$current_user])->get();
        $contracts = ContractsModel::find($id);

        return view('dashboard.share' , compact('user' , 'contracts'));
    }

    public function postShareContracts(Request $request , $id){
    	if ($contracts = ContractsModel::find($id)) {
            $totalUserRecive = $request->checked;
            
            if (empty($totalUserRecive = $request->checked)) {
                return redirect()->back()->withErrors('You are not chose any users');
            }
            // echo "<pre>";
            // print_r($totalUserRecive);
            // echo "</pre>";die();
	        $share = [];

            if ($check_exist = ShareModel::where('id_contracts' , $id)->get()) {

                $user_receive_exist = $check_exist->lists('id_user_receive')->toArray();
                $user_after         = array_diff($totalUserRecive, $user_receive_exist);

                if (empty($user_after)) {
                    return redirect('dashboard/all')->withErrors('User has this contracts already');
                }else{
                    foreach ($user_after as $key) {
                        $share[] = [
                            'id_contracts'    => $id,
                            'id_user_receive' => $key,
                            'id_user_send'    => Auth::user()->id,
                        ];
                    }
                    ShareModel::insert($share);
                    return redirect('dashboard/all')->with('success' , 'share ok');
                }
            }
    	}
   		return redirect('dashboard/all')->withErrors('Not found contracts');
    }

    public function getReceiveContracts(){
    	$current_user = Auth::user()->id;
    	$receive = ShareModel::orderBy('id' , 'DESC')->whereIn('id_user_receive' , [$current_user])->where('status' , 0)->paginate(10);
        // echo "<pre>";
        // print_r($receive);
        // echo "</pre>";die();
    	return view('dashboard.receive' , compact('receive'));
    }

    public function getShareShowContracts(){
        $current_user = Auth::user()->id;
        $share = ShareModel::orderBy('id' , 'DESC')->whereIn('id_user_send' , [$current_user])->paginate(10);
        // echo "<pre>";
        // print_r($share);
        // echo "</pre>";die();
        return view('dashboard.shareshow' , compact('share'));
    }

    public function getShareShowContractsHide($id){
        $hide = ShareModel::where('id' , $id)->update(['status' => 1]);
        return redirect()->back()->with('success' , 'Hide ok'); 
    }

    public function getShareShowContractsShow($id){
        $show = ShareModel::where('id' , $id)->update(['status' => 0]);
        return redirect()->back()->with('success' , 'Show ok'); 
    }

    public function postShareShowContracts(Request $request){
        $checked = $request->checked;
        if(empty($checked)){
            return redirect()->back()->withErrors('You must chose something');
        }else{
            if($request->hidechose){
                $check = ShareModel::whereIn('id' , $checked)->update(['status' => 1]);
                return redirect()->back()->with('success' , 'Hide chose ok'); 
            }elseif($request->showchose){
                $check = ShareModel::whereIn('id' , $checked)->update(['status' => 0]);
                return redirect()->back()->with('success' , 'Show chose ok'); 
            }
        }
    }
}
