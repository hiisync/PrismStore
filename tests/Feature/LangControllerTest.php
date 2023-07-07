<?php

namespace Tests\Feature;

use App\Http\Controllers\LangController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class LangControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test switching the language of the application
     *
     * @return void
     */
    public function testIndex()
    {
        // Define the supported locales
        $locales = ['en', 'uk'];

        // Make a GET request to a previous page to simulate a redirect
        $previousUrl = 'http://localhost/previous';
        $response = $this->withHeaders(['Referer' => $previousUrl])->get(route('lang', ['locale' => 'en']));

        // Iterate through the locales and test each one
        foreach ($locales as $locale) {
            // Make a GET request to the LangController with the locale parameter
            $response = $this->get(route('lang', ['locale' => $locale]));

            // Assert that the application locale and session locale have been updated
            $this->assertEquals($locale, App::getLocale());
            $this->assertEquals($locale, session('locale'));

            // Assert that the response is a redirect back to the previous page or home page
            if ($previousUrl) {
                $response->assertRedirect($previousUrl);
            } else {
                $response->assertRedirect(route('home'));
            }

            // Assert that the response is an instance of Response
            $this->assertInstanceOf(Response::class, $response->baseResponse);
        }
    }
}
