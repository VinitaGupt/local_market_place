<!DOCTYPE html>
<html lang="hi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Business vCard for {{ $user->name ?? 'User' }}">
    <title>V Card</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
</head>

<body class="font-sans bg-gradient-to-br from-indigo-50 via-white to-purple-50">

<div class="min-h-screen flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden max-w-3xl w-full transform hover:scale-[1.02] transition-transform duration-300">

        <!-- 🟡 If VCard is not approved -->
        @if(session('message'))
            <div class="bg-yellow-100 text-yellow-800 p-4 text-center font-semibold">
                {{ session('message') }}
            </div>
        @endif

        <form action="{{ route('checker.Card-approval-status', $vcard->id) }}" method="POST" enctype="multipart/form-data" class="form-container">
            @csrf
            @method('PUT')

            <div class="flex flex-col md:flex-row p-4 space-y-4 md:space-y-0 md:space-x-4">
                <div class="flex-1 space-y-3">
                    <h1 class="text-2xl font-semibold text-gray-800">{{ $user->name ?? 'User' }} prarang page</h1>
                    
                    <!-- Business Information -->
                    <div class="space-y-2">
                        <div class="flex items-center space-x-3 p-3 hover:bg-gray-50 rounded-lg transition-colors">
                            <i class="bx bxs-user text-gray-600 w-5 h-5"></i>
                            <span class="text-gray-700 font-medium"><strong>नाम (Name):</strong> {{ trim(($user->name ?? '') . ' ' . ($user->surname ?? '')) ?: 'Not Available' }}</span>
                        </div>
                        @if (!empty($user->email))
                            <div class="flex items-center space-x-3 p-3 hover:bg-gray-50 rounded-lg transition-colors">
                                <i class="bx bxs-user text-gray-600 w-5 h-5"></i>
                                <span class="text-gray-700 font-medium"><strong>ईमेल (Email):</strong> {{ trim($user->email ?? 'Not Available') }}</span>
                            </div>
                        @endif
                        <div class="flex items-center space-x-3 p-3 hover:bg-gray-50 rounded-lg transition-colors">
                            <i class="bx bxs-phone text-gray-600 w-5 h-5"></i>
                            <span class="text-gray-700 font-medium"><strong>फ़ोन (Phone):</strong> {{ $user->phone ?? 'Not Available' }}</span>
                        </div>

                        <div class="flex items-center space-x-3 p-3 hover:bg-gray-50 rounded-lg transition-colors">
                            <i class="bx bxs-category text-gray-600 w-5 h-5"></i>
                            <span class="text-gray-700 font-medium"><strong>श्रेणी (Category):</strong> {{ $category->name ?? 'Not Available' }}</span>
                        </div>
                    </div>

                    @if (!empty($user->address))
                        <div class="flex items-center space-x-3 p-3 hover:bg-gray-50 rounded-lg transition-colors">
                            <i class="bx bxs-location-plus text-gray-600 w-5 h-5"></i>
                            <span class="text-gray-700 font-medium"><strong>पता (Address):</strong></span>
                            <span class="text-gray-600">
                                {{ $user->address->area_name ?? 'Area not available' }},
                                {{ $user->address->city->name ?? 'City not available' }},
                                {{ $user->address->postal_code ?? 'Postal code not available' }}
                            </span>
                        </div>
                    @endif

                    @if (!empty($vcard->dynamicFields))
                    <div class="text-sm font-semibold text-gray-800 mt-2 mb-1">
                      सोशल मीडिया (Social Media)
                    </div>
                    @foreach ($vcard->dynamicFields as $social)
                    <div class="p-2 hover:bg-gray-50 rounded-lg transition-colors">
                        <span class="text-gray-500 text-sm">
                            {{ $social->title ?? 'सोशल मीडिया (Social Media)' }}:
                            <span class="text-gray-700 font-semibold">
                                @if (!empty($social->data))
                                    @php
                                        $socialData = $social->data;
                                    @endphp
                                    
                                    @if (filter_var($socialData, FILTER_VALIDATE_URL))
                                        <!-- If it's a valid URL, make it a clickable link -->
                                        <a href="{{ $socialData }}" target="_blank" class="text-blue-500 hover:underline">{{ $socialData }}</a>
                                    @elseif (preg_match('/^\+?[0-9]{10,15}$/', $socialData))
                                        <!-- If it's a valid phone number, make it a clickable link for WhatsApp -->
                                        <a href="https://wa.me/{{ $socialData }}" target="_blank" class="text-green-500 hover:underline">{{ $socialData }}</a>
                                    @else
                                        <!-- If it's neither a URL nor a phone number, display it as plain text -->
                                        {{ $socialData }}
                                    @endif
                                @else
                                    <!-- If data is empty, show "Not Available" -->
                                    उपलब्ध नहीं है
                                @endif
                            </span>
                        </span>
                    </div>
                   @endforeach
                  @endif
                </div>

                <!-- Profile Picture & QR Section -->
                <div class="bg-gradient-to-b from-indigo-50 to-white p-4 flex flex-col items-center justify-between md:w-48 rounded-lg shadow-xl">
                    <div class="relative mb-4">
                        <div class="w-36 h-36 rounded-full overflow-hidden ring-4 ring-white shadow-lg">
                            @if (!empty($user->profile) && Storage::exists($user->profile))
                                <img src="{{ Storage::url($user->profile) }}" alt="{{ $user->name ?? 'User' }}'s Profile" class="w-full h-full object-cover">
                            @else
                                <img src="https://via.placeholder.com/150" alt="Default Profile" class="w-full h-full object-cover">
                            @endif
                        </div>
                    </div>
                    <div class="w-40 h-40 bg-white p-3 rounded-xl shadow-lg transform hover:rotate-3 transition-transform duration-300">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ route('vCard.view', ['city_arr'=>$user->address->city->city_arr,'slug' => $vcard->slug]) }}" alt="QR Code" class="w-full h-full">
                    </div>                    
                </div>
            </div>

            <!-- Show Business Registration Button (Inside Card) -->
            <div class="text-center mt-4 mb-4">
                <button type="submit" class="btn btn-primary {{ $vcard->is_approved ? 'bg-green-500 cursor-not-allowed' : 'bg-blue-500 hover:bg-blue-600 transition-all duration-300 rounded-full px-6 py-2 text-lg' }}" {{ $vcard->is_approved ? 'disabled' : '' }}>
                    {{ $vcard->is_approved ? 'Approved' : 'सत्यापित करें' }}
                </button>
            </div>

        </form>
    </div>
</div>

</body>
</html>
