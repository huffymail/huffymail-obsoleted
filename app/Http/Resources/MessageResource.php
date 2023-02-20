<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'message_id' => $this->message_id,
            'from' => $this->from,
            'to' => $this->to,
            'spam_verdict' => $this->spam_verdict,
            'virus_verdict' => $this->virus_verdict,
            'subject' => $this->subject,
            'html' => $this->html,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
