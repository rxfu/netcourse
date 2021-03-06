<?php

namespace App\Http\Middleware;

use App\Course;
use Closure;

class CheckCourse {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {
		if ($request->user()->username !== 'admin') {
			if (!Course::whereAssistantId($request->user()->id)->whereId($request->course)->exists()) {
				return redirect('home');
			}
		}

		return $next($request);
	}
}
