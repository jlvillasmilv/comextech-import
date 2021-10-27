<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use App\Models\Payer;

use Illuminate\Support\Facades\Storage;

class successMountComposer {

	public function compose(View $view){
		if(auth()->user()->hasRole('client')) {
			$mount = Payer::InvoicesLastThreeMonths()->where('settlement_status_id', 3)->sum('total');

            if(!is_null(auth()->user()->client->executive)){

				if (Storage::disk('s3')->exists('profileImages/'.auth()->user()->client->executive->avatar)) {

					Storage::disk('s3')->setVisibility('profileImages/'.auth()->user()->client->executive->avatar, 'public');
					$exceuteve_avatar = Storage::disk('s3')->url('profileImages/'.auth()->user()->client->executive->avatar);
				}
            }
			$exceuteve_avatar = asset('img/avatar.jpg');

			$view->with('mount',  $mount );
			$view->with('exceuteve_avatar',  $exceuteve_avatar );


		}
	}
}
