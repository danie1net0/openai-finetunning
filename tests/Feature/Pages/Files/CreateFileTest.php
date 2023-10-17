<?php

use function Pest\Laravel\get;

it('should show create file page', function (): void {
    get(route('files.create'))->assertOk();
});
