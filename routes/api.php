<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('auth/register', 'AuthController@register');
Route::post('auth/login', 'AuthController@login');
Route::group(['middleware' => 'jwt.auth'], function(){
	Route::get('auth/user', 'AuthController@user');
	Route::post('auth/logout', 'AuthController@logout');
});
Route::group(['middleware' => 'jwt.refresh'], function(){
	Route::get('auth/refresh', 'AuthController@refresh');
});

Route::post('password/email', 'Auth\ForgotPasswordController@getResetToken');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');


Route::get('/get-nimipet', function () {
    $user_id = JWTAuth::parseToken()->authenticate()->id;
    $nimipet = DB::table('nimipets')->where('user_id', '=', $user_id)->get();
    if (sizeof($nimipet) == 0) {
        return "first-login";
    }
    $nimipet[0]->current_time = date("Y-m-d H:i:s");

    //
    // Execute nimipet death (SAME as below)
    //
    if ($nimipet[0]->nimi_lastfed != null) {
        $hibernation = json_decode($nimipet[0]->nimi_meta);
        if ($hibernation[0] == "hibernation") {
            return $nimipet;
        }
        $unix_time = strtotime($nimipet[0]->current_time) - strtotime($nimipet[0]->nimi_lastfed);
        if ($unix_time > 86400) {
            $nimipet[0]->nimi_state = 'dead';

            // update deadlist table
            DB::table('deadlist')->insert([
                'user_id' => $user_id, 'nimi_name' => $nimipet[0]->nimi_name, 'nimi_points' => $nimipet[0]->nimi_points, 
                'nimi_value' => $nimipet[0]->nimi_value, 'timestamp' => date("Y-m-d H:i:s"), 'nimi_born' => $nimipet[0]->nimi_born,
                'food_eaten' => $nimipet[0]->food_eaten
            ]);

            // update nimipets table
            DB::table('nimipets')
            ->where('user_id', $user_id)
            ->update([
                'nimi_state' => 'dead', 
                'nimi_points' => 0,
                'nimi_lastfed' => null, 
                'nimi_value' => 0,
                'nimi_position' => 0, 
                'food_eaten' => 0, 
                'food_started' => null,
                'food_progress' => 0, 
                'food_today' => 0,
                'food_status' => null,
            ]);

            // update items table
            DB::table('items')
            ->where('nimi_id', $nimipet[0]->id)
            ->where('item', '!=', 'resurrection')
            ->update([
                'available' => 0
            ]);
            
			$nimipet = DB::table('nimipets')->where('user_id', '=', $user_id)->get();
            $nimipet[0]->current_time = date("Y-m-d H:i:s");
        }
    }

    return $nimipet;
});


Route::post('/get-nimi-pub', function (Request $request) {
    $nimi_slug = $request->nimi_slug;

    $nimipet = DB::table('nimipets')->where('nimi_slug', '=', $nimi_slug)->get();
    if (sizeof($nimipet) == 0) {
        return "first-login";
    }
    $nimipet[0]->current_time = date("Y-m-d H:i:s");
    $nimi_id = $nimipet[0]->id;
    $user_id = $nimipet[0]->user_id;

    //
    // Execute nimipet death (SAME as above)
    //
    if ($nimipet[0]->nimi_lastfed != null) {
        $hibernation = json_decode($nimipet[0]->nimi_meta);
        if ($hibernation[0] != "hibernation") {
            $unix_time = strtotime($nimipet[0]->current_time) - strtotime($nimipet[0]->nimi_lastfed);
            if ($unix_time > 86400) {
                $nimipet[0]->nimi_state = 'dead';

                // update deadlist table
                DB::table('deadlist')->insert([[
                    'user_id' => $user_id, 'nimi_name' => $nimipet[0]->nimi_name, 'nimi_points' => $nimipet[0]->nimi_points, 
                    'nimi_value' => $nimipet[0]->nimi_value, 'timestamp' => date("Y-m-d H:i:s"), 'nimi_born' => $nimipet[0]->nimi_born,
                    'food_eaten' => $nimipet[0]->food_eaten
                ]]);

                // update nimipets table
                DB::table('nimipets')
                ->where('user_id', $user_id)
                ->update([
                    'nimi_state' => 'dead', 
                    'nimi_points' => 0,
                    'nimi_lastfed' => null, 
                    'nimi_value' => 0,
                    'nimi_position' => 0, 
                    'food_eaten' => 0, 
                    'food_started' => null,
                    'food_progress' => 0, 
                    'food_today' => 0,
                    'food_status' => null,
                ]);

                // update items table
                DB::table('items')
                ->where('nimi_id', $nimipet[0]->id)
                ->where('item', '!=', 'resurrection')
                ->update([
                    'available' => 0
                ]);
                
                $nimipet = DB::table('nimipets')->where('user_id', '=', $user_id)->get();
                $nimipet[0]->current_time = date("Y-m-d H:i:s");
            }
        }
    }

    $items = DB::table('items')->where('nimi_id', '=', $nimi_id)->get();
    // $items = $items->toArray();

    $response = (object) [ 
        'nimipet' => $nimipet,
        'items' => $items
    ];

    echo json_encode($response, JSON_UNESCAPED_SLASHES);
});


Route::get('/get-items', function () {
    $user_id = JWTAuth::parseToken()->authenticate()->id;

    $items = DB::table('items')->where('user_id', '=', $user_id)->get();
    $items = $items->toArray();

    echo json_encode($items, JSON_UNESCAPED_SLASHES);
});


Route::post('/nimi-birth', function () {
    $user_id = JWTAuth::parseToken()->authenticate()->id;
    $time = date("Y-m-d H:i:s");

    // change user id to avoid duplicate pets
    // @todo: in the future allow having multiple pets
    DB::table('nimipets')
    ->where('user_id', $user_id)
    ->update([
        'user_id' => $user_id * -1
    ]);

    DB::table('items')
    ->where('user_id', $user_id)
    ->update([
        'user_id' => $user_id * -1
    ]);

    DB::table('deadlist')
    ->where('user_id', $user_id)
    ->update([
        'b' => 1
    ]);

    // create new pet
    $nimi_id = DB::table('nimipets')->insertGetId(array(
        'user_id' => $user_id, 'nimi_state' => 'alive', 'nimi_born' => $time
    ));

    // create new item records
    DB::table('items')->insert([
        ['type' => 'magic', 'item' => 'sunglasses', 'user_id' => $user_id, 'nimi_id' => $nimi_id],
        ['type' => 'magic', 'item' => 'hibernation', 'user_id' => $user_id, 'nimi_id' => $nimi_id],
        ['type' => 'magic', 'item' => 'resurrection', 'user_id' => $user_id, 'nimi_id' => $nimi_id],
        ['type' => 'food', 'item' => 'peyote', 'user_id' => $user_id, 'nimi_id' => $nimi_id],
        ['type' => 'food', 'item' => 'durian', 'user_id' => $user_id, 'nimi_id' => $nimi_id],
        ['type' => 'food', 'item' => 'pepper', 'user_id' => $user_id, 'nimi_id' => $nimi_id],
        ['type' => 'food', 'item' => 'water', 'user_id' => $user_id, 'nimi_id' => $nimi_id],
        ['type' => 'food', 'item' => 'burger', 'user_id' => $user_id, 'nimi_id' => $nimi_id],
    ]);

    // return
    $nimipet = DB::table('nimipets')->where('user_id', '=', $user_id)->get();
    $nimipet[0]->current_time = date("Y-m-d H:i:s");
    return $nimipet;
});


Route::post('/nimi-price', function (Request $request) {
    $user_id = JWTAuth::parseToken()->authenticate()->id;
    $price = $request->price;

    // @todo: tokia pat 'alive' apsauga ir kitose queries
    DB::table('nimipets')
    ->where('user_id', '=', $user_id)
    ->where('nimi_state', '=', 'alive')
    ->update([
    'nimi_price' => $price
    ]);

    echo "success";

});


Route::post('/nimi-msg', function (Request $request) {
    $user_id = JWTAuth::parseToken()->authenticate()->id;
    $msg = $request->nimi_msg;

    // @todo: tokia pat 'alive' apsauga ir kitose queries
    DB::table('nimipets')
    ->where('user_id', '=', $user_id)
    ->where('nimi_state', '=', 'alive')
    ->update([
    'nimi_msg' => $msg
    ]);

    echo "success";

});


Route::get('/get-leaderboard', function () {
    // Leaderboard
    $leaderboard = DB::table('nimipets')->select('nimi_name', 'nimi_position', 'nimi_slug', 'nimi_style', 'nimi_value', 'nimi_meta', 'nimi_lastfed', 'nimi_points')->where('nimi_name', '!=', '')->where('nimi_points', '!=', 0)->where('nimi_state', '=', 'alive')->get();
    $leaderboard = $leaderboard->toArray();

	function cmp($a, $b)
	{
		return strnatcmp($b->nimi_points, $a->nimi_points);
	}
	usort($leaderboard, "cmp");

    array_splice($leaderboard, 100);
    
    // Deadlist
    $deadlist = DB::table('deadlist')->select('nimi_name', 'nimi_value', 'nimi_points', 'timestamp')->where('nimi_name', '!=', '')->get();
    $deadlist = $deadlist->toArray();

	function cmp0($a, $b) {
		return strnatcmp($b->nimi_points, $a->nimi_points);
	}
	usort($deadlist, "cmp0");

    array_splice($deadlist, 100);

    $response = (object) [ 
        'leaderboard' => $leaderboard,
        'deadlist' => $deadlist,
        // 'unixTime' => time()
        'current_time' => date("Y-m-d H:i:s")
    ];

    echo json_encode($response, JSON_UNESCAPED_SLASHES);
});


Route::post('/food-basic', function (Request $request) {
    $user_id = JWTAuth::parseToken()->authenticate()->id;
    $updated = false;

    $i = 0;
	while ($i++ < $request->amount) {
        $item_details = DB::table('items')->select('available', 'used')->where('user_id', '=', $user_id)->where('item', '=', $request->item)->first();
        $user_details = DB::table('nimipets')->select('nimi_value', 'food_eaten', 'food_today')->where('user_id', '=', $user_id)->first();

        if ($item_details->available > 0 && $user_details->food_today < 200) {
            $item_details->used++;
            $item_details->available--;
            $user_details->food_eaten++;
            $user_details->food_today++;
            $nimi_points = $user_details->food_eaten + ($user_details->nimi_value * 2);

            DB::table('items')
            ->where('user_id', $user_id)
            ->where('item', $request->item)
            ->update([
            'used' => $item_details->used, 
            'available' => $item_details->available 
            ]);

            DB::table('nimipets')
            ->where('user_id', $user_id)
            ->update([
            'food_eaten' => $user_details->food_eaten,
            'food_today' => $user_details->food_today,
            'nimi_points' => $nimi_points,
            'nimi_lastfed' => date("Y-m-d H:i:s"),
            'nimi_meta' => null
            ]);

            $updated = true;
        }
    }

    if ($updated) {
        
        // cancel sunglasses
        DB::table('items')
        ->where('user_id', $user_id)
        ->where('item', 'sunglasses')
        ->update([
        'used' => 0
        ]);

        // Update leaderboard
        $current = DB::table('nimipets')->select('nimi_points', 'nimi_position', 'id')->where('nimi_state', '=', "alive")->get();
        $current = $current->toArray();

		function cmp($a, $b)
		{
			return strnatcmp($b->nimi_points, $a->nimi_points);
		}
		usort($current, "cmp");

		$position = 0;
		foreach ($current as $nimipet) {
            $position++;
            DB::table('nimipets')
            ->where('id', $nimipet->id)
            ->update([
            'nimi_position' => $position
            ]);
		}

        // Return nimi data
        $nimipet_data = DB::table('nimipets')
        ->select('nimi_position', 'nimi_value', 'nimi_meta', 'nimi_points', 'food_today', 'nimi_lastfed')
        ->where('user_id', '=', $user_id)
        ->get();
        $nimipet_data = $nimipet_data->toArray();

        // Update nimipet array with the backend time
        $nimipet_data[0]->current_time = date("Y-m-d H:i:s");

        $items_data = DB::table('items')
        ->select('available')
        ->where('user_id', '=', $user_id)
        ->where('item', '=', $request->item)
        ->first();

        $response = (object) [ 
            'nimi' => $nimipet_data[0],
            'items' => $items_data
        ];
        return json_encode($response, JSON_UNESCAPED_SLASHES);

    }
    else {
        if (!($user_details->food_today < 200)) {
            echo "food_today_limit";
        }
        else {
            echo "error";
        }
    }
});


Route::post('/food-special', function (Request $request) {
    $user_id = JWTAuth::parseToken()->authenticate()->id;

    $item_details = DB::table('items')->select('available', 'used')->where('user_id', '=', $user_id)->where('item', '=', $request->item)->first();
    $user_details = DB::table('nimipets')->select('nimi_value', 'food_eaten', 'food_today')->where('user_id', '=', $user_id)->first();

    if ($item_details->available > 0 && $user_details->food_today < 200) {
        $item_details->used++;
        $item_details->available--;

        // custom food details
        $date = date("Y-m-d H:i:s");
        if ($request->item == 'peyote') { $food_points = 20; $nimi_meta = json_encode([ 'peyote', $date ]); }
        else if ($request->item == 'durian') { $food_points = 10; $nimi_meta = json_encode([ 'durian', $date ]); }
        else if ($request->item == 'pepper') { $food_points = 5; $nimi_meta = json_encode([ 'pepper', $date ]); }

        $user_details->food_eaten += $food_points;
        $user_details->food_today++;
        $nimi_points = $user_details->food_eaten + ($user_details->nimi_value * 2);

        DB::table('items')
        ->where('user_id', $user_id)
        ->where('item', $request->item)
        ->update([
        'used' => $item_details->used, 
        'available' => $item_details->available 
        ]);

        DB::table('nimipets')
        ->where('user_id', $user_id)
        ->update([
        'food_eaten' => $user_details->food_eaten,
        'food_today' => $user_details->food_today,
        'nimi_points' => $nimi_points,
        'nimi_lastfed' => date("Y-m-d H:i:s"),
        'nimi_meta' => $nimi_meta
        ]);
        
        // cancel sunglasses
        DB::table('items')
        ->where('user_id', $user_id)
        ->where('item', 'sunglasses')
        ->update([
        'used' => 0
        ]);

        // Update leaderboard
        $current = DB::table('nimipets')->select('nimi_points', 'nimi_position', 'id')->where('nimi_state', '=', "alive")->get();
        $current = $current->toArray();

        function cmp($a, $b)
        {
            return strnatcmp($b->nimi_points, $a->nimi_points);
        }
        usort($current, "cmp");

        $position = 0;
        foreach ($current as $nimipet) {
            $position++;
            DB::table('nimipets')
            ->where('id', $nimipet->id)
            ->update([
            'nimi_position' => $position
            ]);
        }

        // Return nimi data
        $nimipet_data = DB::table('nimipets')
        ->select('nimi_position', 'nimi_value', 'nimi_meta', 'nimi_points', 'food_today', 'nimi_lastfed')
        ->where('user_id', '=', $user_id)
        ->get();
        $nimipet_data = $nimipet_data->toArray();

        // Update nimipet array with the backend time
        $nimipet_data[0]->current_time = date("Y-m-d H:i:s");

        $items_data = DB::table('items')
        ->select('available')
        ->where('user_id', '=', $user_id)
        ->where('item', '=', $request->item)
        ->first();

        $response = (object) [ 
            'nimi' => $nimipet_data[0],
            'items' => $items_data
        ];
        return json_encode($response, JSON_UNESCAPED_SLASHES);
    }

    else if (!($user_details->food_today < 200)) {
        echo "food_today_limit";
    }
    else {
        echo "error";
    }
});


Route::post('/magic', function (Request $request) {
    $user_id = JWTAuth::parseToken()->authenticate()->id;

    $item_details = DB::table('items')->select('available', 'used', 'received')->where('user_id', '=', $user_id)->where('item', '=', $request->item)->first();
    $date = date("Y-m-d H:i:s");

    if ($request->item == 'sunglasses' && $item_details->available > 0) {
        if ($item_details->used == 0) {
            // sunglasses on
            $item_details->used++;
            $nimi_meta = json_encode([ 'sunglasses', $date ]);
        }
        else if ($item_details->used == 1) {
            // sunglasses off
            $item_details->used--;
            $nimi_meta = null;
        }
        
        DB::table('items')
        ->where('user_id', $user_id)
        ->where('item', $request->item)
        ->update([
        'used' => $item_details->used
        ]);

        DB::table('nimipets')
        ->where('user_id', $user_id)
        ->update([
        'nimi_meta' => $nimi_meta
        ]);

        // Return nimi data
        return $nimi_meta;
    }

    else if ($item_details->available > 0) {
        $item_details->used++;
        $item_details->available--;

        // custom item details
        if ($request->item == 'hibernation') { $nimi_meta = json_encode([ 'hibernation', $date ]); }

        DB::table('items')
        ->where('user_id', $user_id)
        ->where('item', $request->item)
        ->update([
        'used' => $item_details->used, 
        'available' => $item_details->available 
        ]);

        DB::table('items')
        ->where('user_id', $user_id)
        ->where('item', 'sunglasses')
        ->update([
        'used' => 0
        ]);

        DB::table('nimipets')
        ->where('user_id', $user_id)
        ->update([
        'nimi_meta' => $nimi_meta
        ]);

        // Return nimi data
        return $nimi_meta;
    }
    else {
        echo "error";
    }
});


Route::post('/nimi-name', function (Request $request) {
    $user_id = JWTAuth::parseToken()->authenticate()->id;
    $name = $request->name;

    function slugify($text) {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);
        // trim
        $text = trim($text, '-');
        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);
        // lowercase
        $text = strtolower($text);
        if (empty($text)) {
            return 'n-a';
        }
        return $text;
    }

    $slug = slugify($name);

    $slug_db = DB::table('nimipets')->select('nimi_slug')->where('user_id', '>', 0)->where('nimi_slug', '=', $slug)->first();

    if (!$slug_db) {

        DB::table('nimipets')
        ->where('user_id', $user_id)
        ->update([
        'nimi_name' => $name, 
        'nimi_slug' => $slug 
        ]);

        echo "success";
    }
    else {
        echo "name-taken";
    }
});


Route::post('/nimi-style', function (Request $request) {
    $user_id = JWTAuth::parseToken()->authenticate()->id;
    $style = json_encode($request->style);

    if (
    DB::table('nimipets')
    ->where('user_id', $user_id)
    ->update([
    'nimi_style' => $style,
    ])
    ) {
        echo "success";
    }
    else {
        echo "error";
    }
    
});


// FOOD

Route::post('/update-food-started', function (Request $request) {
    $nimi_id = $request->nimi_id;

    $food_started_db = DB::table('nimipets')->select('food_started')->where('id', '=', $nimi_id)->first();
    $food_started_new =  date("Y-m-d H:i:s");

    if ($food_started_db->food_started == null) {
        if (DB::table('nimipets')->where('id', '=', $nimi_id)->update([ 'food_started' => $food_started_new ])) {
            echo "success";
        }
        else {
            echo "error-db-update";
        }
    }
});


Route::post('/update-food-progress', function (Request $request) {
    $nimi_id = $request->nimi_id;
    $mining_time = $request->mining_time;

    if (DB::table('nimipets')->where('id', '=', $nimi_id)->update([ 'food_progress' => $mining_time ])) {
        echo "success";
    }
    else {
        echo "error-db-update";
    }
});


Route::post('/update-food-pieces', function (Request $request) {
    $user_id = JWTAuth::parseToken()->authenticate()->id;
    $nimi_id = $request->nimi_id;
    
    $food_data = DB::table('nimipets')->select('food_started', 'food_eaten')->where('id', '=', $nimi_id)->first();
    
    $food_started = $food_data->food_started;
    $food_eaten = $food_data->food_eaten;
    
    $referred_by = DB::table('users')->select('referred_by')->where('id', '=', $user_id)->first();
    $referred_by = $referred_by->referred_by;

	$current_date = date("Y-m-d H:i:s");
	$unix_time = strtotime($current_date) - strtotime($food_started);
	$time_diff = date($unix_time);

	if ($time_diff > 830) {
        // probabilities
        // peyote - 0.01
        // durian - 0.02
        // pepper - 0.04
        // water - 0.20
        // burger - 0.73

        $foodArray = array('peyote' => '1', 'durian' => '2', 'pepper' => '4', 'water' => '20', 'burger' => '73' );

        $newFood = array();
        foreach ($foodArray as $food=>$value)
        {
            $newFood = array_merge($newFood, array_fill(0, $value, $food));
        }
        $randomFood = $newFood[array_rand($newFood)];
        
        // get received and available amount of that piece of food from db items
        $randomFoodFromDB = DB::table('items')->select('received', 'available')->where('item', '=', $randomFood)->where('nimi_id', '=', $nimi_id)->first();
        $received_new = $randomFoodFromDB->received + 1;
        $available_new = $randomFoodFromDB->available + 1;

        // update db items with received and available food
        DB::table('items')->where('nimi_id', '=', $nimi_id)->where('item', '=', $randomFood)->update([ 'received' => $received_new, 'available' => $available_new ]);
        
        // update db items with received and available food
        $food_started = date("Y-m-d H:i:s");
        DB::table('nimipets')->where('id', '=', $nimi_id)->update([ 'food_started' => $food_started, 'food_progress' => 0 ]);

        // get referral details
        $referred_by = DB::table('users')->select('referred_by')->where('id', '=', $user_id)->first();
        $referred_by = $referred_by->referred_by;

        // update referral
        if ($referred_by != null) {
            $referred_by_user_id = DB::table('users')->select('id')->where('referral_id', '=', $referred_by)->first();
            $referred_by_user_id = $referred_by_user_id->id;

            if ($received_new % 10 == 0) {
                $food_pieces = DB::table('items')->select('received', 'available')->where('user_id', '=', $referred_by_user_id)->where('item', '=', $randomFood)->first();
                $food_pieces_received = $food_pieces->received + 1;
                $food_pieces_available = $food_pieces->available + 1;
                
                DB::table('items')->where('user_id', '=', $referred_by_user_id)->where('item', '=', $randomFood)->update([ 'received' => $food_pieces_received, 'available' => $food_pieces_available ]);
            }
        }
		
        $items = DB::table('items')->where('user_id', '=', $user_id)->get();
        $items = $items->toArray();

        echo json_encode($items, JSON_UNESCAPED_SLASHES);
	}
});


Route::get('/get_referrals', function () {
    $user_id = JWTAuth::parseToken()->authenticate()->id;

    $referral_id = DB::table('users')->select('referral_id')->where('id', '=', $user_id)->first();
    $referral_id = $referral_id->referral_id;

    $referrals = DB::table('users')->select('id')->where('referred_by', '=', $referral_id)->get();
    $referrals = $referrals->toArray();

    foreach ($referrals as $referral) {
        
        $nimi_name = DB::table('nimipets')->select('nimi_name')->where('user_id', '=', $referral->id)->first();

        if ($nimi_name != null) {
            $nimi_name = $nimi_name->nimi_name;
            $received = 0;
            $food_pieces = DB::table('items')->select('received')->where('user_id', '=', $referral->id)->where('type', '!=', 'magic')->get();
            foreach ($food_pieces as $piece) {
                if ($piece->received > 0) {
                    $received += floor($piece->received / 10);
                }
            }   
            $referrals_array[] = [ $nimi_name, $received ];
        }
    }

    if (!empty($referrals_array)) {
        $response = (object) [ 
            'referral_id' => $referral_id,
            'referrals' => $referrals_array
        ];
    }
    else {
        $response = (object) [ 
            'referral_id' => $referral_id
        ];
    }

    echo json_encode($response, JSON_UNESCAPED_SLASHES);
});


Route::post('/referral-id', function (Request $request) {
    $nimi_slug = $request->nimi_slug;

    $user_id = DB::table('nimipets')->select('user_id')->where('nimi_slug', '=', $nimi_slug)->first();
    $user_id = $user_id->user_id;

    $referral_id = DB::table('users')->select('referral_id')->where('id', '=', $user_id)->first();
    $referral_id = $referral_id->referral_id;

    echo($referral_id);
});


Route::post('/nimiq-address', function (Request $request) {
    $user_id = JWTAuth::parseToken()->authenticate()->id;
    $address = $request->address;

    DB::table('users')
    ->where('id', $user_id)
    ->update([
    'nimiq_address' => $address,
    ]);

    echo "success";
});


Route::post('/withdrawal', function () {
    $user_id = JWTAuth::parseToken()->authenticate()->id;

    $nimiq_address = DB::table('users')->select('nimiq_address')->where('id', '=', $user_id)->first();
    $nimiq_address = $nimiq_address->nimiq_address;

    $nimi_value = DB::table('nimipets')->select('nimi_value')->where('user_id', '=', $user_id)->first();
    $nimi_value = $nimi_value->nimi_value;

    if ($nimi_value >= 1) {

        // update withdrawals table
        DB::table('withdrawals')->insert([
            'user_ID' => $user_id, 'amount' => $nimi_value, 'address' => $nimiq_address, 'created' => date("Y-m-d H:i:s")
        ]);

        // update nimipets table
        DB::table('nimipets')
        ->where('user_id', $user_id)
        ->update([
            'nimi_state' => 'dead', 
            'nimi_points' => 0,
            'nimi_lastfed' => null, 
            'nimi_value' => 0,
            'nimi_position' => 0, 
            'food_eaten' => 0, 
            'food_started' => null,
            'food_progress' => 0, 
            'food_today' => 0,
            'food_status' => null,
        ]);

        // update items table
        DB::table('items')
        ->where('user_id', $user_id)
        ->update([
            'available' => 0
        ]);
        
        $nimipet = DB::table('nimipets')->where('user_id', '=', $user_id)->get();
        $nimipet[0]->current_time = date("Y-m-d H:i:s");
    
    }
});


Route::post('/resurrection', function () {
    $user_id = JWTAuth::parseToken()->authenticate()->id;

    $items = DB::table('deadlist')->where('user_id', '=', $user_id)->where('a', '!=', '1')->first();

	if (!$items) {
		return "too_late";
	}
    else {
		$nimi_points = $items->food_eaten + $items->nimi_value * 2;
        
        $date = date("Y-m-d H:i:s");
        $meta = json_encode([ 'zombie', $date ]);

        DB::table('nimipets')
        ->where('user_id', $user_id)
        ->update([
        'nimi_state' => 'alive',
        'nimi_points' => $nimi_points,
        'nimi_lastfed' => null,
        'nimi_value' => $items->nimi_value,
        'nimi_position' => 0,
        'food_eaten' => $items->food_eaten,
        'food_started' => null,
        'food_progress' => 0,
        'food_today' => 0,
        'nimi_meta' => $meta
        ]);

        // remove from deadlist
        DB::table('deadlist')->where('user_id', '=', $user_id)->delete();

        // UPDATE RESURRECTION COUNT
        $resurrection = DB::table('items')->select('available', 'used')->where('user_id', '=', $user_id)->where('item', '=', 'resurrection')->first();
        $available = $resurrection->available - 1;
        $used = $resurrection->used + 1;
        DB::table('items')
        ->where('user_id', $user_id)
        ->where('item', 'resurrection')
        ->update([
        'available' => $available,
        'used' => $used
        ]);

        // clear inventory
        DB::table('items')
        ->where('user_id', '=', $user_id)
        ->where('item', '!=', 'resurrection')
        ->update([
        'available' => 0
        ]);

		// Update leaderboard
        $current = DB::table('nimipets')->select('nimi_points', 'nimi_position', 'id')->where('nimi_state', '=', "alive")->get();
        $current = $current->toArray();
		function cmp($a, $b) { return strnatcmp($b->nimi_points, $a->nimi_points); }
		usort($current, "cmp");
		$position = 0;
		foreach ($current as $nimipet) {
            $position++;
            DB::table('nimipets')
            ->where('id', $nimipet->id)
            ->update([
            'nimi_position' => $position
            ]);
		}
        
		return "resurrected";
    }
});
