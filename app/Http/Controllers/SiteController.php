<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Review;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiteController extends Controller
{
    public function index()
    {
        $slider_product = Product::orderByDesc('id')->limit(2)->get();
        $categories = Category::orderByDesc('id')->get();

        $allproduct = Product::orderByDesc('id')->limit(9)->offset(2)->get();


        // dd($slider_product);
        return view('site.index',compact('slider_product','categories','allproduct'));
    }

        public function about()
        {
            return view('site.about');
        }

        public function shop()
        {
            $products=Product::orderByDesc('id')->paginate(9);
            return view('site.shop',compact('products'));
        }

        public function contact()
        {
            return view('site.contact');
        }

        public function category($id)
        {
            $category = Category::findOrFail($id);
            // dd($category->products);
            return view('site.category')->with('category',$category);
        }

        public function product($id)
        {
            $product= Product::find($id);
            // dd($product);
            $next = Product::where('id','>',$id)->first();
            $prev = Product::where('id','<' ,$id)->orderByDesc('id')->first();
            $related = Product::where('category_id',$product->category_id)->where('id','!=',$id)->get();
            // dd($prev);
            return view('site.product',compact('product','next','prev','related'));

        }

        public function review(Request $request, $id )
        {
            $request->validate([
                'rating' =>'required',
                'content' => 'required'


            ]);
            Review::create([
                'star' =>$request->rating,
                'content' => $request->content,
                'product_id'=> $id,
                'user_id' => Auth::id()
            ]);
            return redirect()->back();
        }

  public function search(Request $request )
  {
    // dd($request->all());
    $name = 'name_' .app()->currentLocale();
   $products= Product::where($name, 'like','%' .$request->keyword .'%')->get();
    return view('site.search',compact('products'));
}


}
