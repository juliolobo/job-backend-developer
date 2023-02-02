<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Product;

class ProductCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:import {--id= : ID do produto a ser importado}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Com esse comando é possível importar produtos da API https://fakestoreapi.com/docs';
    protected Product $product;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->product = new Product;
    }

    /**
     * Executa o comando.
     *
     * @return int
     */
    public function handle()
    {
        $id = $this->option('id') ? '/'.$this->option('id') : '';
        $result = Http::get('https://fakestoreapi.com/products'.$id);

        if($id){
            $return = self::importaUm($result);
        }else{
            $return = self::importaVarios($result);
        }

        return $return;
    }

    /**
     * Importa um produto pelo ID da API externa.
     *
     * @param json $result
     * @return info
     */
    public function importaUm($result)
    {
        $arrData = $result->json();

        if(!isset($arrData['id'])){
            return $this->error('Não existe produto com esse ID na API externa');
        }else{
            $product = self::saveProduct($arrData);

            if($product){
                return $this->info("O produto '{$product['name']}' foi adicionado/atualizado com sucesso");
            }else{
                return $this->info("Houve um erro ao adicionar o produto '{$arrData['title']}' ao banco de dados");
            }
        }
    }

    /**
     * Importa vários produtos da API externa.
     *
     * @param json $result
     * @return info
     */
    public function importaVarios($result)
    {
        $this->info("Importando produtos da API externa");

        $arrData = $result->json();

        foreach($arrData as $data){
            if(!isset($data['id'])){
                return $this->error('Não existe produto com esse ID na API externa');
            }else{
                $product = self::saveProduct($data);

                if($product){
                    $this->info("O produto '{$product['name']}' foi adicionado/atualizado com sucesso");
                }else{
                    $this->info("Houve um erro ao adicionar o produto '{$data['title']}' ao banco de dados");
                }
            }
        }

        return $this->info("Importação finalizada");
    }

    /**
     * Cria ou atualiza um produto vindo da API externa.
     *
     * @param array $array
     * @return Product
     */
    private function saveProduct(array $array): Product
    {
        $product = $this->product->query()->updateOrCreate(
            [
                "name" => $array['title'],
            ],
            [
                "price"       => $array['price'],
                "category"    => $array['category'],
                "description" => $array['description'],
                "image_url"   => $array['image'],
            ]
        );

        return $product;
    }
}
