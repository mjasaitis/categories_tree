<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use View;
use Illuminate\Http\Request;
use App\Category;

class FrontpageController extends Controller
{

    /**
     * Frontpage index
     *
     * @return void
     */
    public function getIndex(Request $request)
    {
        $cat = new Category();
        $rootNode = $cat->buildCategoriesConnections();
        View::share("rootNode", $rootNode);

        if ($request->input("pid")) {
            View::share("category", $cat->find($request->input("pid")));
        }

        $categories = $cat->getIterative();
        View::share("categories_i", $categories);

        $categories = $cat->getIterativeQue();
        View::share("categories_iq", $categories);

        return View::make("frontpage");
    }


    /**
     * Save category
     *
     * @return void
     */
    public function postSave(Request $request)
    {
        $title = $request->input("title");
        $pid = (int)$request->input("pid");

        if ($title != '') {
            $cat = new Category();
            $cnt = $cat->where("pid", $pid)->count();
            $cat->title = $title;
            $cat->pid = $pid;
            $cat->order_position = $cnt + 1;
            $cat->save();
        }

        return redirect("/");
    }
}
