<?php 

namespace HskyZhou\Chat\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\User;

class FindController extends Controller
{
	use ValidatesRequests;

	public function index()
	{

		$users = User::all();
		$user = auth()->user();

		return view('hskychat::find.index')->with(compact('users', 'user'));
	}
}