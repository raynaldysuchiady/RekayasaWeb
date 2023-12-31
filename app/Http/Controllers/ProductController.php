<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all(); //MEMBUAT QUERY UNTUK MENGAMBIL DATA DARI TABLE PRODUCTS
        return Inertia::render('product', ['data' => $products]); //RENDER DATA TERSEBUT MENGGUNAKAN INERTIA. 
        //PARAMETER PERTAMA YAKNI product ADALAH NAMA FILE .VUE YANG NANTINYA AKAN KITA BUAT
        //PARAMETER BERIKUTNYA ADALAH DATA YANG AKAN DIPASSING BERISI SELURUH DATA PRODUCTS
    }
    public function store(Request $request)
    {
        info('test-123');
        Validator::make($request->all(), [
            'code' => ['required', 'string', 'unique:products,code'],
            'name' => ['required', 'string'],
            'price' => ['required', 'integer'],
            'weight' => ['required', 'integer'],
        ])->validate();

        Product::create($request->all());
        return redirect()->back()->with(['message' => 'Produk: ' . $request->name . ' Ditambahkan']);
    }

    public function update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'code' => ['required', 'string', 'unique:products,code,' . $id],
            'name' => ['required', 'string'],
            'price' => ['required', 'integer'],
            'weight' => ['required', 'integer'],
        ])->validate();

        $product = Product::find($id);
        $product->update($request->all());
        return redirect()->back()->with(['message' => 'Produk: ' . $request->name . ' Diperbaharui']);
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        return redirect()->back()->with(['message' => 'Produk: ' . $product->name . ' Di hapus']);
    }

}
