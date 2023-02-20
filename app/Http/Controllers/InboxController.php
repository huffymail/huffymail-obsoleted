<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class InboxController extends Controller
{
    public function show(Request $request)
    {
        $params = [
            'to' => $request->route('to'),
        ];

        $validator = Validator::make($params, [
            'to' => ['required', 'email'],
        ]);
        if ($validator->fails()) {
            abort(\Symfony\Component\HttpFoundation\Response::HTTP_BAD_REQUEST, $validator->errors()->first());
        }

        $messages = Message::exclude(['html'])
            ->where('to', $params['to'])
            ->orderByDesc('id')
            ->limit(25)
            ->get();

        return Inertia::render('inbox/show', [
            'messages' => $messages,
            'to' => $params['to'],
        ]);
    }
}
