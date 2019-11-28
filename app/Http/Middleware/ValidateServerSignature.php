<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Game;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Routing\Exceptions\InvalidSignatureException;
use Illuminate\Support\Facades\Log;

class ValidateServerSignature
{
    /**
     * The encryption key.
     *
     * @var callable
     */
    protected $key;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->validate($request);

        if ($this->hasValidApp($request) 
            && $this->hasValidSignature($request)) {
            return $next($request);
        }

        throw new InvalidSignatureException;
    }
    
    /**
     * Validate the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validate(Request $request)
    {
        $request->validate([
            'app_id' => 'required|string|max:255',
            'signature' => 'required|string|max:255'
        ]);
    }

    /**
     * Determine if the given request has a valid app_id.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function hasValidApp(Request $request)
    {
        $app = Game::findOrFail($request->input('app_id'));
        // Set encryption key
        $this->key = $app->secret;
        
        return true;
    }

    /**
     * Determine if the given request has a valid signature.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function hasValidSignature(Request $request)
    {
        $original = collect($request->except(['signature', 'token']))->sortKeys()->implode('&');        
        $signature = hash_hmac('sha256', $original, $this->key);

        return  hash_equals($signature, (string) $request->input('signature', ''));
    }
}
