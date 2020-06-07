<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Image;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'image' => ['image','mimes:jpeg,png,jpg,gif,svg','max:2048']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        $request = request();
        $user = new User();
        $user->name =  $request->get('name');
        $user->email =  $request->get('email');
        $user->password =  Hash::make($request->get('password'));
        if ($request->hasFile('image')) {
            // $imageName = time().'.'.$request->image->extension();  
            // $path = $request->file('image')->storeAs('public/images',$imageName);
            // Image::make($path)->resize(130, 100);   
            $avatar = $request->file('image');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            Image::make($avatar)->fit(100,100)->save(public_path('/storage/images/resized/user/'.$filename));
            Image::make($avatar)->save(public_path('/storage/images/user/'.$filename));
            $user->avatar = $filename;
        }
        // else{
        //     $user->avatar = $filename;
        // }
        $user->save();
        return $user;
        // if ($request->hasFile('image')) {
        //     $imageName = time().'.'.$request->image->extension();  
        //     $path = $request->file('image')->storeAs('public/images',$imageName);
        //     return User::create([
        //         'name' => $data['name'],
        //         'email' => $data['email'],
        //         'password' => Hash::make($data['password']),
        //         'avatar' => $imageName
        //     ]);
        // }else{
        //     return User::create([
        //         'name' => $data['name'],
        //         'email' => $data['email'],
        //         'password' => Hash::make($data['password']),
        //     ]);
        // }
    }
}
