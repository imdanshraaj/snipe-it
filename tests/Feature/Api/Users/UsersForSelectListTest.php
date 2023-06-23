<?php

namespace Tests\Feature\Api\Users;

use App\Models\Company;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\Support\InteractsWithSettings;
use Tests\TestCase;

class UsersForSelectListTest extends TestCase
{
    use InteractsWithSettings;

    public function testUsersAreReturned()
    {
        $users = User::factory()->superuser()->count(3)->create();

        $this->actingAsForApi($users->first())
            ->getJson(route('api.users.selectlist'))
            ->assertOk()
            ->assertJsonStructure([
                'results',
                'pagination',
                'total_count',
                'page',
                'page_count',
            ])
            ->assertJson(fn(AssertableJson $json) => $json->has('results', 3)->etc());
    }

    public function testUsersCanBeSearchedByFirstAndLastName()
    {
        User::factory()->create(['first_name' => 'Luke', 'last_name' => 'Skywalker']);

        $response = $this->actingAsForApi(User::factory()->create())
            ->getJson(route('api.users.selectlist', ['search' => 'luke sky']))
            ->assertOk();

        $results = collect($response->json('results'));

        $this->assertEquals(1, $results->count());
        $this->assertTrue($results->pluck('text')->contains(fn($text) => str_contains($text, 'Luke')));
    }

    public function testUsersScopedToCompanyWhenMultipleFullCompanySupportEnabled()
    {
        $this->settings->enableMultipleFullCompanySupport();

        $jedi = Company::factory()->has(User::factory()->count(3)->sequence(
            ['first_name' => 'Luke', 'last_name' => 'Skywalker', 'username' => 'lskywalker'],
            ['first_name' => 'Obi-Wan', 'last_name' => 'Kenobi', 'username' => 'okenobi'],
            ['first_name' => 'Anakin', 'last_name' => 'Skywalker', 'username' => 'askywalker'],
        ))->create();

        $sith = Company::factory()
            ->has(User::factory()->state(['first_name' => 'Darth', 'last_name' => 'Vader', 'username' => 'dvader']))
            ->create();

        $response = $this->actingAsForApi($jedi->users->first())
            ->getJson(route('api.users.selectlist'))
            ->assertOk();

        $results = collect($response->json('results'));

        $this->assertEquals(3, $results->count());
        $this->assertTrue(
            $results->pluck('text')->contains(fn($text) => str_contains($text, 'Luke'))
        );
        $this->assertFalse(
            $results->pluck('text')->contains(fn($text) => str_contains($text, 'Darth'))
        );
    }

    public function testUsersScopedToCompanyDuringSearchWhenMultipleFullCompanySupportEnabled()
    {
        $this->settings->enableMultipleFullCompanySupport();

        $jedi = Company::factory()->has(User::factory()->count(3)->sequence(
            ['first_name' => 'Luke', 'last_name' => 'Skywalker', 'username' => 'lskywalker'],
            ['first_name' => 'Obi-Wan', 'last_name' => 'Kenobi', 'username' => 'okenobi'],
            ['first_name' => 'Anakin', 'last_name' => 'Skywalker', 'username' => 'askywalker'],
        ))->create();

        Company::factory()
            ->has(User::factory()->state(['first_name' => 'Darth', 'last_name' => 'Vader', 'username' => 'dvader']))
            ->create();

        $response = $this->actingAsForApi($jedi->users->first())
            ->getJson(route('api.users.selectlist', ['search' => 'a']))
            ->assertOk();

        $results = collect($response->json('results'));

        $this->assertEquals(3, $results->count());
        $this->assertTrue($results->pluck('text')->contains(fn($text) => str_contains($text, 'Luke')));
        $this->assertTrue($results->pluck('text')->contains(fn($text) => str_contains($text, 'Anakin')));

        $response = $this->getJson(route('api.users.selectlist', ['search' => 'v']))->assertOk();
        $this->assertEquals(0, collect($response->json('results'))->count());
    }
}
