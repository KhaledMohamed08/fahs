<?php

function collectQueryParams(array $except = []): array
{
    return collect(request()->query())
        ->except($except)
        ->filter()
        ->toArray();
}
