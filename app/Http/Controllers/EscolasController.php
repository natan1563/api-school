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

        $escola = new Escolas;
        $escola->nome     = $request->nome;
        $escola->endereco = $request->endereco;
        $escola->telefone = $this->formatTelephone($request->telefone);
        $escola->save();

        return response()->json(['success' => 'Escola criada com sucesso!'], 201);
       } catch (Exception $exception) {
        $exceptionCode = $exception->errorInfo[1] ?? $exception->getCode();

        switch($exceptionCode) {
            case 1062:
                $mensagemErro = 'Escola já cadastrada';
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
                'nome'     => 'required',
                'endereco' => 'required',
                'telefone' => 'required'
            ]);

            $escola = Escolas::find($id);

            if (is_null($escola)) throw new Exception('Escola não encontrada', 404);

            $escola->nome     = $request->nome;
            $escola->endereco = $request->endereco;
            $escola->telefone = $this->formatTelephone($request->telefone);

            $escola->save();

            return response()->json(['success' => 'Escola atualizada com sucesso!']);

        } catch (Exception $exception) {
            $exceptionCode = $exception->errorInfo[1] ?? $exception->getCode();

            switch($exceptionCode) {
                case 1062:
                    $mensagemErro = 'Escola ja cadastrada';
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
     * Adiciona masca de telefone
     *
     * @return String Telefone com mascara se for elegivel a regex ou numero default passado
     */
    private function formatTelephone($telefone) {
        $telefoneFormatado = preg_replace('/^(\(?\d{2}\)?)\s?(\d{4,5})\-?(\d{4})$/', "$1 $2-$3", $telefone);
        $telefoneFormatado = preg_replace('/[^0-9]/', '', $telefone);

        return preg_replace('/^(\d{2})\s?(\d{4,5})\-?(\d{4})$/', "($1) $2-$3", $telefoneFormatado);
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
