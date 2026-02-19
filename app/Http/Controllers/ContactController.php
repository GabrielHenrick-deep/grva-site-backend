<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        Mail::raw("Mensagem de {$validated['name']} ({$validated['email']}):\n\n{$validated['message']}", function ($message) {
            $message->to('linckgamer.lg@gmil.com')
                    ->subject('Mensagem do site');
        });

        return response()->json(['message' => 'Email enviado com sucesso!']);
    }
}
