<?php

namespace App\Http\Controllers;

use App\Models\Estudantes;
use Exception;
use Illuminate\Http\Request;

class EstudantesController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['data' => Estudantes::all()]);
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
            'idade'    => 'required',
            'id_turma' => 'required',
        ]);

        Estudantes::create($request->all());

        return response()->json(['success' => 'Estudante registrado com sucesso!']);
       } catch (Exception $exception) {
        $exceptionCode = $exception->errorInfo[1] ?? $exception->getCode();

        switch($exceptionCode) {
            case 1452:
                $mensagemErro = 'Turma não registrada';
                break;

            default:
                $mensagemErro = 'Um erro inesperado aconteceu, verifique os dados enviados ou tente novamente mais tarde.';
        }

        return response()->json(['error' => $mensagemErro], 404);
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
                'idade'    => 'required',
                'id_turma' => 'required',
            ]);

            $estudante = Estudantes::find($id);

            if (is_null($estudante)) throw new Exception('Estudante não encontrado(a)', 404);

            $estudante->nome      = $request->nome;
            $estudante->idade     = $request->idade;
            $estudante->id_turma  = $request->id_turma;
            $estudante->save();

            return response()->json(['success' => 'Dados do estudante atualizados com sucesso!']);
        } catch (Exception $exception) {

            $exceptionCode = $exception->errorInfo[1] ?? $exception->getCode();
            switch($exceptionCode) {
                case 1452:
                    $mensagemErro = 'Turma não encontrada';
                    break;

                case 404:
                    $mensagemErro = $exception->getMessage();
                    break;

                default:
                    $mensagemErro = 'Um erro inesperado aconteceu, verifique os dados enviados ou tente novamente mais tarde.';
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
        $estudante = Estudantes::destroy($id);

        if (!$estudante) return response()->json(['error' => 'Estudante não encontrado(a).'], 404);

        return response()->json(['success' => 'Estudante removido(a) com sucesso!!']);
    }
}
