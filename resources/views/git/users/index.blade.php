<x-app-layout>
    <x-slot name="header">
        <div class="row justify-content-between">
            <div class="col-sm-2">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight mr-auto">
                    {{ __('Git Users') }}
                </h2>
            </div>
            <div class="col-sm-4">
                <form action="{{ route('git.users') }}" method="post">
                    <div class="input-group">
                        @csrf
                        <input name="search" type="text" class="form-control" placeholder="Search">
                        <button  class="btn btn-outline-secondary" type="submit">Search</button>
                        <button name="getUsers" class="btn btn-primary" type="submit" >Get Users</button>
                    </div>
                </form>
            </div>
        </div>
    </x-slot>

    @if(($error ?? null))
    <div class="pt-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                {{ $error->message }}<br>
                <button class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>
    @endif
    @if(session('error.limit'))
    <div class="pt-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                A maximum of 10 users can be listed in the table!
                <button class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <th>#</th>
                            <th>Name</th>
                            <th>Login</th>
                            <th>Company</th>
                            <th>Followers</th>
                            <th>Public Repositories</th>
                            <th>Avg. Followers</th>
                        </thead>
                        <tbody>
                            @php $i = 1 @endphp
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->login }}</td>
                                <td>{{ $user->company }}</td>
                                <td>{{ $user->followers }}</td>
                                <td>{{ $user->public_repos }}</td>
                                <td>{{ $user->avg_follower }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
