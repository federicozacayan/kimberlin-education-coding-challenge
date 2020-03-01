<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\EventData;
use App\EventDate;
use App\Booking;
use Illuminate\Support\Facades\Auth;
use Validator;

/**
 * Class UserController
 * @author Federico Zacayan <federico.zacayan@gmail.com>
 * @package App\Http\Controllers\API
 */
class UserController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function login() {
        $params = [
            'email' => request('email'),
            'password' => request('password')
        ];
        if (Auth::attempt($params)) {
            $user = Auth::user();
            $success['token'] = $user->createToken('MyApp')->accessToken;
            return response()->json(['success' => $success], 200);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request) {
        $validator = Validator::make($request->all(),
        [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ], 401);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('MyApp')->accessToken;
        $success['name'] = $user->name;
        return response()->json(['success' => $success], 201);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function details() {
        $events = EventData::all();
        $dates = EventDate::all();
        return response()->json(
            [
                'success' => [
                    'events' => $events,
                    'dates' => $dates,
                    ]
            ], 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function booking(Request $request) {
        $user = Auth::user();
        $booking = Booking::insert(['users_id' => $user->id,
                'event_dates_id' => request('event_date') ]);
        return response()->json(['success' => $booking], 200);
    }
}
