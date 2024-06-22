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
        // Validate the request data
        $request->validate([
            'Category' => 'required|string|max:255',
            'productName' => 'required|string|max:255',
            'productPrice' => 'required|numeric',
            'productDescription' => 'nullable|string',
            'productImage' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        try {
            if ($request->hasFile('productImage') && $request->file('productImage')->isValid()) {
                // Get the image file
                $imageFile = $request->file('productImage');
        
                // Check if $imageFile is an instance of UploadedFile
                if (!$imageFile instanceof \Illuminate\Http\UploadedFile) {
                    throw new \Exception("Uploaded file is not valid.");
                }
        
                // Log image details correctly
                \Log::info('Image details:', [
                    'original_name' => $imageFile->getClientOriginalName(),
                    'mime_type' => $imageFile->getClientMimeType(),
                    'size' => $imageFile->getSize(),
                ]);
    
                // Store the image locally
                $imagePath = $imageFile->store('public/images'); // Store the image in the 'public/images' directory
    
                // Get the URL to the stored image
                $imageURL = \Storage::url($imagePath);
    
                // Create a new product instance
                $product = new Product();
                $product->Category = $request->input('Category');
                $product->Pname = $request->input('productName');
                $product->price = $request->input('productPrice');
                $product->Pdesc = $request->input('productDescription');
                $product->Pimage = $imageURL; // Store the URL to the image in the database
    
                // Save the product to the database
                $product->save();
    
                // Redirect with a success message
                return redirect()->route('manage.catalogue')->with('success', 'Product added successfully!');
            } else {
                // Redirect back with an error message if the image upload failed
                return redirect()->back()->withInput()->withErrors(['productImage' => 'Failed to upload product image']);
            }
        } catch (\Exception $e) {
            // Log the error message
            \Log::error('Error storing product:', ['exception' => $e->getMessage()]);
    
            // Redirect back with the error message if there's an exception
            return redirect()->back()->withInput()->withErrors(['database' => $e->getMessage()]);
        }
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
    
        // Handle image update
        if ($request->hasFile('productImage') && $request->file('productImage')->isValid()) {
            // Delete the old image if necessary (optional step)
            // Storage::delete($product->Pimage); // Uncomment this line if you want to delete the old image
    
            // Store the new image
            $imagePath = $request->file('productImage')->store('public/images');
            $imageURL = \Storage::url($imagePath);
    
            $product->Pimage = $imageURL;
        }
    
        try {
            $product->save();
            \Log::info('Product updated successfully!');
        } catch (\Exception $e) {
            \Log::error('Product update failed: ' . $e->getMessage());
            // Handle exception as needed
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

            

