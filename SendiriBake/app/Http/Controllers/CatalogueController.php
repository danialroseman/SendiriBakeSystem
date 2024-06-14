<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; 
use Illuminate\Support\Facades\DB;

class CatalogueController extends Controller
{
    //customer page functions
    public function index()
    {
        $creampuffs = Product::where('Category', 'Creampuffs')->get();
        $cupcakes = Product::where('Category', 'Cupcakes')->get();
        $munchies = Product::where('Category', 'Munchies')->get();
        $cakes = Product::where('Category', 'Cakes')->get();

        return view('customer.index', compact('creampuffs', 'cupcakes', 'munchies', 'cakes'));
    }


//admins pages functions
    public function manageCat()
    {
        // Fetch all products from the database
        $products = Product::all();
        return view('admin.manageCat', compact('products'));
    }

    public function addProduct()
    {
        return view('admin.addProduct');
        
        
    }

    public function storeProduct(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'Category'=>'required|string|max:255',
            'productName' => 'required|string|max:255',
            'productPrice' => 'required|numeric',
            'productDescription' => 'nullable|string',
            'productImage' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Checks
        if ($request->hasFile('productImage') && $request->file('productImage')->isValid()) {
            $imageData = file_get_contents($request->file('productImage')->getRealPath());
    
            $product = new Product();
            $product->Category = $request->input('Category');
            $product->Pname = $request->input('productName');
            $product->price = $request->input('productPrice');
            $product->Pdesc = $request->input('productDescription');
            $product->Pimage = $imageData;
            $product->save();
            
    
            return redirect()->route('manage.catalogue')->with('success', 'Product added successfully!');
        }
    
        return redirect()->back()->withInput()->withErrors(['productImage' => 'Failed to upload product image']);
    }
    

    public function editProduct($Id)
    {
        $product = Product::findOrFail($Id);
        return view('admin.editProduct', compact('product'));
    }

    

    public function updateProduct(Request $request, $Id)
    {
        $product = Product::findOrFail($Id);
    
        $product->Pname = $request->input('productName');
        $product->price = $request->input('productPrice');
        $product->Pdesc = $request->input('productDescription');
    
        if ($request->hasFile('productImage') && $request->file('productImage')->isValid()) {
            $imageData = file_get_contents($request->file('productImage')->getRealPath());
            $product->Pimage = $imageData;
        }
    
        try {
            $product->save();
            \Log::info('Product updated successfully!');
        } catch (\Exception $e) {
            \Log::error('Product update failed: ' . $e->getMessage());
            dd($e->getMessage());
        }
    
        return redirect()->route('manage.catalogue')->with('success', 'Product updated successfully!');
    }
    

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        
        try {
            $product->delete();
            return redirect()->route('manage.catalogue')->with('success', 'Product deleted successfully!');
        } catch (\Exception $e) {
            \Log::error('Product deletion failed: ' . $e->getMessage());
            return redirect()->route('manage.catalogue')->with('error', 'Failed to delete product.');
        }
    }
        
}

            

