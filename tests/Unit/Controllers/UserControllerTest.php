<?php

namespace Tests\Unit\Controllers;

use Tests\TestCase;
use App\Models\User;
use App\Http\Controllers\Admin\UserController;
use App\Http\Requests\UserAddRequest;
use App\Http\Requests\UserEditRequest;
use Illuminate\Support\Facades\Route;

class UserControllerTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->artisan('migrate:fresh --seed');
    }
    //  validate_add_user
    function testValidationAddUser()
    {
        $request = new UserAddRequest();

        $this->assertEquals(
            [
                'name' => 'required|alpha_num|min:3|max:255',
                'password' => 'required|confirmed|min:6',
                'password_confirmation' => 'min:6',
                'role_id' => 'required',
                'email' => 'email|unique:users',
            ],
            $request->rules()
        );
    }
    //  validate_edit
    function testValidationEdit()
    {
        $request = new UserEditRequest();

        $this->assertEquals(
            [
                'name' => 'min:3|max:255',
                'password' => 'nullable|confirmed|min:6',
                'password_confirmation' => 'nullable|min:6',
                'email' => 'email',
            ],
            $request->rules(),
        );
    }
    //  test_name_require
    public function testStoreUserEmpty()
    {
        $response = $this->post('admin/user/store',
            [
                'name' => '',
                'email' => 'jmac@example.com',
                'password' => 'password',
                'password_confirmation' => 'password',
                'role_id' => 1,
            ]
        );
        
        $response->assertSessionHasErrors('name');
    }
    //  test_return_form_create
    public function testCreateReturnsView()
    {
        $controller = new UserController();

        $view = $controller->create();

        $this->assertEquals('admin.pages.addUser', $view->getName());
    }
    //  test_create
    public function testStoreUser()
    {
        $user = $this->post('admin/user/store',
            [
                'name' => 'JMac',
                'email' => 'jmac@example.com',
                'password' => 'password',
                'password_confirmation' => 'password',
                'role_id' => 1,
            ]
        );
        
        $this->assertDatabaseHas('users', ['name' => 'JMac']);
        $user->assertRedirect(route('user.index'));
    }
    //  test_delete_by_id
    public function testDeleteUser()
    {
        $user = $this->delete('admin/user/delete/3');
        
        $user->assertRedirect(route('user.index'));
    }
    //  test_return_form_edit
    public function testEditReturnsView()
    {
        $userInfo = ['id' => 21];
        $user = new User($userInfo);
        $controller = new UserController();
        $view = $controller->edit($user);
        
        $this->assertEquals('admin.pages.editUser', $view->getName());
    }
    //test update
    public function testUpdateUser()
    {
        $user = $this->put(
            'admin/user/update/2',
                [
                    'name' => 'JMacUpdate',
                    'email' => 'JMacUpdate@gmail.com',
                ]
            );

        $this->assertDatabaseHas('users', ['name' => 'JMacUpdate']);
        $user->assertRedirect(route('user.index'));
    }
    //check search
    public function testCheckSearch()
    {
        $user = $this->get('admin/user/search')
            ->assertViewHas('searchKeyWord');
    }
}
