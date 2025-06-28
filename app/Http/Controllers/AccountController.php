<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class AccountController extends Controller
{
    // show the view of register
    public function register()
    {
        return view('front.account.register');
    }
    // processing the register form
    public function processRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|same:confirm_password'
        ])->stopOnFirstFailure(true);
        if ($validator->passes()) {
            $user = new User();
            $user->name = $validator->getData()['name'];
            $user->email = $validator->getData()['email'];
            $user->password = Hash::make($validator->getData()['password']);
            $user->save();
            session()->flash('success', 'User Registered Successfully');
            return response([
                'status' => true,
                'content' => "Successfully Registered"
            ]);
        } else {
            return response([
                'status' => false,
                'content' => $validator->errors()
            ]);
        }
    }
    //  login method
    public function login()
    {
        return view('front.account.login');
    }
    // Process login
    public function processLogin(Request $request)
    {
        $validator = Validator::make($request->all() ,[
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);
        if ($validator->passes()) {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return redirect()->route('home');
            } else {
                return redirect()->route('account.login')->with('fail', 'Email or Password Don\'t Match');
            }
        } else {
            return redirect()
            ->route('account.login')
            ->withInput($request->only('email'))
            ->withErrors($validator);
        }
    }
    // open profile page
    public function profile()
    {
        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();
        // dd($user);
        return view('front.account.profile', [
            'user' => $user
        ]);
    }
    // logout function
    public function logout()
    {
        Auth::logout();
        return redirect()->route('account.login');
    }
    // update user profile
    public function updateProfile(Request $request)
    {
        $id = Auth::user()->id;
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:5|max:20',
            'email' => 'required|email|unique:users,email,'.$id.',id',
            'old_password' => 'required_with:password',
            'password' => 'min:8|same:confirm_password'
        ],
    [
        'required_with' => 'The :attribute is required',
        'exists' => 'The :attribute must match previous value'
    ]);
    $validator->after(function($validator) use ($request) {
        if ($request->filled('old_password')) {
            if (!Hash::check($request->old_password, Auth::user()->password)) {
                $validator->errors()->add('old_password',"The old password is Incorrect");
            }
        }
    });
        if ($validator->passes()) {
            // update profile
            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->designation = $request->designation;
            $user->mobile = $request->mobile;
            if ($user->update()) {
                session()->flash('success', "Successfully Updated Profile.");
            }

            return response([
                'status' => true,
                'errors' => [],
                'message' => "Successfully Updated The Values."
            ]);
        } else {
            return response([
                'status' => false,
                'errors' => $validator->errors(),
                'message' => "Please Enter The Values Carefully."
            ]);
        }
    }

    public function updateProfilePic(Request $request) {
        $validator = Validator::make($request->all(), [
            'image' => "required|image",
        ]);
        if ($validator->passes()) {
            $id = Auth::user()->id;
            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $img = $id . '-' . time() . '.' . $ext;


            // delete previous images
            if (File::exists(public_path('profile_pic/' . Auth::user()->image))) {
                File::delete(public_path('profile_pic/' . Auth::user()->image));
            }
            if (File::exists(public_path('profile_pic/thumb/' . Auth::user()->image))) {
                File::delete(public_path('profile_pic/thumb/' . Auth::user()->image));
            }




            $image->move(public_path('profile_pic/'), $img);
            // create new image instance (800 x 600)
            $manager = new ImageManager(Driver::class);
            $image = $manager->read(public_path('profile_pic/'.$img));


            // crop the best fitting 1:1 ratio (200x200) and resize to 200x200 pixel
            $image->cover(200, 200);
            $image->toPng()->save(public_path('profile_pic/thumb/'.$img));


            User::where('id', $id)->update([
                'image' => $img
            ]);
            return response([
                'status' => true,
                'errors' => []
            ]);
        } else {
            return response([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
}
