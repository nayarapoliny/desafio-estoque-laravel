@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto bg-white p-8 rounded shadow">
    
    {{-- Alerta de Sucesso (O Pop-up verde!) --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
            <strong class="font-bold">Sucesso!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">📦 Estoque de Produtos</h1>
        {{-- Usando url() para garantir que vá para a Web --}}
        <a href="{{ url('/products/create') }}" class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600 transition">
            + Novo Produto
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 text-gray-700 uppercase text-sm">
                    <th class="p-4 border-b">ID</th>
                    <th class="p-4 border-b">Nome</th>
                    <th class="p-4 border-b">Preço</th>
                    <th class="p-4 border-b">Estoque</th>
                    <th class="p-4 border-b text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr class="hover:bg-gray-50 border-b">
                        <td class="p-4">{{ $product->id ?? $product['id'] }}</td>
                        <td class="p-4 font-medium text-gray-900">{{ $product->name ?? $product['name'] }}</td>
                        <td class="p-4">R$ {{ number_format($product->price ?? $product['price'], 2, ',', '.') }}</td>
                        <td class="p-4">{{ $product->stock ?? $product['stock'] }}</td>
                        <td class="p-4 text-center space-x-4">
                            
                            {{-- Botão Editar --}}
                            <a href="{{ url('/products/' . ($product->id ?? $product['id']) . '/edit') }}" class="text-blue-500 font-medium hover:text-blue-700 transition">
                                Editar
                            </a>

                            {{-- Botão Excluir (Com a correção para evitar a API) --}}
                            <form action="{{ url('/products/' . ($product->id ?? $product['id'])) }}" method="POST" class="inline-block" onsubmit="return confirm('Tem certeza que deseja excluir este produto?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 font-medium hover:text-red-700 transition">
                                    Excluir
                                </button>
                            </form>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-4 text-center text-gray-500">
                            Nenhum produto encontrado no estoque.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginação (Se os produtos forem paginados, os botões aparecem aqui) --}}
    <div class="mt-6">
        @if(method_exists($products, 'links'))
            {{ $products->links() }}
        @endif
    </div>
</div>
@endsection