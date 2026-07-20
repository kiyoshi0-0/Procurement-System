@extends('layouts.app')

@section('content')

    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-6xl font-bold text-gray-900 pb-5">Settings</h1>
        <div class="flex items-center pl-1 space-x-3 text-sm text-gray-500 mt-1">
            <span>Manage system preferences, data, and access controls</span>
        </div>
    </div>


    <form action="#" method="POST" class="space-y-6" onsubmit="event.preventDefault();">

        <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-md space-y-6">
            <div class="flex items-center space-x-4">
                <div class="bg-[#C2E7FF]/50 p-4 rounded-2xl text-[#1E3A8A]">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127c.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.43l-1.003.767c-.3.23-.45.62-.41.99c.01.079.02.16.02.242 0 .082-.01.162-.02.242-.04.37.11.76.41.99l1.004.767a1.125 1.125 0 01.26 1.43l-1.297 2.247a1.125 1.125 0 01-1.37.491l-1.216-.456c-.356-.133-.751-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.43l1.004-.767c.304-.233.454-.622.411-.992a5.417 5.417 0 010-.484c.043-.37-.107-.76-.411-.992l-1.004-.767a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.073 1.076-.124c.072-.044.146-.087.22-.128c.332-.183.582-.495.644-.869l.214-1.28z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900 leading-tight">General</h2>
                    <p class="text-[13px] font-medium text-gray-500">Configure basic system settings</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
                <div class="flex flex-col">
                    <label class="text-[11px] font-bold text-gray-700 mb-1.5">Organization Email</label>
                    <input type="email" value="bsit26@procurement.com"
                        class="bg-bg-input border border-gray-300 rounded-md px-3 py-1.5 text-xs font-semibold text-gray-800 focus:outline-none focus:border-brand-green shadow-sm w-full">
                </div>
                <div class="flex flex-col">
                    <label class="text-[11px] font-bold text-gray-700 mb-1.5">Date Format</label>
                    <div class="relative">
                        <select
                            class="bg-bg-input border border-gray-300 rounded-md px-3 py-1.5 text-xs font-semibold text-gray-800 focus:outline-none focus:border-brand-green cursor-pointer appearance-none w-full">
                            <option selected>MM/DD/YY</option>
                            <option>DD/MM/YYYY</option>
                            <option>YYYY-MM-DD</option>
                        </select>
                        <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none text-gray-500">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col">
                    <label class="text-[11px] font-bold text-gray-700 mb-1.5">Time Format</label>
                    <div class="relative">
                        <select
                            class="bg-bg-input border border-gray-300 rounded-md px-3 py-1.5 text-xs font-semibold text-gray-800 focus:outline-none focus:border-brand-green cursor-pointer appearance-none w-full">
                            <option selected>24-Hour (00:00-24:00)</option>
                            <option>12-Hour (AM/PM)</option>
                        </select>
                        <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none text-gray-500">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col">
                    <label class="text-[11px] font-bold text-gray-700 mb-1.5">Default Currency</label>
                    <div class="relative">
                        <select
                            class="bg-bg-input border border-gray-300 rounded-md px-3 py-1.5 text-xs font-semibold text-gray-800 focus:outline-none focus:border-brand-green cursor-pointer appearance-none w-full">
                            <option selected>PHP - Philippine Peso</option>
                            <option>USD - US Dollar</option>
                            <option>EUR - Euro</option>
                        </select>
                        <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none text-gray-500">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-5 pt-1">
                <div class="flex flex-col">
                    <label class="text-[11px] font-bold text-gray-700 mb-1.5">System Language</label>
                    <div class="relative">
                        <select
                            class="bg-bg-input border border-gray-300 rounded-md px-3 py-1.5 text-xs font-semibold text-gray-800 focus:outline-none focus:border-brand-green cursor-pointer appearance-none w-full">
                            <option selected>English</option>
                            <option>Filipino</option>
                            <option>Spanish</option>
                        </select>
                        <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none text-gray-500">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col">
                    <label class="text-[11px] font-bold text-gray-700 mb-1.5">Time Zone</label>
                    <div class="relative">
                        <select
                            class="bg-bg-input border border-gray-300 rounded-md px-3 py-1.5 text-xs font-semibold text-gray-800 focus:outline-none focus:border-brand-green cursor-pointer appearance-none w-full">
                            <option selected>(GMT+8:00) Asia/Manila</option>
                            <option>(GMT-5:00) Eastern Time</option>
                            <option>(GMT+0:00) UTC</option>
                        </select>
                        <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none text-gray-500">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col">
                    <label class="text-[11px] font-bold text-gray-700 mb-1.5">Database Backup</label>
                    <div class="flex items-center space-x-3 h-8.5">
                        <button type="button"
                            class="border border-gray-400 text-gray-800 hover:bg-gray-50 font-bold text-[10px] px-3 py-1.5 rounded uppercase tracking-wide transition-colors">UPDATE</button>
                        <span class="text-[10px] text-gray-400 font-bold whitespace-nowrap">Last back up: July 4, 2026
                            19:34</span>
                    </div>
                </div>
                <div class="flex flex-col">
                    <label class="text-[11px] font-bold text-gray-700 mb-1.5">Software Version</label>
                    <div class="text-xs font-extrabold text-gray-900 h-8.5 flex items-center">
                        v1.0.0
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-md space-y-6">
            <div class="flex items-center space-x-4">
                <div class="bg-[#D1FAE5]/60 p-4 rounded-2xl text-[#065F46]">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900 leading-tight">Notifications</h2>
                    <p class="text-[13px] font-medium text-gray-500">Manage how you receive notifications and alerts</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 pt-1 items-start">
                <div class="md:col-span-5 space-y-4">
                    <div class="border border-gray-300 rounded-lg p-3 flex items-center justify-between bg-white shadow-sm">
                        <div class="leading-snug">
                            <p class="text-xs font-bold text-gray-900">Email Notification</p>
                            <p class="text-[10px] font-semibold text-gray-400 mt-0.5">Receive system notification via email
                            </p>
                        </div>



                        <label for="email_toggle" class="relative inline-flex items-center cursor-pointer select-none mr-2">
                            <input type="checkbox" name="email_toggle" id="email_toggle" checked class="sr-only peer" />
                            <div
                                class="w-10 h-5 rounded-full bg-gray-300 transition-colors duration-200 ease-in-out peer-checked:bg-emerald-500">
                            </div>
                            <div
                                class="absolute left-0.5 top-0.5 h-4 w-4 rounded-full bg-white shadow transition-transform duration-200 ease-in-out peer-checked:translate-x-2.5">
                            </div>
                        </label>
                    </div>

                    <div class="border border-gray-300 rounded-lg p-3 flex items-center justify-between bg-white shadow-sm">
                        <div class="leading-snug">
                            <p class="text-xs font-bold text-gray-900">In-app Notification</p>
                            <p class="text-[10px] font-semibold text-gray-400 mt-0.5">Receive notification within the system
                            </p>
                        </div>

                        <label for="inapp_toggle" class="relative inline-flex items-center cursor-pointer select-none mr-2">
                            <input type="checkbox" name="inapp_toggle" id="inapp_toggle" checked class="sr-only peer" />
                            <div
                                class="w-10 h-5 rounded-full bg-gray-300 transition-colors duration-200 ease-in-out peer-checked:bg-emerald-500">
                            </div>
                            <div
                                class="absolute left-0.5 top-0.5 h-4 w-4 rounded-full bg-white shadow transition-transform duration-200 ease-in-out peer-checked:translate-x-2.5">
                            </div>
                        </label>
                    </div>


                </div>

                <div class="md:col-span-7 pl-0 md:pl-6">
                    <p class="text-xs font-bold text-gray-900 mb-4">Notify the system for:</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                        <label class="flex items-center space-x-3 cursor-pointer group">
                            <input type="checkbox" checked
                                class="w-4 h-4 text-brand-green border-gray-300 rounded focus:ring-brand-green accent-brand-green transform scale-110">
                            <span
                                class="text-xs font-semibold text-gray-700 group-hover:text-gray-900 transition-colors">Purchase
                                Order Approvals</span>
                        </label>
                        <label class="flex items-center space-x-3 cursor-pointer group">
                            <input type="checkbox" checked
                                class="w-4 h-4 text-brand-green border-gray-300 rounded focus:ring-brand-green accent-brand-green transform scale-110">
                            <span
                                class="text-xs font-semibold text-gray-700 group-hover:text-gray-900 transition-colors">Invoice
                                Matching</span>
                        </label>
                        <label class="flex items-center space-x-3 cursor-pointer group">
                            <input type="checkbox"
                                class="w-4 h-4 text-brand-green border-gray-300 rounded focus:ring-brand-green accent-brand-green transform scale-110">
                            <span
                                class="text-xs font-semibold text-gray-700 group-hover:text-gray-900 transition-colors">New
                                Software Update</span>
                        </label>
                        <label class="flex items-center space-x-3 cursor-pointer group">
                            <input type="checkbox" checked
                                class="w-4 h-4 text-brand-green border-gray-300 rounded focus:ring-brand-green accent-brand-green transform scale-110">
                            <span
                                class="text-xs font-semibold text-gray-700 group-hover:text-gray-900 transition-colors">Good
                                Receipts</span>
                        </label>
                        <label class="flex items-center space-x-3 cursor-pointer group">
                            <input type="checkbox" checked
                                class="w-4 h-4 text-brand-green border-gray-300 rounded focus:ring-brand-green accent-brand-green transform scale-110">
                            <span
                                class="text-xs font-semibold text-gray-700 group-hover:text-gray-900 transition-colors">Supplier
                                Responses</span>
                        </label>
                        <label class="flex items-center space-x-3 cursor-pointer group">
                            <input type="checkbox"
                                class="w-4 h-4 text-brand-green border-gray-300 rounded focus:ring-brand-green accent-brand-green transform scale-110">
                            <span
                                class="text-xs font-semibold text-gray-700 group-hover:text-gray-900 transition-colors">Recent
                                Activities</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-md space-y-6">
            <div class="flex items-center space-x-4">
                <div class="bg-[#E0F2FE]/80 p-4 rounded-2xl text-[#0369A1]">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751A11.956 11.956 0 0112 2.714z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900 leading-tight">Security</h2>
                    <p class="text-[13px] font-medium text-gray-500">Manage security settings and access controls</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-5 pt-1">
                <div class="flex flex-col">
                    <label class="text-[11px] font-bold text-gray-700 mb-1.5">Password Policy</label>
                    <div class="relative">
                        <select
                            class="bg-bg-input border border-gray-300 rounded-md px-3 py-1.5 text-xs font-semibold text-gray-800 focus:outline-none focus:border-brand-green cursor-pointer appearance-none w-full">
                            <option selected>Strong (&gt;8 Characters)</option>
                            <option>Medium (&gt;6 Characters)</option>
                            <option>Custom Policy</option>
                        </select>
                        <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none text-gray-500">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col">
                    <label class="text-[11px] font-bold text-gray-700 mb-1.5">Password Expiration</label>
                    <div class="relative">
                        <select
                            class="bg-bg-input border border-gray-300 rounded-md px-3 py-1.5 text-xs font-semibold text-gray-800 focus:outline-none focus:border-brand-green cursor-pointer appearance-none w-full">
                            <option selected>90 Days</option>
                            <option>180 Days</option>
                            <option>Never Expire</option>
                        </select>
                        <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none text-gray-500">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col">
                    <label class="text-[11px] font-bold text-gray-700 mb-1.5">Recovery Email</label>
                    <input type="email" value="informatica26@gmail.com"
                        class="bg-bg-input border border-gray-300 rounded-md px-3 py-1.5 text-xs font-semibold text-gray-800 focus:outline-none focus:border-brand-green shadow-sm w-full">
                </div>
                <div class="flex flex-col">
                    <label class="text-[11px] font-bold text-gray-700 mb-1.5">Password</label>
                    <div class="relative">
                        <input id="securityPasswordField" type="password" value="SuperSecret2026!"
                            class="bg-bg-input border border-gray-300 rounded-md pl-3 pr-10 py-1.5 text-xs font-semibold text-gray-800 focus:outline-none focus:border-brand-green shadow-sm w-full">
                        <button type="button" onclick="togglePasswordVisibility()"
                            class="absolute inset-y-0 right-3 flex items-center text-gray-500 hover:text-brand-green focus:outline-none">
                            <span id="eyeIconWrapper">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-5 pt-1 items-end">
                <div class="flex flex-col">
                    <label class="text-[11px] font-bold text-gray-700 mb-1.5">Login Session Timeout</label>
                    <div class="relative">
                        <select
                            class="bg-bg-input border border-gray-300 rounded-md px-3 py-1.5 text-xs font-semibold text-gray-800 focus:outline-none focus:border-brand-green cursor-pointer appearance-none w-full">
                            <option selected>30 Minutes</option>
                            <option>60 Minutes</option>
                            <option>4 Hours</option>
                        </select>
                        <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none text-gray-500">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col">
                    <label class="text-[11px] font-bold text-gray-700 mb-1.5">Account Lockout</label>
                    <div class="relative">
                        <select
                            class="bg-bg-input border border-gray-300 rounded-md px-3 py-1.5 text-xs font-semibold text-gray-800 focus:outline-none focus:border-brand-green cursor-pointer appearance-none w-full">
                            <option selected>5 Failed Attempts</option>
                            <option>3 Failed Attempts</option>
                            <option>10 Failed Attempts</option>
                        </select>
                        <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none text-gray-500">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-3 h-8.5">
                    <input type="checkbox" id="tfa_check" checked
                        class="w-4 h-4 text-brand-green border-gray-300 rounded focus:ring-brand-green accent-brand-green transform scale-110 cursor-pointer">
                    <label for="tfa_check" class="text-xs font-semibold text-gray-700 cursor-pointer select-none">Two-Factor
                        Authentication</label>
                </div>
                <div>
                    <button type="button" onclick="openPasswordModal()"
                        class="w-full bg-white hover:bg-gray-50 text-gray-800 font-bold text-xs py-2 px-4 border border-gray-300 rounded-md shadow-sm uppercase tracking-wide transition-colors h-8.5">
                        Change Password
                    </button>
                </div>
            </div>
        </div>

    </form>

@endsection

<div id="passwordModal"
    class="fixed inset-0 bg-black/50 z-50 items-center justify-center hidden opacity-0 transition-opacity duration-300">
    <div
        class="bg-white rounded-3xl w-full max-w-md p-6 shadow-2xl border border-gray-100 transform scale-95 transition-transform duration-300">
        <div class="flex items-center justify-between border-b border-gray-100 pb-3 mb-4">
            <h3 class="text-lg font-bold text-gray-900">Update Account Password</h3>
            <button type="button" onclick="closePasswordModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="space-y-4">
            <div class="flex flex-col">
                <label class="text-[11px] font-bold text-gray-700 mb-1.5">Current Password</label>
                <input type="password" id="currentPassword"
                    class="bg-bg-input border border-gray-300 rounded-md px-3 py-2 text-xs font-semibold text-gray-800 focus:outline-none focus:border-brand-green w-full">
            </div>
            <div class="flex flex-col">
                <label class="text-[11px] font-bold text-gray-700 mb-1.5">New Password</label>
                <input type="password" id="newPassword"
                    class="bg-bg-input border border-gray-300 rounded-md px-3 py-2 text-xs font-semibold text-gray-800 focus:outline-none focus:border-brand-green w-full">
            </div>
            <div class="flex flex-col">
                <label class="text-[11px] font-bold text-gray-700 mb-1.5">Confirm New Password</label>
                <input type="password" id="confirmPassword"
                    class="bg-bg-input border border-gray-300 rounded-md px-3 py-2 text-xs font-semibold text-gray-800 focus:outline-none focus:border-brand-green w-full">
            </div>
        </div>

        <div class="flex items-center justify-end space-x-3 mt-6 pt-3 border-t border-gray-100">
            <button type="button" onclick="closePasswordModal()"
                class="bg-white hover:bg-gray-50 text-gray-700 font-bold text-xs py-2 px-4 border border-gray-300 rounded-md transition-colors uppercase tracking-wider">Cancel</button>
            <button type="button" onclick="submitPasswordChange()"
                class="bg-brand-green hover:bg-brand-emeraldHover text-white font-bold text-xs py-2 px-5 rounded-md shadow transition-colors uppercase tracking-wider">Save
                Password</button>
        </div>
    </div>
</div>


@push('scripts')
    <script>
        // 1. Password Input Visibility Eye Toggler Component Logic 
        function togglePasswordVisibility() {
            const pwdInput = document.getElementById('securityPasswordField');
            const iconWrapper = document.getElementById('eyeIconWrapper');

            if (pwdInput.type === 'password') {
                pwdInput.type = 'text';
                // Toggle to Eye Slash / Off Icon view frame component
                iconWrapper.innerHTML = `
                                                                        <svg class="w-4 h-4 text-brand-green" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.822 7.822L21 21m-2.228-2.228l-3.65-3.65m0 0a3 3 0 11-4.243-4.243m4.242 4.242L9.88 9.88"/>
                                                                        </svg>
                                                                    `;
            } else {
                pwdInput.type = 'password';
                // Revert to Standard Eye view frame component
                iconWrapper.innerHTML = `
                                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                                        </svg>
                                                                    `;
            }
        }

        // 2. Change Password Modal Actions Layout Handlers 
        function openPasswordModal() {
            const modal = document.getElementById('passwordModal');
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modal.querySelector('div').classList.remove('scale-95');
            }, 10);
        }

        function closePasswordModal() {
            const modal = document.getElementById('passwordModal');
            modal.classList.add('opacity-0');
            modal.querySelector('div').classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
                // Clean fields on escape close
                document.getElementById('currentPassword').value = '';
                document.getElementById('newPassword').value = '';
                document.getElementById('confirmPassword').value = '';
            }, 300);
        }

        function submitPasswordChange() {
            const current = document.getElementById('currentPassword').value;
            const newPwd = document.getElementById('newPassword').value;
            const confirm = document.getElementById('confirmPassword').value;

            if (!current || !newPwd || !confirm) {
                alert('Please fill out all the fields in the form.');
                return;
            }

            if (newPwd !== confirm) {
                alert('Validation mismatch error: New Password configurations do not match confirmation input fields.');
                return;
            }

            // Mock success workflow feedback updating primary target
            document.getElementById('securityPasswordField').value = newPwd;
            alert('Success! System user validation settings updated.');
            closePasswordModal();
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            green: '#00B67A',
                            dark: '#0F172A'
                        },
                        bg: {
                            main: '#DBDBDB',
                            sidebar: '#FFFFFF',
                            cardGreen: '#E9EFC0',
                            cardLightGreen: '#DCFCE7',
                            cardBeige: '#F1E4CE',
                            cardPeach: '#FCE2D6',
                            actionBlue: '#A2C2E8',
                            actionBlueHover: '#8EB5E0',
                            actionSlate: '#B5C4D4',
                            actionSlateHover: '#9FAFC0'
                        },
                        chart: {
                            delivered: '#727CA3',
                            pending: '#AAB06C',
                            cancelled: '#B44A4A'
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
@endpush

@push('styles')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        /* Custom scrollbar to match sleek UI look */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #DBDBDB;
        }

        ::-webkit-scrollbar-thumb {
            background: #A5A5A5;
            border-radius: 3px;
        }
    </style>
@endpush