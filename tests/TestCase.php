<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Spatie\Permission\Models\Role;

abstract class TestCase extends BaseTestCase
{
    /**
     * Seed 3 role default (super_admin, kompetensi, divisi)
     * yang dipakai di RBAC. Panggil di setUp() test yang butuh.
     */
    protected function seedRoles(): void
    {
        Role::findOrCreate('super_admin');
        Role::findOrCreate('kompetensi');
        Role::findOrCreate('divisi');
    }
}
