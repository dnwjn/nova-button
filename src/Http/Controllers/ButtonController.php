<?php

namespace Dnwjn\NovaButton\Http\Controllers;

use Illuminate\Routing\Controller;
use Laravel\Nova\Http\Requests\NovaRequest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ButtonController extends Controller
{
    public function handle(NovaRequest $request)
    {
        $event = $request->event;

        try {
            $resource = $request->findModelQuery()->first();
        } catch (NotFoundHttpException $e) {
            $resource = null;
        }

        event(new $event($request->buttonKey, $resource));

        return response('ok', 200);
    }
}
