


<!-- Updated side bar -->
<nav class="fixed top-0 z-50 w-full bg-green-200 border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
      <div class="flex items-center justify-between">
        <div class="flex items-center justify-start">
          <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
              <span class="sr-only">Open sidebar</span>
              <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                 <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
              </svg>
           </button>
          <a href="#" class="flex ml-2 md:mr-24">
          <img src="{{ asset('assets/img/logo.png') }}" class="h-10 mr-3" alt="AdEMNEA Logo" />
            <!-- <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap dark:text-white">AdEMNEA</span> -->
          </a>
        </div>
        <div class="flex items-center">
            <div class="flex items-center ml-3">
              <div>
                <button type="button" class="flex text-sm bg-gray-600 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" aria-expanded="false" data-dropdown-toggle="dropdown-user">
                  <span class="sr-only">Open user menu</span>
                  <img class="w-8 h-8 rounded-full " src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRouT1MxO_snuDU1Vr64osVJ001_qxGdFA4tMewLyJKxJ8Wp1BzeMpXN3sxcjKLcNA0iF0&usqp=CAU" alt="user photo">
                </button>
              </div>
              <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600" id="dropdown-user">
                <div class="px-4 py-2" role="none">
                  @auth
                  <p class="text-sm text-gray-900 dark:text-white" role="none">
                    {{ Auth::user()->name ?? 'User' }}
                  </p>
                  <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-300" role="none">
                    {{ Auth::user()->email ?? '' }}
                  </p>
                  @else
                  <p class="text-sm text-gray-900 dark:text-white" role="none">
                    Guest User
                  </p>
                  @endauth
                </div>
                <ul class="py-1" role="none">
                  <li>
                    <a href="/logout" style="color: white; background-color:  #dc3545; width: auto; height: 30px; padding: 5px; border-radius: 5px;" class="mx-4 my-2" role="menuitem">Sign out</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
      </div>
    </div>
  </nav>