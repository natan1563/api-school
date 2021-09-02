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
            'id_turma' => 'required'
        ]);

        $saveInTable = Estudantes::create($request->all());

        if (!$saveInTable) throw new Exception('Falha ao registrar o estudante na base de dados');

        return response()->json(['success' => 'Estudante registrado com sucesso!']);
       } catch (Exception $exception) {
        return response()->json(['error' => $exception->getMessage()], 401);
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
                'id_turma' => 'required'
            ]);

            $estudante = Estudantes::find($id);

            if (is_null($estudante)) throw new Exception('Estudante não encontrado(a)');

            $estudante->nome     = $request->nome;
            $estudante->idade    = $request->idade;
            $estudante->id_turma = $request->id_turma;
            $estudante->save();

            return response()->json(['success' => 'Dados do estudante atualizados com sucesso!']);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 404);
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

        if (!$estudante) return response()->json(['error' => 'Estudante não registrado(a).'], 404);

        return response()->json(['success' => 'Dados do estudante removidos com sucesso!!']);
    }
}
