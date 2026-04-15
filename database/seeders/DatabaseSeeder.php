<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Opcional: Limpa a tabela antes de inserir para não duplicar se rodares o comando de novo
        // DB::table('products')->truncate(); 

        $products = [
            // --- MOUSES ---
            ['name' => 'Mouse Gamer Logitech G203', 'description' => 'Mouse RGB com sensor de 8000 DPI, design clássico de 6 botões.', 'price' => 149.90, 'stock' => 35],
            ['name' => 'Mouse Sem Fio Razer Basilisk X', 'description' => 'Tecnologia Hyperspeed, sensor de 16000 DPI, bateria longa.', 'price' => 329.50, 'stock' => 12],
            ['name' => 'Mouse Gamer Redragon Cobra', 'description' => 'Chroma RGB, 10000 DPI ajustável, 7 botões programáveis.', 'price' => 119.90, 'stock' => 50],

            // --- TECLADOS ---
            ['name' => 'Teclado Mecânico HyperX Alloy Origins', 'description' => 'Switches HyperX Red, estrutura em alumínio, iluminação RGB.', 'price' => 459.00, 'stock' => 20],
            ['name' => 'Teclado Mecânico Redragon Kumara', 'description' => 'Switch Outemu Blue, formato TKL (sem teclado numérico), LED vermelho.', 'price' => 189.90, 'stock' => 45],
            ['name' => 'Teclado Gamer Razer Cynosa V2', 'description' => 'Teclas silenciosas, RGB individual por tecla, resistente a respingos.', 'price' => 279.90, 'stock' => 18],

            // --- HEADSETS ---
            ['name' => 'Headset Gamer HyperX Cloud Stinger 2', 'description' => 'Áudio espacial DTS, microfone com cancelamento de ruído.', 'price' => 249.90, 'stock' => 25],
            ['name' => 'Headset Gamer Logitech G432', 'description' => 'Som surround 7.1, drivers de 50mm, almofadas de couro sintético.', 'price' => 319.00, 'stock' => 15],
            ['name' => 'Headset Husky Snow', 'description' => 'Som estéreo, LED azul, haste ajustável, ótimo custo-benefício.', 'price' => 89.90, 'stock' => 60],

            // --- MONITORES ---
            ['name' => 'Monitor Gamer LG UltraGear 24', 'description' => 'Tela IPS, 144Hz de taxa de atualização, 1ms de tempo de resposta.', 'price' => 999.00, 'stock' => 10],
            ['name' => 'Monitor Samsung Odyssey G3', 'description' => 'Tela de 27 polegadas, 165Hz, tela plana com ajuste de altura.', 'price' => 1249.00, 'stock' => 8],
            ['name' => 'Monitor AOC Hero 24', 'description' => 'Painel VA, 144Hz, AMD FreeSync Premium, bordas ultrafinas.', 'price' => 889.90, 'stock' => 14],

            // --- GABINETES ---
            ['name' => 'Gabinete Gamer Corsair 4000D Airflow', 'description' => 'Painel frontal otimizado para fluxo de ar, lateral em vidro temperado.', 'price' => 549.90, 'stock' => 7],
            ['name' => 'Gabinete NZXT H510', 'description' => 'Design minimalista compacto, barra de gerenciamento de cabos.', 'price' => 629.00, 'stock' => 5],
            ['name' => 'Gabinete Pichau Apus Black', 'description' => 'Frente em mesh, lateral de vidro temperado, 3 ventoinhas RGB.', 'price' => 239.90, 'stock' => 22],

            // --- PLACAS-MÃE ---
            ['name' => 'Placa Mãe Asus TUF Gaming B550M-Plus', 'description' => 'Socket AM4 para AMD Ryzen, suporte a PCIe 4.0, VRM reforçado.', 'price' => 959.00, 'stock' => 12],
            ['name' => 'Placa Mãe Gigabyte B660M DS3H', 'description' => 'Socket LGA 1700 para Intel 12ª/13ª geração, suporte a DDR4.', 'price' => 789.90, 'stock' => 15],
            ['name' => 'Placa Mãe MSI A520M-A PRO', 'description' => 'Placa de entrada para AMD Ryzen (AM4), suporte a memórias rápidas.', 'price' => 429.90, 'stock' => 30],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}