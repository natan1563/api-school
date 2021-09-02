<?php

namespace App\Http\Controllers;

use App\Models\Escolas;
use Exception;
use Illuminate\Http\Request;

class EscolasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['data' => Escolas::all()]);
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
        $this->validate($request, [
            'nome'     => 'required',
            'endereco' => 'required',
            'telefone' => 'required'
        ]);

        Escolas::create($request->all());

        return response()->json(['success' => 'Escola criada com sucesso!']);
       } catch (Exception $exception) {
        switch($exception->errorInfo[1]) {
            case 1062:
                $mensagemErro = 'Escola ja cadastrada';
                break;

            default:
                $mensagemErro = 'Um erro inesperado aconteceu, por favor tente novamente mais tarde';
        }
        return response()->json(['error' => $mensagemErro], 401);
       }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $this->validate($request, [
                'nome'     => 'required',
                'endereco' => 'required',
                'telefone' => 'required'
            ]);

            $escola = Escolas::find($id);

            if (is_null($escola)) throw new Exception('Escola nao encontrada');

            $escola->nome     = $request->nome;
            $escola->endereco = $request->endereco;
            $escola->telefone = $request->telefone;
            $escola->save();

            return response()->json(['success' => 'Escola atualizada com sucesso!']);

        } catch (Exception $exception) {
            switch($exception->errorInfo[1]) {
                case 1062:
                    $mensagemErro = 'Escola ja cadastrada';
                    break;

                default:
                    $mensagemErro = 'Um erro inesperado aconteceu, por favor tente novamente mais tarde';
            }
            return response()->json(['error' => $mensagemErro], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $escola = Escolas::destroy($id);

        if (!$escola) return response()->json(['error' => 'Escola não registrada.'], 404);

        return response()->json(['success' => 'Escola removida com sucesso!!']);
    }
}
