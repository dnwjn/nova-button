<?php

namespace Dnwjn\NovaButton\Http\Controllers;

use Illuminate\Routing\Controller;
use Laravel\Nova\Http\Requests\NovaRequest;

class ButtonController extends Controller
{
    public function handle(NovaRequest $request)
    {
        $event = $request->event;
        $resource = isset($request->resourceId) ? $request->findModelQuery()->firstOrFail() : null;

        event(new $event($resource, $request->buttonKey));

        return response('ok', 200);
    }
}
