<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::orderBy('id', 'desc')->get();
        return view('product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $product = Product::all();
        return view('product.create', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'product_name' => 'required|min:3',
            'price_raw' => 'required|numeric|min:1',
            'stock' => 'required|numeric|min:3',
        ]);

        //ambil file dari request
        $image = $request->file('image');

        //buat nama unik untuk gambar
        $imageName = time() . '_' . $image->getClientOriginalName();

        //pindahkan gambar ke folder public/image/
        $image->move(public_path('image'), $imageName);

        //simpan hanya nama file ke database
        Product::create([
            'image' => $imageName, //simpan nama file saja
            'product_name' => $request->product_name,
            'price' => $request->price_raw,
            'stock' => $request->stock,
        ]);

        return redirect()->back()->with('success', 'Berhasil menambahkan data produk!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = Product::find($id);
        return view('product.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'product_name' => 'required|min:3',
            'price_raw' => 'required|numeric|min:1',
            'stock' => 'required|numeric|min:1',
        ]);

        $product = Product::findOrFail($id);

        // Cek jika ada file gambar baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if (!empty($product->image) && file_exists(public_path('image/' . $product->image))) {
                unlink(public_path('image/' . $product->image));
            }

            // Upload gambar baru
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('image'), $imageName);

            // Set gambar baru di database
            $product->image = $imageName;
        }

        // Update data produk
        $product->update([
            'product_name' => $request->product_name,
            'price' => $request->price_raw,
            'stock' => $request->stock,
            'image' => $product->image,
        ]);

        return redirect()->back()->with('success', 'Berhasil update data produk!');
    }

    public function updateStock(Request $request, $id) {
        $request->validate([
            'stock' => 'required|numeric|min:0',
        ]);

        $product = Product::findOrFail($id);

        if(!$product) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan!');
        }

        $product->stock = $request->stock;
        $product->save();

        return redirect()->back()->with('success', 'Berhasil update stock!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->back()->with('success', 'Berhasil menghapus data!');
    }
}
