<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; 
use Illuminate\Support\Facades\DB;

class CatalogueController extends Controller
{
    public function index()//customer page
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
    
        // Check if file upload is successful
        if ($request->hasFile('productImage') && $request->file('productImage')->isValid()) {
            // Get the binary image data
            $imageData = file_get_contents($request->file('productImage')->getRealPath());
    
            // Create a new product instance and save it
            $product = new Product();
            $product->Category = $request->input('Category');
            $product->Pname = $request->input('productName');
            $product->price = $request->input('productPrice');
            $product->Pdesc = $request->input('productDescription');
            $product->Pimage = $imageData;
            $product->save();
            
    
            // Redirect back to the manageCat page after adding the product
            return redirect()->route('manage.catalogue')->with('success', 'Product added successfully!');
        }
    
        // Handle file upload error
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
    
        // Update the product details
        $product->Pname = $request->input('productName');
        $product->price = $request->input('productPrice');
        $product->Pdesc = $request->input('productDescription');
    
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

            

