<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
    	$validator = Validator::make($request->all(), [
            'username' => 'required',
            'PASSWORD' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (! $token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->createNewToken($token);
    }
    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request) {
        $data = file_get_contents("php://input");
        $data_array = json_decode($data, true);

        foreach($data_array['COMPANYWISEUSERSLIST'] as $key=>$value1){
            $company = array(
                'COMPANYNAME' => $value1['COMPANYNAME'],
            );
            foreach($value1['USERDETAILS'] as $key => $vl){
                $userdetails[] = array(
                    'COMPANYNAME' => $value1['COMPANYNAME'],
                    "USERNAME" => $vl['USERNAME'],
                    "MOBILELOGINSTATUS" => $vl['MOBILELOGINSTATUS'],
                    "PASSWORD" => $vl['PASSWORD']
                );
                // array_push($userdetails, $userdata);
            }
            $output = $userdetails;

        }
        //  print_r($output);
        // exit;

        $validator = Validator::make($request->all(), [
            'COMPANYWISEUSERSLIST.*.USERDETAILS.*.USERNAME' => 'required|string',
            'COMPANYWISEUSERSLIST.*.COMPANYNAME' => 'required|string',
            'COMPANYWISEUSERSLIST.*.USERDETAILS.*.MOBILELOGINSTATUS' => 'required|string',
            'COMPANYWISEUSERSLIST.*.USERDETAILS.*.PASSWORD' => 'required|string',

        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        foreach($output as $key => $val){

        $user = User::create(array_merge(
                    $validator->validated(),

                    [
                        'USERNAME'=>$val['USERNAME'],
                        'COMPANYNAME'=>$val['COMPANYNAME'],
                        'MOBILELOGINSTATUS'=>$val['MOBILELOGINSTATUS'],
                        'PASSWORD' => bcrypt($request->PASSWORD)
                    ]
                ));
            }
        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile() {
        return response()->json(auth()->user());
    }
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }
}
