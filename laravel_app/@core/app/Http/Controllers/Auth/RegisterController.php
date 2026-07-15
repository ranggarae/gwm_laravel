<?php

namespace App\Http\Controllers\Auth;

use App\Admin;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

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

    public function redirectTo(){
        return route('user.home');
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->middleware('guest:admin');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'account_type' => ['required', 'string', 'in:perorangan,perusahaan'],
            'phone' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
        ];

        if (isset($data['account_type']) && $data['account_type'] == 'perorangan') {
            $rules['nik'] = ['required', 'string', 'max:255'];
            $rules['ktp_image'] = ['required', 'file', 'mimes:jpeg,png,jpg', 'max:2048'];
            $rules['selfie_image'] = ['required', 'file', 'mimes:jpeg,png,jpg', 'max:2048'];
            $rules['sim_image'] = ['required', 'file', 'mimes:jpeg,png,jpg', 'max:2048'];
        }

        if (isset($data['account_type']) && $data['account_type'] == 'perusahaan') {
            $rules['company_name'] = ['required', 'string', 'max:255'];
            $rules['company_npwp'] = ['required', 'string', 'max:255'];
            $rules['company_nib'] = ['required', 'string', 'max:255'];
        }

        return Validator::make($data, $rules);
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $data = $request->all();

        // Handle File Uploads
        $upload_dir = 'assets/uploads/users';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        if ($request->hasFile('ktp_image')) {
            $ktp_image = $request->file('ktp_image');
            $ktp_image_name = time() . '_ktp.' . $ktp_image->getClientOriginalExtension();
            $ktp_image->move($upload_dir, $ktp_image_name);
            $data['ktp_image'] = $upload_dir . '/' . $ktp_image_name;
        }

        if ($request->hasFile('selfie_image')) {
            $selfie_image = $request->file('selfie_image');
            $selfie_image_name = time() . '_selfie.' . $selfie_image->getClientOriginalExtension();
            $selfie_image->move($upload_dir, $selfie_image_name);
            $data['selfie_image'] = $upload_dir . '/' . $selfie_image_name;
        }

        if ($request->hasFile('sim_image')) {
            $sim_image = $request->file('sim_image');
            $sim_image_name = time() . '_sim.' . $sim_image->getClientOriginalExtension();
            $sim_image->move($upload_dir, $sim_image_name);
            $data['sim_image'] = $upload_dir . '/' . $sim_image_name;
        }

        event(new \Illuminate\Auth\Events\Registered($user = $this->create($data)));

        $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function adminValidator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:admins'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
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
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'country' => $data['country'] ?? null,
            'city' => $data['city'] ?? null,
            'phone' => $data['phone'] ?? null,
            'address' => $data['address'] ?? null,
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'account_type' => $data['account_type'] ?? 'perorangan',
            'nik' => $data['nik'] ?? null,
            'ktp_image' => $data['ktp_image'] ?? null,
            'selfie_image' => $data['selfie_image'] ?? null,
            'sim_image' => $data['sim_image'] ?? null,
            'company_name' => $data['company_name'] ?? null,
            'company_npwp' => $data['company_npwp'] ?? null,
            'company_nib' => $data['company_nib'] ?? null,
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function createAdmin(Request $request)
    {
        $this->adminValidator($request->all())->validate();
        $admin = Admin::create([
            'name' => $request['name'],
            'username' => $request['username'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);
        return redirect()->route('admin.home');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('frontend.user.register');
    }

}
