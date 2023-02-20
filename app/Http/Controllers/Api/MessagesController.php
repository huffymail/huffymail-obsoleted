<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MessageResource;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MessagesController extends Controller
{
    public function index(Request $request)
    {
        $params = [
            'to' => $request->get('to'),
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

        return MessageResource::collection($messages);
    }

    public function show(Request $request)
    {
        $params = [
            'slug' => $request->route('slug'),
        ];

        $validator = Validator::make($params, [
            'slug' => ['required', 'string', 'size:40'],
        ]);
        if ($validator->fails()) {
            abort(\Symfony\Component\HttpFoundation\Response::HTTP_NOT_FOUND);
        }

        $message = Message::where('message_id', $params['slug'])->first();
        if (is_null($message)) {
            abort(\Symfony\Component\HttpFoundation\Response::HTTP_NOT_FOUND);
        }

        return new MessageResource($message);
    }
}
