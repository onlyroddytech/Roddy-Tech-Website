<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * ContactMessage Model
 *
 * Stores messages submitted via the public /contact form.
 * Admin can view all messages at /admin/contact-messages.
 */
class ContactMessage extends Model
{
    protected $fillable = ['name', 'email', 'subject', 'service', 'message', 'read'];

    protected function casts(): array
    {
        return ['read' => 'boolean'];
    }

    public function scopeUnread($query)
    {
        return $query->where('read', false);
    }
}
