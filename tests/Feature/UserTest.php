<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;
use App\Models\User\User;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @testdox USUARIO TARSICIO CARRIZALES PRUEBA UNITARIAS
 */ 
class UserTest extends TestCase
{
    use RefreshDatabase;
    /** 
     * @test 
     */
    function prueba_acceso_url()
    {
        $this->assertGuest($guard = null);
        $response = $this->get(route('login'));
        $response->assertStatus(200);
        $response->assertViewIs('adminlte::auth.login');


        //$user = factory(User::class)->create();
        //$user = User::factory()->create();
        $user = User::find(1);
        
        //$user = User::ver_User(1);
        //$user = User::find(1);
        //$response = $this->actingAs($user)
          //               ->withSession(['foo' => 'bar'])
            //             ->get('/users');
        //$response = $this->get('/users');
        //$response->assertStatus(200);        
    }

    /** @test */
    function login_displays_validation_errors()
    {
        $response = $this->post(route('login'), []);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('email');
    }
}
