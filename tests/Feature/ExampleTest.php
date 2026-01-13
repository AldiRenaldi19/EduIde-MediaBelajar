<?php

test('the application returns a successful response', function () {
    // Ensure in-memory database has the schema for the homepage query
    $this->artisan('migrate');

    $response = $this->get('/');

    $response->assertStatus(200);
});
