<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\ContractsModel;
use App\User;
use App\ShareModel;
use Session;
use SteamCondenser\Exceptions\SocketException;

class ContractsController extends Controller
{
    //
    public function allContracts(){
        $user_id = Auth::user()->id;
    	$contracts = ContractsModel::where('user_id' , $user_id)->orderBy('id' , 'DESC')->paginate(10);
        // echo "<pre>";
        // print_r($contracts);
        // echo "</pre>";die();
    	return view('dashboard.index' , compact('contracts'));
    }
    
    public function getAddContracts(){
    	return view('dashboard.add');
    }

    public function postAddContracts(Request $request){
    	// echo "<pre>";
    	// print_r($request->all());
    	// echo "</pre>";die();
        $this->validate($request , 
            [
                'name'        => 'required | min : 3 | max : 50 | unique:contracts,name',
                'description' => 'required | min : 3 | max : 100',
                'value'       => 'required | min : 3 | max : 500',
            ] , 
            [
                'name.required' => 'You must write name',
                'name.min'      => 'Lowest name is 3 characters',
                'name.max'      => 'Maximum name is 50 characters',
                'name.unique'   => 'Name already exists',

                'description.required'  => 'You must write description',
                'description.min'       => 'Lowest description is 3 characters',
                'description.max'       => 'Maximum description is 100 characters',

                'value.required' => 'You must write value',
                'value.min'      => 'Lowest value is 3 characters',
                'value.max'      => 'Maximum value is 500 characters',

            ]
        );

    	$contracts = new ContractsModel;
    	$contracts->name = $request->name;
    	$contracts->description = $request->description;
    	$contracts->value = $request->value;
        $contracts->user_id = Auth::user()->id;

        if (count(ContractsModel::all()) <= 0) {
            $contract_id = count(ContractsModel::all()) + 1;
            $contracts->contract_id = $contract_id;
        }else{
            $check_id = ContractsModel::find(DB::table('contracts')->max('id'));
            $contract_id = $check_id->id + 1;
            $contracts->contract_id = $contract_id;
        }

    	$contracts->save();
    	return redirect('/dashboard/all')->with('success' , 'add ok');
    }

    public function getEditContracts($id){
        $contracts = ContractsModel::find($id);
        if (empty($contracts)) {
            return view('dashboard.add');
        }
        // echo "<pre>";
        // print_r($contracts);
        // echo "</pre>";die();
        return view('dashboard.edit' , compact('contracts'));

    }

    public function postEditContracts(Request $request,$id){
        $this->validate($request , 
            [
                'name'        => 'required | min : 3 | max : 50',
                'description' => 'required | min : 3 | max : 100',
                'value'       => 'required | min : 3 | max : 500',
            ] , 
            [
                'name.required' => 'You must write name',
                'name.min'      => 'Lowest name is 3 characters',
                'name.max'      => 'Maximum name is 50 characters',

                'description.required'  => 'You must write description',
                'description.min'       => 'Min of description is 3 characters',
                'description.max'       => 'Maximum of description is 100 characters',

                'value.required' => 'You must write value',
                'value.min'      => 'Lowest value is 3 characters',
                'value.max'      => 'Maximum value is 500 characters',

            ]
        );

    	$contracts = ContractsModel::where('id' , $id)->update([
    		'name' => $request->name,
    		'description' => $request->description,
    		'value' => $request->value,
    	]);

    	return redirect('/dashboard/all')->with('success' , 'edit ok');
    	// echo "<pre>";
    	// print_r($contracts);
    	// echo "</pre>";die();
    	
    }

    public function getDeleteAllContracts(){
    	// ContractsModel::truncate();
        $user_id = Auth::user()->id;
        $contracts = ContractsModel::where('user_id' , $user_id)->lists('id')->toArray(); 

        if (empty($contracts)) {
            return redirect()->back()->withErrors('nothing to del');
        }
        $share  = ShareModel::whereIn('id_contracts' , $contracts)->lists('id')->toArray();
        if (!empty($share)) {
            ShareModel::destroy($share);
        }
        ContractsModel::destroy($contracts);
        return redirect()->back()->with('success' , 'delete all ok');
    }

    public function getDeleteContracts($id){
        $share = ShareModel::whereIn('id_contracts' , [$id])->lists('id')->toArray();
        if (!is_null($share)) {
            ShareModel::destroy($share);
        }
        $contracts = ContractsModel::find($id);
        if (empty($contracts)) {
            return redirect()->back()->withErrors('del fail');
        }
        $contracts->delete();
    	return redirect()->back()->with('success' , 'delete ok');
    }	

    public function postChoseContracts(Request $request){
        
        if ($request->delchose) {
            $checked = $request->input('checked' , []);

            if(empty($checked)){
                return redirect()->back()->withErrors('you must chose something');
            }   
            $share = ShareModel::whereIn('id_contracts' , $checked)->lists('id')->toArray();
            if (!is_null($share)) {
                ShareModel::destroy($share);
            }
            $delChose = ContractsModel::whereIn('id' , $checked)->delete();
            return redirect()->back()->with('success' , 'delete chose ok');

        }elseif($request->sendchose){
            $checked = $request->input('checked' , []);

            if(empty($checked)){
                return redirect()->back()->withErrors('you must chose something');
            }
            Session::put('sendchose' , json_encode($checked));
            return redirect('dashboard/sendmulty');

        }elseif($request->sharechose){

            $checked = $request->input('checked' , []);
            if(empty($checked)){
                return redirect()->back()->withErrors('you must chose something');
            }
            Session::put('sharechose' , json_encode($checked));
            return redirect('dashboard/sharemulty');
        }
    }

    public function getShareMultyContracts(){
        $current_user = Auth::user()->id;
        $user = User::orderBy('id' , 'DESC')->whereNotIn('id' , [$current_user])->get();

        return view('dashboard.sharemulty' , compact('user'));
    }

    public function postShareMultyContracts(Request $request){
        if (Session::has('sharechose')) {
            $id_contracts = json_decode(Session::get('sharechose'));
            Session::forget('sharechose');

            $id_user_receive = $request->checked;
            if (empty($id_user_receive)) {
                return redirect()->back()->withErrors('you must chose users');            
            }

            $share = [];
            if ($check_exist = ShareModel::whereIn('id_contracts' , $id_contracts)->get()) {

                $user_receive_exist = $check_exist->lists('id_user_receive')->toArray();
                $user_after = array_diff($id_user_receive, $user_receive_exist);
                foreach ($id_contracts as $id_C) {
                    foreach ($user_after as $key) {
                        $share[] = [
                            'id_contracts'    => $id_C,
                            'id_user_receive' => $key,
                            'id_user_send'    => Auth::user()->id,
                        ];
                    }
                }
            }
            // echo "<pre>";
            // print_r($share);
            // echo "</pre>";die();
            ShareModel::insert($share);
            return redirect('dashboard/all')->with('success' , 'share ok');
        }
        return redirect('dashboard/all')->withErrors('sendmulty fail');
    }

    public function getSendMultyContracts(){
        $current_user = Auth::user()->id;
        $user = User::orderBy('id' , 'DESC')->whereNotIn('id' , [$current_user])->get();

        return view('dashboard.sendmulty' , compact('user'));
    }

    public function postSendMultyContracts(Request $request){
        if (Session::has('sendchose')) {
            $id_contracts = json_decode(Session::get('sendchose'));
            Session::forget('sendchose');

            $share = ShareModel::whereIn('id_contracts' , $id_contracts)->lists('id')->toArray();
            if (!empty($share)) {
                ShareModel::destroy($share);
            }
            $contracts = ContractsModel::whereIn('id' , $id_contracts)->update([
                'user_id' => $request->id_users,
            ]);
            return redirect('dashboard/all')->with('success' , 'send ok');
        }
        return redirect('dashboard/all')->withErrors('send fail');
    }

    public function getSendContracts($id){
        $contracts = ContractsModel::find($id);
        if (empty($contracts)) {
            return redirect()->back()->withErrors('not found contracts'); 
        }
        $current_user = Auth::user()->id;
        $user = User::orderBy('id' , 'DESC')->whereNotIn('id' , [$current_user])->get();
        // echo "<pre>";
        // print_r($user);
        // echo "</pre>";die();
        return view('dashboard.send' , compact('contracts' , 'user'));
    }

    public function postSendContracts(Request $request , $id){
        $share = ShareModel::whereIn('id_contracts' , [$id])->lists('id')->toArray();
        // echo "<pre>";
        // print_r($share);
        // echo "</pre>";die();
        if (!empty($share)) {
            ShareModel::destroy($share);
        }
        $contracts = ContractsModel::where('id' , $id)->update([
            'user_id' => $request->id_users,
        ]);
        return redirect('dashboard/all')->with('success' , 'send ok');
        
    }
}
