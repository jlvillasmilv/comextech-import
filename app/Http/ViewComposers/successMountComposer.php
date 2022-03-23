<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use App\Models\Factoring\Payer;

use Illuminate\Support\Facades\Storage;

class successMountComposer {

	public function compose(View $view){

		if(auth()->user()->hasRole('Cliente')) {
			$mount = Payer::InvoicesLastThreeMonths()->where('settlement_status_id', 3)->sum('total');

            if(!is_null(auth()->user()->company->executive)){

				if (Storage::disk('s3')->exists('profileImages/'.auth()->user()->company->executive->avatar)) {

					Storage::disk('s3')->setVisibility('profileImages/'.auth()->user()->company->executive->avatar, 'public');
					$exceuteve_avatar = Storage::disk('s3')->url('profileImages/'.auth()->user()->company->executive->avatar);
				}
            }
			$exceuteve_avatar = asset('img/avatar.jpg');

			$view->with('mount',  $mount );
			$view->with('exceuteve_avatar',  $exceuteve_avatar );


		}
	}
}
