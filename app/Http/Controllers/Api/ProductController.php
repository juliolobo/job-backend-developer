<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Lista os produtos.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();

        return response()->json([
            'data' => $products,
        ]);
    }

    /**
     * Cria um produto.
     *
     * @param  ProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $product = Product::create($request->all());

        if($product){
            return response()->json([
                "message" => "Produto criado",
                "data" => $product,
            ], 201);
        }
    }

    /**
     * Mostra um produto de acordo com o ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);

        if(!$product){
            return response()->json('O produto não existe', 400);
        }else{
            return response()->json([
                'data' => $product
            ], 200);
        }
    }

    /**
     * Atualiza um produto pelo ID.
     *
     * @param  ProductRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        $product = Product::find($id);

        if(!$product){
            return response()->json('O produto não existe', 400);
        }else{
            $product->fill($request);
            $product->save();

            return response()->json([
                "message" => "Produto atualizado",
                "data" => $product
            ], 200);
        }
    }

    /**
     * Exclui um produto pelo ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        if(!$product){
            return response()->json('O produto não existe', 400);
        }else{
            $product->delete();
            return response()->json([
                "message" => "Produto excluído",
                'success' => $product
            ], 200);
        }
    }
    
    /**
     * Busca produtos pelo nome e pela categoria.
     *
     * @param  string  $name
     * @param  string  $category
     * @return \Illuminate\Http\Response
     */
    public function searchNameCategory($name, $category)
    {
        $products = Product::where('name','LIKE','%'.$name.'%')
            ->where('category','LIKE','%'.$category.'%')
            ->get();

        if ($products->count() === 0) {
            return response()->json('Nenhum produto foi encontrado', 400);
        }else{
            return response()->json([
                'data' => $products
            ], 200);
        }
    }
    
    /**
     * Busca produtos pela categoria.
     *
     * @param  string  $category
     * @return \Illuminate\Http\Response
     */
    public function searchCategory($category)
    {
        $products = Product::where('category', $category)->get();

        if ($products->count() === 0) {
            return response()->json('Nenhum produto foi encontrado', 400);
        }else{
            return response()->json([
                'data' => $products
            ], 200);
        }
    }
    
    /**
     * Busca produtos que têm imagem.
     *
     * @return \Illuminate\Http\Response
     */
    public function searchProductWithImage()
    {
        $products = Product::whereNotNull('image_url')->get();

        if ($products->count() === 0) {
            return response()->json('Nenhum produto foi encontrado', 400);
        }else{
            return response()->json([
                'data' => $products
            ], 200);
        }
    }
    
    /**
     * Busca produtos que não possuem imagem.
     *
     * @return \Illuminate\Http\Response
     */
    public function searchProductWithoutImage()
    {
        $products = Product::whereNull('image_url')->get();

        if ($products->count() === 0) {
            return response()->json('Nenhum produto foi encontrado', 400);
        }else{
            return response()->json([
                'data' => $products
            ], 200);
        }
    }
}
