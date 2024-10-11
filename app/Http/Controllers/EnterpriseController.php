<?php

namespace App\Http\Controllers;

use App\Models\Enterprise;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EnterpriseController extends Controller
{
    protected $enterprise;
    

    public function __construct(Enterprise $enterprise){
         $this->enterprise = $enterprise;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $enterprise = $this->enterprise->all();
            return response()->json($enterprise,200);
            
        } catch(\Exception $e){
            return response()->json([
                'error' =>  'Error:' . $e->getMessage()
            ], 500);    
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
                $this->enterprise->rules(),
                $this->enterprise->feedback()
            );
    
            // Criação do cliente
            $client = $this->enterprise->create([
                'name' => $request->name,
                'user_id' => $request->user_id,
            ]);

            return response()->json($client, 201);
        } catch (ValidationException $e) {

            return response()->json([
                'error' => 'Falha na validação',
                'messages' => $e->validator->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' =>  'Error:' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Enterprise  $enterprise
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {    
            // Verifica se o cliente foi encontrado
            if (!$this->enterprise) {
                return response()->json(['error' => 'enterprise not found'], 404);
            }else{
                // Busca o enterprisee pelo ID
                $enterprise = $this->enterprise->find($id);
                // Retorna os dados do enterprisee
                return response()->json($enterprise, 200);
            }
    
        } catch (\Exception $e) {
            // Retorna uma resposta de erro genérica
            return response()->json(['error' => 'Error:'. $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Enterprise  $enterprise
     * @return \Illuminate\Http\Response
     */
    public function edit(Enterprise $enterprise)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Enterprise  $enterprise
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            // Busca o enterprise pelo ID
            $enterprise = $this->enterprise->find($id);
    
            // Verifica se o enterprise foi encontrado
            if (!$enterprise) {
                return response()->json(['error' => 'Empresa não encontrado'], 404);
            }
    
            // Validação condicional baseada no método da requisição (PATCH ou PUT)
            if ($request->isMethod('patch')) {
                $regrasDinamicas = [];
    
                // Percorre todas as regras definidas no modelo e coleta as aplicáveis
                foreach ($enterprise->rules() as $input => $rule) {
                    if ($request->has($input)) {
                        $regrasDinamicas[$input] = $rule;
                    }
                }
    
                // Valida apenas os campos presentes na requisição PATCH
                $request->validate($regrasDinamicas);
            } else {
                // Validação completa para PUT
                $request->validate($enterprise->rules());
            }
    
            // Atualiza os dados do empresa
            $enterprise->update([
                'name' => $request->name,
                'user_id' => $request->user_id,
            ]);
    
            // Retorna a resposta de sucesso com o cliente atualizado
            return response()->json($enterprise, 200);
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
     * @param  \App\Models\Enterprise  $enterprise
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            // Busca o cliente pelo ID
            $enterprise = $this->enterprise->find($id);
    
            // Verifica se o cliente foi encontrado
            if (!$enterprise) {
                return response()->json(['error' => 'O cliente não existe'], 404);
            }   
            // Exclui o cliente
            $enterprise->delete();
    
            // Retorna uma mensagem de sucesso
            return response()->json(['message' => 'Cliente apagado com sucesso'], 200);
        } catch (\Exception $e) {
            // Retorna uma mensagem genérica de erro
            return response()->json(['error' => 'Não foi possível apagar o cliente. Error: '. $e->getMessage()], 500);
        }
    }
}
