<?php

namespace App\Http\Controllers;

use App\Models\Turmas;
use Exception;
use Illuminate\Http\Request;

class TurmasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['data' => Turmas::all()]);
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
            'nome'      => 'required',
            'id_escola' => 'required'
        ]);

        Turmas::create($request->all());

        return response()->json(['success' => 'Turma registrada com sucesso!']);
       } catch (Exception $exception) {

        $exceptionCode = $exception->errorInfo[1] ?? $exception->getCode();

        switch($exceptionCode) {
            case 1452:
                $mensagemErro = 'Escola não registrada';
                $code = 404;
                break;

            case 1062:
                $mensagemErro = 'Turma ja cadastrada';
                $code = 409;
                break;

            default:
                $mensagemErro = 'Um erro inesperado aconteceu, verifique os dados enviados ou tente novamente mais tarde.';
                $code = 400;

        }

        return response()->json(['error' => $mensagemErro], $code);
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
                'nome'      => 'required',
                'id_escola' => 'required'
            ]);

            $turma = Turmas::find($id);

            if (is_null($turma)) throw new Exception('Turma não encontrada', 404);

            $turma->nome      = $request->nome;
            $turma->id_escola = $request->id_escola;
            $turma->save();

            return response()->json(['success' => 'Dados da turma atualizados com sucesso!'], 201);
        } catch (Exception $exception) {
            $exceptionCode = $exception->errorInfo[1] ?? $exception->getCode();

            switch($exceptionCode) {
                case 1452:
                    $mensagemErro = 'Escola não registrada';
                    $code = 404;
                    break;

                case 1062:
                    $mensagemErro = 'Turma ja cadastrada';
                    $code = 409;
                    break;

                case 404:
                    $mensagemErro = $exception->getMessage();
                    $code = 404;
                    break;

                default:
                    $mensagemErro = 'Um erro inesperado aconteceu, verifique os dados enviados ou tente novamente mais tarde.';
                    $code = 400;

            }
            return response()->json(['error' => $mensagemErro], $code);
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
        $turma = Turmas::destroy($id);

        if (!$turma) return response()->json(['error' => 'Turma não registrada.'], 404);

        return response()->json(['success' => 'Turma removida com sucesso!!']);
    }
}
