<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class InboxMessageController extends Controller
{
    public function show(Request $request)
    {
        $params = [
            'message_id' => $request->route('message_id'),
            'to' => $request->route('to'),
        ];

        $validator = Validator::make($params, [
            'message_id' => ['required', 'string', 'min:40'],
            'to' => ['required', 'email'],
        ]);
        if ($validator->fails()) {
            abort(\Symfony\Component\HttpFoundation\Response::HTTP_BAD_REQUEST, $validator->errors()->first());
        }

        $message = Message::where('message_id', $params['message_id'])->first();
        if ($message === null || $message->to !== $params['to']) {
            abort(\Symfony\Component\HttpFoundation\Response::HTTP_NOT_FOUND);
        }

        return Inertia::render('inbox/message/show', [
            'message' => $message,
        ]);
    }
}
