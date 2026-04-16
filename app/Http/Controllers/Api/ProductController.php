<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductService;
use App\Support\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function __construct(private ProductService $service) {}

    public function index(Request $request)
    {
        $products = $this->service->list($request);

        $data = ProductResource::collection($products)->toArray($request);

        return ApiResponse::success(
            $data,
            'Lista de produtos.',
            200,
            [
                'current_page' => $products->currentPage(),
                'per_page'     => $products->perPage(),
                'total'        => $products->total(),
                'last_page'    => $products->lastPage(),
            ]
        );
    }

    /**
     * Versão adaptada para aceitar um único produto ou um array de produtos.
     */
    public function store(Request $request)
    {
        $input = $request->all();

        // Verifica se é uma lista de produtos (Array de Arrays)
        if (isset($input[0]) && is_array($input[0])) {
            $createdProducts = [];
            
            foreach ($input as $item) {
                // Valida individualmente cada item usando as regras do seu Form Request
                $validator = Validator::make($item, (new StoreProductRequest())->rules());
                
                if ($validator->fails()) {
                    continue; // Ou você pode retornar erro se preferir que pare tudo
                }

                $createdProducts[] = $this->service->create($validator->validated());
            }

            return ApiResponse::success(
                ProductResource::collection($createdProducts), 
                'Produtos criados com sucesso.', 
                201
            );
        }

        // Caso seja apenas um produto (Lógica original)
        $validator = Validator::make($input, (new StoreProductRequest())->rules());
        
        if ($validator->fails()) {
             return ApiResponse::error('Dados inválidos.', 422, $validator->errors());
        }

        $product = $this->service->create($validator->validated());
        return ApiResponse::success(new ProductResource($product), 'Produto criado.', 201);
    }

    public function show(Product $product)
    {
        return ApiResponse::success(new ProductResource($product), 'Produto encontrado.');
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $product = $this->service->update($product, $request->validated());
        return ApiResponse::success(new ProductResource($product), 'Produto atualizado.');
    }

    public function destroy(Product $product)
    {
        $this->service->delete($product);
        return ApiResponse::success(null, 'Produto removido.');
    }
}