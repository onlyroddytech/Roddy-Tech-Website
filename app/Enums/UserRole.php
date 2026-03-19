<?php

namespace App\Enums;

/**
 * UserRole Enum
 *
 * Defines the four access roles on the platform.
 *
 *   Admin     — Full control: manage all projects, users, CMS, payments, referrals.
 *               Redirected to /admin/projects after login.
 *   Client    — Can view their own projects, send messages, and track payments.
 *               Redirected to /dashboard after login.
 *   Supporter — Community/helper role. Future dashboard planned.
 *   Referral  — Partner who earns commissions for referring new clients.
 *
 * Cast automatically on User model via $casts: $user->role === UserRole::Admin
 * Enforced in routes via 'role:admin' and 'role:client' middleware aliases.
 */
enum UserRole: string
{
    case Admin     = 'admin';
    case Client    = 'client';
    case Supporter = 'supporter';
    case Referral  = 'referral';

    public function label(): string
    {
        return match($this) {
            self::Admin     => 'Administrator',
            self::Client    => 'Client',
            self::Supporter => 'Supporter',
            self::Referral  => 'Referral Partner',
        };
    }

    public function isAdmin(): bool    { return $this === self::Admin; }
    public function isClient(): bool   { return $this === self::Client; }
}
