<?php

use function Pest\Laravel\get;

it('should show create job page', function (): void {
    get(route('jobs.create'))->assertOk();
});
