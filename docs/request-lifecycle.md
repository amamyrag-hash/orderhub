# Laravel Request Lifecycle

This document follows an incoming HTTP request through the Laravel application in this repository. The installed framework version is Laravel Framework 13.39.0 (composer.lock). The main framework source files are under vendor/laravel/framework/src/Illuminate/.

## Request flow at a glance

```text
Client (browser / Postman)
        |
        v
public/index.php
  - Composer autoloader
  - bootstrap/app.php
  - Request::capture()
        |
        v
Illuminate\Foundation\Application::handleRequest()
        |
        v
Illuminate\Foundation\Http\Kernel::handle()
        |
        v
Kernel bootstrap
  - environment and configuration
  - exception handling and facades
  - register Service Providers
  - boot Service Providers
        |
        v
Global middleware pipeline
        |
        v
Router: match the incoming request to a Route
        |
        v
Route middleware pipeline
        |
        v
Route action
  - ControllerDispatcher -> Controller method
  - or a route Closure
        |
        v
Response is prepared and returned
        |
        v
Response::send() -> Kernel::terminate()

 the global middleware pipeline. A global middleware can inspect or modify the request, pass it to the next middleware using $next($request), or stop the pipeline by returning a Response early.
If the global pipeline continues, the Kernel dispatches the request to Illuminate\Routing\Router. The Router matches the request's HTTP method and URI to a registered Route. Once a route is matched, the Router gathers and runs that route's middleware in a separate pipeline. Therefore, route middleware such as authentication runs after route matching; it is not all executed before the Router.
Relevant source files:
bootstrap/app.php (withMiddleware() configuration)
vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php (sendRequestThroughRouter(), dispatchToRouter())
vendor/laravel/framework/src/Illuminate/Routing/Router.php (dispatch(), dispatchToRoute(), findRoute(), runRouteWithinStack())
vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php
6. Controller and Response
After route middleware allows the request to continue, Laravel runs the route action. For a controller route, Illuminate\Routing\Route::runController() asks Illuminate\Routing\ControllerDispatcher to dispatch the request to the selected controller method. The controller is resolved through the container, and method dependencies can also be resolved. A route may instead use a Closure; both are valid route actions.
The Router prepares the action's result as an HTTP Response. That Response travels back out through the middleware pipeline, is returned by the Kernel, and is sent to the client by Application::handleRequest(). Finally, the Kernel's terminate() method runs termination work, including terminable middleware and application termination callbacks.
Relevant source files:
vendor/laravel/framework/src/Illuminate/Routing/Route.php (run(), runController(), getController())
vendor/laravel/framework/src/Illuminate/Routing/ControllerDispatcher.php
vendor/laravel/framework/src/Illuminate/Routing/Router.php (prepareResponse())
vendor/laravel/framework/src/Illuminate/Foundation/Application.php (handleRequest())
vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php (terminate())
Repository note
At the time this document was written, this repository's bootstrap/app.php registers routes/web.php and does not register an routes/api.php file. routes/web.php currently contains a Closure route for /; app/Http/Controllers/Controller.php is only the base controller. The Controller section above describes the framework path used when a route is defined with a controller action; it does not claim that this repository currently has a feature controller route.