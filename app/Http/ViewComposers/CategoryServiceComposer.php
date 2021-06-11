<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use App\Models\CategoryService;

class CategoryServiceComposer {

	public function compose(View $view)
	{
        $category = CategoryService::select('id', 'name')
            ->orderBy('name', 'ASC')
            ->pluck('name','id');
                        
        $view->with('category',  $category);
	}
}