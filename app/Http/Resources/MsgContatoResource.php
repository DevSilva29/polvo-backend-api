<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MsgContatoResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->msgContato_id,
            'firstName' => $this->msgContato_name,
            'lastName' => $this->msgContato_lastname,
            'email' => $this->msgContato_email,
            'phone' => $this->msgContato_phone,
            'address' => $this->msgContato_adress,
            'userType' => $this->msgContato_type,
            'message' => $this->msgContato_msg,
            'read' => (bool) $this->msgContato_read,
        ];
    }
}
