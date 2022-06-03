<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;
use Exception;
use App\Models\User;
use Validator;
use JWTAuth;
use JWTFactory;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'fetch']]);
    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
    	$validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required|string|min:6',

        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (! $token = JWTAuth::attempt($validator->validated())) {
            return response()->json(['error' => 'incorrect username or password'], 401);
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
                    "password" => $vl['password']
                );
                // array_push($userdetails, $userdata);
            }
            $output = $userdetails;

        }
        //  print_r($output);
        // exit;

        $validator = Validator::make($request->all(), [
            'COMPANYWISEUSERSLIST.*.USERDETAILS.*.USERNAME' => 'required|unique:users,USERNAME,except,id',
            'COMPANYWISEUSERSLIST.*.COMPANYNAME' => 'required|string',
            'COMPANYWISEUSERSLIST.*.USERDETAILS.*.MOBILELOGINSTATUS' => 'required|string',
            'COMPANYWISEUSERSLIST.*.USERDETAILS.*.password' => 'required|string|confirmed|min:6',

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
                        'password' => Hash::make($vl['password'])
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
            'expires_in' => JWTFactory::getTTL() * 60,
            'user' => auth()->user()
        ]);
    }

    public function fetch()
    {
        $response = Http::get('http://192.168.30.126:8080/api/TallyUsers');
        $result = json_decode($response->body(), true);
        $output = (array) $result;
        $arr = json_decode($output[0], true);
    //    echo json_encode(array_values($arr['COMPANYWISEUSERSLIST']['USERDETAILS']));
    //     exit;
        foreach($arr as $key => $values){
            foreach($values['USERDETAILS'] as $key => $vl){
                $outputValues[] = array(
                    'COMPANYNAME' => $values['COMPANYNAME'],
                    "USERNAME" => $vl['USERNAME'],
                    "MOBILELOGINSTATUS" => $vl['MOBILELOGINSTATUS'],
                    "password" => '123456',
                );
            }
            $output_data = $outputValues;
        }

        // print_r($output_data);
        // exit;

        try
        {
            $validator = Validator::make($output_data, [
                'COMPANYWISEUSERSLIST.*.USERDETAILS.*.USERNAME' => [
                    'required',
                    Rule::unique('users'),
                ],
                'COMPANYWISEUSERSLIST.*.COMPANYNAME' => 'required|string',
                'COMPANYWISEUSERSLIST.*.USERDETAILS.*.MOBILELOGINSTATUS' => 'required|string',
                'COMPANYWISEUSERSLIST.*.USERDETAILS.*.password' => 'required|string|confirmed|min:6',

            ]);

            if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
            }


            foreach($output_data as $key => $val)
            {
                $user = User::create(array_merge(
                    $validator->validated(),

                    [
                        'USERNAME'=>$val['USERNAME'],
                        'COMPANYNAME'=>$val['COMPANYNAME'],
                        'MOBILELOGINSTATUS'=>$val['MOBILELOGINSTATUS'],
                        'password' => Hash::make(123456)
                    ]
                ));
            }
        }catch (\Exception $exception){
            return response()->json([
                'code' =>409,
                'message' => 'Duplicates entry for username, create new user'
            ]);
        }
        return response()->json([
            'message' => 'Successfully synchronized...'

        ], 201);
    }
}
