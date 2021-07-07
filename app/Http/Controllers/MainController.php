<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\User;
use App\ExpenseCategory;
use App\Expense;
use Validator;
use Auth;
use Hash;
class MainController extends Controller
{
    public function index(){
    	$this->data['title'] = 'Dashboard';
    	return view('body.index')->with($this->data);
    }


    public function login(Request $request){

    	$credentials = $request->only('email', 'password');

    	if(Auth::attempt($credentials)){
    		return $this->getCurrentUser();
    	}else{
    		return response()->json(['message' => 'Invalid Credentials'],205);
    	}
    	
    }

    public function getUserRole($user){
    	$user->role = Role::find($user->role_id);

    	return $user;
    }

    public function getCurrentUser(){
    	if(Auth::check()){
    		return response()->json($this->getUserRole(Auth::user()),200);
    	}
    	return response()->json(['msg' => 'Invalid Credentials'],205);
    }

    public function logout(){

    	if(Auth::check()){
    		Auth::logout();

    		return response()->json();
    	}
  
    }

    public function getRoles(){
    	$roles = Role::all();

    	return response()->json($roles);
    }

    public function getRolesById($user_id){
        $user = User::find($user_id);
        $user->role = Role::find($user->role_id);

        return $user;
    }

    public function saveRole(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error', 
                'message' => $validator->errors()->all()]);
        }

        if($request->id != 0){
            $role = Role::find($request->id);
            $temp = 1;
        }else{
            $role = new Role;
            $temp = 0;
        }

        $role->type = $request->name;
        $role->description = $request->description;


        $role->save();

        return response()->json(['role' =>$role,'temp'=>$temp],200);
    }

    public function getExpenseCat(){
    	$expense_cats = ExpenseCategory::all();

    	return response()->json($expense_cats);
    }

     public function getCategoryById($cat_id){
    	$expense = Expense::find($cat_id);
    	$expense->expense_cat = ExpenseCategory::find($expense->expense_cat_id);

    	return $expense;
    }

    public function saveExpenseCat(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error', 
                'message' => $validator->errors()->all()]);
        }

    	if($request->id != 0){
    		$expense_cat = ExpenseCategory::find($request->id);
    		$temp = 1;
    	}else{
    		$expense_cat = new ExpenseCategory;
    		$temp = 0;
    	}

    	$expense_cat->name = $request->name;
    	$expense_cat->description = $request->description;


    	$expense_cat->save();

    	return response()->json(['expense_cat' =>$expense_cat,'temp'=>$temp],200);
    }

    public function getUser(){
        $users = User::all();
        $users->map(function($data){
            $data->role = Role::find($data->role_id);

            return $data;
        });

        return response()->json($users);
    }


    public function saveUser(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'role_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error', 
                'message' => $validator->errors()->all()]);
        }

    	if($request->id != 0){
    		$user = User::find($request->id);
    		$temp = 1;
    	}else{
    		$user = new User;
    		$temp = 0;
    	}

    	$user->name = $request->name;
    	$user->email = $request->email;
    	$user->password = !empty($request->password) ? bcrypt($request->password) : $user->password;
    	$user->role_id = $request->role_id;

    	$user->save();
    	return response()->json(['user' =>$this->getRolesById($user->id),'temp'=>$temp],200);
    }

    public function getExpense(){
        $user = $this->getRolesById(Auth::id());

        $expense = $user->role->name == 'admin' ? Expense::all() : Expense::where('user_id', Auth::id())->get();

        $expense->map(function($data){
            $data->expense_cat = ExpenseCategory::find($data->expense_cat_id);

            return $data;
        });
        return response()->json($expense);
   
    }


    public function saveExpense(Request $request){
        $validator = Validator::make($request->all(), [
            'amount' => 'required',
            'expense_cat_id' => 'required',
            'date' => 'required',
            
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error', 
                'message' => $validator->errors()->all()]);
        }


    	$id = $request->expense_id;

    	if($id != 0){
    		$expense = Expense::find($id);
    		$temp = 1;
    	}else{
    		$expense = new Expense;
    		$temp = 0;
    	}

    	$expense->amount_expense = $request->amount;
    	$expense->expense_cat_id = $request->expense_cat_id;
    	$expense->user_id = Auth::user()->id;
    	$expense->entry_date = $request->date;
    

    	$expense->save();
    	return response()->json(['expense' =>$this->getCategoryById($expense->id),'temp'=>$temp],200);
    }

    public function deleteExpense(Request $request){
    	return response()->json(Expense::find($request->id)->delete(),200);
    }

    public function deleteRole(Request $request){
    	return response()->json(Role::find($request->id)->delete(),200);
    }

    public function deleteUser(Request $request){
    	return response()->json(User::find($request->id)->delete(),200);
    }

    public function deleteExpenseCat(Request $request){
    	return response()->json(ExpenseCategory::find($request->id)->delete(),200);
    }

    

    public function changePassword(Request $request){
    	
    	if(Hash::check($request->current_password,Auth::user()->password)){

	    	$validate = [
				'new_password' => 'same:confirm_password',
			];

			$validator = Validator::make($request->all(), $validate);


	        if ($validator->fails()) {
	            return response()->json(['emsg' => $validator->getMessageBag()->toArray()],201);
	        }

	        Auth::user()->password = bcrypt($request->new_password);
	        Auth::user()->save();

	        return response()->json(['msg' => 'Successfully Change password'],200);

        }else{
        	return response()->json(['emsg' => 'current password does not match'],201);
        }
    }

    public function getChart(){
        $this->user = $this->getRolesById(Auth::id());
    	$expenses = ExpenseCategory::all();
	    	$expenses->map(function($expense){
                if($this->user->role->type == 'Admin'){
                    $expense->total = Expense::where('expense_cat_id', $expense->id)->pluck('amount_expense')->sum();
                }else{
                    $expense->total = Expense::where([['user_id', Auth::id()], ['expense_cat_id', $expense->id]])->pluck('amount_expense')->sum();
                }
	    		
	    	});

	    return response()->json($expenses);
    }
 
}


