<?php

namespace App\Http\Controllers;
use App\Http\Requests\UpdateMembersRequest;
use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::with('project')->get();
        return response()->json($members);
    }

public function store(Request $request)
    {
        try {
            $data = $request->except('foto');

            if ($request->hasFile('foto')) {
                $caminho = $request->file('foto')->store('members', 'public');
                $data['foto'] = asset('storage/' . $caminho);
            }

            $member = Member::create($data);

            return response()->json($member, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show(Member $member)
    {
        $member->load('project');

        return response()->json($member);
    }
    public function update(\Illuminate\Http\Request $request, Member $member)
    {
        try {
            $data = $request->except('foto');
            if ($request->hasFile('foto')) {
                $caminho = $request->file('foto')->store('uploadMembers', 'public');
                $data['foto'] = asset('storage/' . $caminho);
            } else {
                unset($data['foto']);
            }

            $member->update($data);

            return response()->json($member, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function destroy(Member $member)
    {
        $member->delete();
        return response()->json(['message' => 'Membro deletado com sucesso']);
    }
}
