<x-tenant-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('users') }}
            <x-btn-link class="ml-4 float-right" href="{{route('users.create')}}">Add  User</x-btn-link>

        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                {{-- <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div> --}}
                {{-- <x-btn-link href="">Tenants</x-btn-link> --}}
                
    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-700" >
            <thead class="text-xs text-gray-700 uppercase bd-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">number</th>

                <th scope="col" class="px-6 py-3">name</th>
                <th scope="col" class="px-6 py-3">email</th>
                <th scope="col" class="px-6 py-3">role</th>
                <th scope="col" class="px-6 py-3">Action</th>

                {{-- <th>password</th> --}}
            </tr>
        </thead>
         <tbody>
            @foreach($user as $user)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <td class="px-6 py-4">{{ $loop->iteration }}</td>
                <td class="px-6 py-4">{{ $user->name }}</td>
                <td class="px-6 py-4">{{ $user->email }}</td>
                  <td class="px-6 py-4">   
                 @foreach($user->roles as $role)
                 {{ $role->name }} {{$loop->last?'':','}}
                 @endforeach
                  </td>
               
 <td class="px-6 py-4">
  <x-btn-link href="{{route('users.edit',$user->id)}}">Edit</x-btn-link>
 </td>
                
            </tr>
         @endforeach
        </tbody>
        </table>
    </div>
            </div>
        </div>
    </div>


</x-tenant-app-layout>
