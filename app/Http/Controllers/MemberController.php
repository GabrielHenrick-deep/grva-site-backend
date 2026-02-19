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

    public function store(StoreMembersRequest $request)
    {
        $member = Member::create($request->all());
        return response()->json($member, 201);
    }

    public function show(Member $member)
    {
    
        $member->load('projects'); // Carrega os projetos relacionados

        return response()->json($member);
    }

    public function update(UpdateMembersRequest $request, Member $member)
    {
        $member->update($request->all());
        return response()->json($member, 200);
    }

    public function destroy(Member $member)
    {
        $member->delete();
        return response()->json(['message' => 'Membro deletado com sucesso']);
    }
}
