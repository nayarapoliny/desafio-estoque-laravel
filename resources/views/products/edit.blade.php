@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded shadow">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">✏️ Editar Produto</h1>
        <a href="{{ url('/products') }}" class="text-gray-500 hover:underline text-sm">Cancelar e Voltar</a>
    </div>

    {{-- O formulário aponta para a rota de atualização (PUT) usando URL para fugir da API --}}
    <form action="{{ url('/products/' . $product->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        {{-- Esse campo garante que o Controller saiba que você está na Web e volte com o pop-up --}}
        <input type="hidden" name="_view" value="web">

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Nome do Produto</label>
            <input type="text" name="name" value="{{ old('name', $product->name) }}" 
                   class="w-full border rounded p-2 @error('name') border-red-500 @enderror" required>
            @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Descrição</label>
            <textarea name="description" class="w-full border rounded p-2">{{ old('description', $product->description) }}</textarea>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block text-gray-700 font-bold mb-2">Preço (R$)</label>
                <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" class="w-full border rounded p-2" required>
            </div>
            <div>
                <label class="block text-gray-700 font-bold mb-2">Estoque</label>
                <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" class="w-full border rounded p-2" required>
            </div>
        </div>

        <button type="submit" class="w-full bg-blue-500 text-white font-bold py-3 rounded hover:bg-blue-600 transition">
            Atualizar Produto e Voltar ao Estoque
        </button>
    </form>
</div>
@endsection