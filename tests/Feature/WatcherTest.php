<?php


it('tests watcher', function () {
    $this->artisan('notion:watch')
        ->assertExitCode(0);
})->skip();
