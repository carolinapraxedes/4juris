<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illiminate\Validation\ValidationException;

class ClientController extends Controller
{
    protected $client;

    public function __construct(Client $client){
         $this->client = $client;
    }



    public function index()
    {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        try{
            $client = $this->client->all();
            return response()->json($client,200);
            
        } catch(\Exception $e){
            return response()->json([
                'error' =>  'Error:' . $e->getMessage()
            ], 500);    
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            // Validação dos dados
            $request->validate(
                $this->client->rules(),
                $this->client->feedback()
            );
    
            // Criação do cliente
            $client = $this->client->create([
                'name' => $request->name,
                'user_id' => $request->user_id,
            ]);

            return response()->json($client, 201);
        } catch (ValidationException $e) {

            return response()->json([
                'error' => 'Falha na validação',
                'messages' => $e->validator->errors()
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'error' =>  'Error:' . $e->getMessage()
            ], 500);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  @id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
           
    
            // Verifica se o cliente foi encontrado
            if ($client === null) {
                return response()->json(['error' => 'Client not found'], 404);
            }else{
                // Busca o cliente pelo ID
                $client = $this->client->find($id);
                // Retorna os dados do cliente
                return response()->json($client, 200);
            }
    
        } catch (\Exception $e) {
            // Retorna uma resposta de erro genérica
            return response()->json(['error' => 'Error:'. $e->getMessage()], 500);
        }
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            // Busca o cliente pelo ID
            $client = $this->client->find($id);
    
            // Verifica se o cliente foi encontrado
            if (!$client) {
                return response()->json(['error' => 'Cliente não encontrado'], 404);
            }
    
            // Validação condicional baseada no método da requisição (PATCH ou PUT)
            if ($request->isMethod('patch')) {
                $regrasDinamicas = [];
    
                // Percorre todas as regras definidas no modelo e coleta as aplicáveis
                foreach ($client->rules() as $input => $rule) {
                    if ($request->has($input)) {
                        $regrasDinamicas[$input] = $rule;
                    }
                }
    
                // Valida apenas os campos presentes na requisição PATCH
                $request->validate($regrasDinamicas);
            } else {
                // Validação completa para PUT
                $request->validate($client->rules());
            }
    
            // Atualiza os dados do cliente
            $client->update([
                'name' => $request->name,
                'user_id' => $request->user_id,
            ]);
    
            // Retorna a resposta de sucesso com o cliente atualizado
            return response()->json($client, 200);
        } catch (ValidationException $e) {
          
    
            // Retorna os erros de validação
            return response()->json([
                'error' => 'Falha na validação',
                'messages' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {

        
            // Retorna uma mensagem genérica de erro
            return response()->json([
                'error' =>'Error:'. $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  @id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        try {
            // Busca o cliente pelo ID
            $client = $this->client->find($id);
    
            // Verifica se o cliente foi encontrado
            if (!$client) {
                return response()->json(['error' => 'O cliente não existe'], 404);
            }   
            // Exclui o cliente
            $client->delete();
    
            // Retorna uma mensagem de sucesso
            return response()->json(['message' => 'Cliente apagado com sucesso'], 200);
        } catch (\Exception $e) {
           
    
            // Retorna uma mensagem genérica de erro
            return response()->json(['error' => 'Não foi possível apagar o cliente. Error: '. $e->getMessage()], 500);
        }
    }
}
