<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ProductService;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(private ProductService $service) {}

    public function index(Request $request)
    {
        $products = $this->service->list($request);
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(StoreProductRequest $request)
    {
        $this->service->create($request->validated());
        
        // MUDANÇA AQUI: Usando o caminho direto para fugir da API
        return redirect('/products')->with('success', 'Produto cadastrado com sucesso!');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $this->service->update($product, $request->validated());
        
        // MUDANÇA AQUI: Usando o caminho direto para fugir da API
        return redirect('/products')->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy(Product $product)
    {
        $this->service->delete($product);
        
        // MUDANÇA AQUI: Usando o caminho direto para fugir da API
        return redirect('/products')->with('success', 'Produto removido com sucesso!');
    }
}