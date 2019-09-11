<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Color;
use App\Models\Size;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductSize;
use App\Models\ProductImage;
use Auth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $allcolors=Color::all();
        $allsizes=Size::all();
        return view('home',compact('allcolors','allsizes'));
    }

    public function AddProduct(Request $request){
      $rules = [
      'name' => ['required', 'string', 'max:255'],
      'price' => ['required',],
   ];
   $customMessages = [
      'name.required'=>'The Product Name is required',
      'price.required'=>'The Product Price is required',
    ];
    $this->validate($request, $rules, $customMessages);

    $product=new Product;
    $product->name=@$request->name;
    $product->price=@$request->price;
    $product->save();

    $images = @$request->file('filename');

    if(@$images){
    $total=count(@$images);
    if(@$total > 5){
      return back()->with('error','Only 5 images can be uploaded');
    }
    foreach($images as $image){
    $rand=rand();
    if(isset($image)){
        if($image->isValid())
        {
            //get extension
            $extension =$image->getClientOriginalExtension();
            $imagename = Auth::user()->id.@$rand.'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/Uploads');
            $image->move($destinationPath, $imagename);

            $productImage=new ProductImage;
            $productImage->product_id=@$product->id;
            $productImage->pic=@$imagename;
            $productImage->save();
        }else{
            return response()->json(array('success'=>0,'msg'=>'Image is not valid'), 400);
        }
    }
    }
  }
    $colors=@$request->colors;
    $sizes=@$request->sizes;


    if($colors){
    foreach($colors as $color){
    $productColor=new ProductColor;
    $productColor->product_id=@$product->id;
    $productColor->color_id=@$color;
    $productColor->save();
    }
  }
  if($sizes){
    foreach($sizes as $size){
    $productSize=new ProductSize;
    $productSize->product_id=@$product->id;
    $productSize->size_id=@$size;
    $productSize->save();
    }
  }
    return redirect()->route('list_product');
  }

  public function ListProduct(){
    $products=Product::all();
    return view('allproduct',compact('products'));
  }

  public function EditProduct($id){
    $products=Product::find($id);
    $allcolors=Color::all();
    $allsizes=Size::all();
    return view('editproduct',compact('products','allcolors','allsizes','id'));
  }

  public function UpdateProduct(Request $request){
    $rules = [
    'name' => ['required', 'string', 'max:255'],
    'price' => ['required',],
 ];
 $customMessages = [
    'name.required'=>'The Product Name is required',
    'price.required'=>'The Product Price is required',
  ];
  $this->validate($request, $rules, $customMessages);

  $product=\DB::table('products')
  ->where('id',$request->product_id)
  ->update(array(
    'name'=>@$request->name,
    'price'=>@$request->price
  ));
  $imagescount=ProductImage::where('product_id',$request->product_id)->count('id');
  $images = @$request->file('filename');
  if(@$images){
  $total=count(@$images)+@$imagescount;
  if(@$total > 5){
    return back()->with('error','Only 5 images can be uploaded');
  }
  if(@$images){
  foreach($images as $image){
  $rand=rand();
  if(isset($image)){
      if($image->isValid())
      {
          //get extension
          $extension =$image->getClientOriginalExtension();
          $imagename = Auth::user()->id.@$rand.'.'.$image->getClientOriginalExtension();
          $destinationPath = public_path('/Uploads');
          $image->move($destinationPath, $imagename);

          $productImage=new ProductImage;
          $productImage->product_id=@$request->product_id;
          $productImage->pic=@$imagename;
          $productImage->save();
      }else{
          return response()->json(array('success'=>0,'msg'=>'Image is not valid'), 400);
      }
  }
  }
}
}
  $colordel=ProductColor::where('product_id',$request->product_id)->delete();
  $sizedel=ProductSize::where('product_id',$request->product_id)->delete();
  $colors=@$request->colors;
  $sizes=@$request->sizes;
if($colors){
  foreach($colors as $color){
    $productColor=new ProductColor;
    $productColor->product_id=$request->product_id;
    $productColor->color_id=@$color;
    $productColor->save();
  }
}
if($sizes){
  foreach($sizes as $size){
    $productSize=new ProductSize;
    $productSize->product_id=$request->product_id;
    $productSize->size_id=@$size;
    $productSize->save();
  }
}
  return redirect()->route('list_product');
  }

  public function GetProductData(Request $request){
    $product=Product::where('id',@$request->id)->first();
    foreach($product->color as $color){
              $inv[] = @$color->color_id;
            }
            if(@$inv){
            $col=implode(", ",@$inv);
            $Color = Color::select("id", "name as text",
                \DB::Raw("(CASE WHEN id IN (".@$col.") THEN true ELSE false END) as selected")
            )->get();
          }else{
            $Color = Color::select("id", "name as text")->get();
          }

            foreach($product->size as $size){
                      $inv1[] = @$size->size_id;
                    }
                    if(@$inv1){
                    $siz=implode(", ",@$inv1);
                    $Size = Size::select("id", "name as text",
                        \DB::Raw("(CASE WHEN id IN (".@$siz.") THEN true ELSE false END) as selected")
                    )->get();
                  }else{
                    $Size = Size::select("id", "name as text")->get();
                  }



    return \Response::json([ 'colors' => @$Color,'size' => @$Size ], 200);
  }

  public function DelProductImage(Request $request){
    $del=ProductImage::where('id',@$request->id)->first();
    $path = public_path()."/Uploads/".@$del->pic;
    
    unlink($path);
      $del=ProductImage::where('id',@$request->id)->delete();
      return \Response::json([ 'success' => 1 ], 200);
  }
}
