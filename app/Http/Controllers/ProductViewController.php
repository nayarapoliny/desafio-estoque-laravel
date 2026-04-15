<?php

namespace App\Http\Controllers;

use App\Services\ProductService; // Importante ter essa linha!
use Illuminate\Http\Request;

class ProductViewController extends Controller
{
    // Adicione estas 2 linhas abaixo para o Laravel injetar o serviço
    public function __construct(private ProductService $service) {}

    public function index(Request $request) 
    {
        $products = \App\Models\Product::orderByDesc('id')->paginate(15);

        return view('products.index', compact('products'));
    }
}