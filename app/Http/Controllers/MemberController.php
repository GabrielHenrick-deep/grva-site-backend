<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMembersRequest;
use App\Http\Requests\UpdateMembersRequest;
use App\Models\Member;

class MemberController extends Controller
{
    public function index()
    {
        return Member::with('projects')->get();
    }

   public function store(\Illuminate\Http\Request $request) 
    {
        try {
            $member = Member::create($request->all());
            return response()->json($member, 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }

    public function show(Member $member)
    {
    
        $member->load('projects'); // Carrega os projetos relacionados

        return response()->json($member);
    }

// Mude de UpdateMembersRequest para Request
    public function update(\Illuminate\Http\Request $request, Member $member)
    {
        try {
            $member->update($request->all());
            return response()->json($member, 200);
        } catch (\Exception $e) {
            // Isso vai retornar o erro real para o seu console do navegador
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy(Member $member)
    {
        $member->delete();
        return response()->json(['message' => 'Membro deletado com sucesso']);
    }
}
