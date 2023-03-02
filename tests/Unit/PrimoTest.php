<?php

namespace Tests\Unit;

use Tests\TestCase;

class PrimoTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testDatabase()
    {
        $this->assertDatabaseHas('users', [
            'name' => 'Amministratore',
            'email' => 'admin@example.com'
        ]);
    }
}
