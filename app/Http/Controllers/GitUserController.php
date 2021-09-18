<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;

class GitUserController extends Controller
{
    public function index(Request $request)
    {
        if($request->has('getUsers')) return $this->getGitUsers();
        if($request->has('search')) return $this->search($request->input('search'));

        // $users = Cache::get('gitUsers');

        return view('git/users/index', [
            'users' => collect($this->getUsers())->sortBy('name'),
        ]);
    }

    private function addUser($userInfo)
    {
        $users = $this->getUsers();

        if(count($users) == 10)
        {
            Log::channel('error')->alert('Reached the maximum number of captured users (10)');
            return back()->with('error.limit', 'Reached the maximum number of captured users (10)');
        }

        $user = array(
            'name' => $userInfo->name,
            'login' => $userInfo->login,
            'company' => $userInfo->company,
            'followers' => $userInfo->followers,
            'public_repos' => $userInfo->public_repos,
            'avg_follower' => number_format($userInfo->followers / $userInfo->public_repos)
        );

        array_push($users, $user);

        Redis::set($userInfo->login, json_encode($user));
        Redis::expire($userInfo->login, 120);

        // Cache::put('gitUsers', $users, 120);
        Redis::set('gitUsers', json_encode($users));
        Redis::expire('gitUsers', 120);
    }

    private function getUsers()
    {
        return (json_decode(Redis::get('gitUsers')) ?? array());
    }

    public function getGitUsers()
    {
        $users = $this->getUsers();
        
        if(count($users) < 10)
        {    
            Log::channel('info')->info("Consumming 'https://api.github.com/users' Git API");
            $gitUsers = APIController::get(
                'https://api.github.com/users', 
                [ 
                    'Accept'=>'application/vnd.github.v3+json', 
                ], 
                [ 
                    'per_page' => (count($users) == 0 ? 10 : 10 - count($users))
                ])->object();
    
            if(is_object($gitUsers))
                if(property_exists($gitUsers, 'message'))
                {
                    Log::channel('error')->alert("{$gitUsers->message}\n{$gitUsers->documentation_url}");
                    return view('git/users/index', [
                        'users' => [],
                        'error' => $gitUsers
                    ]);
                }
    
            foreach($gitUsers as $user)
            {
                // $check = Cache::get($user->login);
                $check = json_decode(Redis::get($user->login));
                if(!$check)
                {
                    Log::channel('info')->info("Consumming 'https://api.github.com/users/{$user->login}' Git API");
                    $userInfo = APIController::get(
                        "https://api.github.com/users/{$user->login}", [ 
                            'Accept'=>'application/vnd.github.v3+json', 
                        ])->object();
                    
                    if(is_object($userInfo))
                        if(property_exists($userInfo, 'message'))
                        {
                            Log::channel('error')->alert("{$userInfo->message}\n{$userInfo->documentation_url}");
                            return view('git/users/index', [
                                'users' => [],
                                'error' => $userInfo
                            ]);
                        }
        
                    $this->addUser($userInfo);
                }
            }    
        }

        return back();
    }

    public function search($login)
    {
        Log::channel('info')->info("Searching for Git Login: '$login'");

        $check = json_decode(Redis::get($login));
        if(!$check)
        {
            $userInfo = APIController::get(
                "https://api.github.com/users/{$login}", [ 
                    'Accept'=>'application/vnd.github.v3+json', 
                ])->object();
            
            if(is_object($userInfo))
                if(property_exists($userInfo, 'message'))
                {
                    Log::channel('error')->alert("{$userInfo->message}\n{$userInfo->documentation_url}");
                    return view('git/users/index', [
                        'users' => [],
                        'error' => $userInfo
                    ]);
                }

            $this->addUser($userInfo);
        }

        return back();
    }
}
