@extends('yellowpages::layout.auth')
@section('title', 'रजिस्टर - बधाई संदेश')
@section('content')
<link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css" />
<style>
    
*,:before,:after { 
    --tw-translate-x: 0; 
    --tw-translate-y: 0; 
    --tw-rotate: 0; 
    --tw-skew-x: 0; 
    --tw-skew-y: 0; 
    --tw-scale-x: 1; 
    --tw-scale-y: 1; 
    --tw-ring-offset-width: 0px; 
    --tw-ring-offset-color: #fff; 
    --tw-ring-color: rgb(59 130 246 / 0.5); 
    --tw-ring-offset-shadow: 0 0 #0000; 
    --tw-ring-shadow: 0 0 #0000; 
    --tw-shadow: 0 0 #0000; 
} 

*,:after,:before { 
    box-sizing: border-box; 
    border-width: 0; 
    border-style: solid; 
    border-color: #e5e7eb;
} 

:backdrop { 
    --tw-translate-x: 0; 
    --tw-translate-y: 0; 
    --tw-rotate: 0; 
    --tw-skew-x: 0; 
    --tw-skew-y: 0; 
    --tw-scale-x: 1; 
    --tw-scale-y: 1; 
    --tw-ring-offset-width: 0px; 
    --tw-ring-offset-color: #fff; 
    --tw-ring-color: rgb(59 130 246 / 0.5); 
    --tw-ring-offset-shadow: 0 0 #0000; 
    --tw-ring-shadow: 0 0 #0000; 
    --tw-shadow: 0 0 #0000; 
} 

.bg-yellow-100 { 
    --tw-bg-opacity: 1; 
    background-color: rgb(254 249 195 / var(--tw-bg-opacity, 1));
} 

.p-2 { 
    padding: 0.5rem;
} 

.text-center { 
    text-align: center;
} 

.font-semibold { 
    font-weight: 600;
} 

.text-yellow-800 { 
    --tw-text-opacity: 1; 
    color: rgb(133 77 14 / var(--tw-text-opacity, 1));
} 

.py-2 { 
    padding-top: 0.5rem; 
    padding-bottom: 0.5rem;
} 

.relative { 
    position: relative;
} 

.flex-col { 
    flex-direction: column;
} 

@media (min-width: 768px){ 
  .md\:flex-row { 
    flex-direction: row;
  } 
}     

.border-t { 
    border-top-width: 1px;
} 

.border-gray-100 { 
    --tw-border-opacity: 1; 
    border-color: rgb(243 244 246 / var(--tw-border-opacity, 1));
} 

a { 
    color: inherit; 
    text-decoration: inherit;
} 

.flex-1 { 
    flex: 1 1 0%;
} 

.justify-between { 
    justify-content: space-between;
} 

.bg-gradient-to-b { 
    background-image: linear-gradient(to bottom, var(--tw-gradient-stops));
} 

.to-white { 
    --tw-gradient-to: #fff var(--tw-gradient-to-position);
} 

.p-3 { 
    padding: 0.75rem;
} 

@media (min-width: 768px){ 
  .md\:w-64 { 
    width: 16rem;
  } 
}     

.rounded-lg { 
    border-radius: 0.5rem;
} 

.bg-gradient-to-r { 
    background-image: linear-gradient(to right, var(--tw-gradient-stops));
} 

.from-indigo-500 { 
    --tw-gradient-from: #6366f1 var(--tw-gradient-from-position); 
    --tw-gradient-to: rgb(99 102 241 / 0) var(--tw-gradient-to-position); 
    --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to);
} 

.to-indigo-600 { 
    --tw-gradient-to: #4f46e5 var(--tw-gradient-to-position);
} 

.text-white { 
    --tw-text-opacity: 1; 
    color: rgb(255 255 255 / var(--tw-text-opacity, 1));
} 

.transition-colors { 
    transition-property: color, background-color, border-color, fill, stroke, -webkit-text-decoration-color; 
    transition-property: color, background-color, border-color, text-decoration-color, fill, stroke; 
    transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, -webkit-text-decoration-color; 
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1); 
    transition-duration: 150ms;
} 

.hover\:from-indigo-600:hover { 
    --tw-gradient-from: #4f46e5 var(--tw-gradient-from-position); 
    --tw-gradient-to: rgb(79 70 229 / 0) var(--tw-gradient-to-position); 
    --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to);
} 

.hover\:to-indigo-700:hover { 
    --tw-gradient-to: #4338ca var(--tw-gradient-to-position);
} 

img { 
    display: block; 
    vertical-align: middle;
} 

img { 
    max-width: 100%; 
    height: auto;
} 

.h-8 { 
    height: 2rem;
} 

h3 { 
    font-size: inherit; 
    font-weight: inherit;
} 

h3 { 
    margin: 0;
} 

.mb-2 { 
    margin-bottom: 0.5rem;
} 

.text-2xl { 
    font-size: 1.5rem; 
    line-height: 2rem;
} 

.font-bold { 
    font-weight: 700;
} 

.text-gray-800 { 
    --tw-text-opacity: 1; 
    color: rgb(31 41 55 / var(--tw-text-opacity, 1));
} 

.space-y-2 > :not([hidden]) ~ :not([hidden])  { 
    --tw-space-y-reverse: 0; 
    margin-top: calc(0.5rem * calc(1 - var(--tw-space-y-reverse))); 
    margin-bottom: calc(0.5rem * var(--tw-space-y-reverse));
} 

.hover\:bg-gray-50:hover { 
    --tw-bg-opacity: 1; 
    background-color: rgb(249 250 251 / var(--tw-bg-opacity, 1));
} 

.mt-2 { 
    margin-top: 0.5rem;
} 

.text-lg { 
    font-size: 1.125rem; 
    line-height: 1.75rem;
} 

.h-24 { 
    height: 6rem;
} 

.w-24 { 
    width: 6rem;
} 

.transform { 
    transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
} 

.rounded-xl { 
    border-radius: 0.75rem;
} 

.p-1 { 
    padding: 0.25rem;
} 

.shadow-lg { 
    --tw-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1); 
    --tw-shadow-colored: 0 10px 15px -3px var(--tw-shadow-color), 0 4px 6px -4px var(--tw-shadow-color); 
    box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
} 

.transition-transform { 
    transition-property: transform; 
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1); 
    transition-duration: 150ms;
} 

.duration-300 { 
    transition-duration: 300ms;
} 

@media (min-width: 768px){ 
  .md\:h-32 { 
    height: 8rem;
  } 

  .md\:w-32 { 
    width: 8rem;
  } 
}     

.hover\:rotate-3:hover { 
    --tw-rotate: 3deg; 
    transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
} 

.bx { 
    font-family: boxicons!important; 
    font-weight: 400; 
    font-style: normal; 
    font-variant: normal; 
    line-height: 1; 
    text-rendering: auto; 
    display: inline-block; 
    text-transform: none; 
    speak: none; 
    -webkit-font-smoothing: antialiased; 
    -moz-osx-font-smoothing: grayscale;
} 

.bx-link-external:before { 
    content: "\eb3e";
} 

.space-x-2 > :not([hidden]) ~ :not([hidden])  { 
    --tw-space-x-reverse: 0; 
    margin-right: calc(0.5rem * var(--tw-space-x-reverse)); 
    margin-left: calc(0.5rem * calc(1 - var(--tw-space-x-reverse)));
} 

.space-y-1 > :not([hidden]) ~ :not([hidden])  { 
    --tw-space-y-reverse: 0; 
    margin-top: calc(0.25rem * calc(1 - var(--tw-space-y-reverse))); 
    margin-bottom: calc(0.25rem * var(--tw-space-y-reverse));
} 

.h-5 { 
    height: 1.25rem;
} 

.w-5 { 
    width: 1.25rem;
} 

.text-gray-600 { 
    --tw-text-opacity: 1; 
    color: rgb(75 85 99 / var(--tw-text-opacity, 1));
} 

.bxs-location-plus:before { 
    content: "\ee0b";
} 

.text-gray-700 { 
    --tw-text-opacity: 1; 
    color: rgb(55 65 81 / var(--tw-text-opacity, 1));
} 

.rounded-full { 
    border-radius: 9999px;
} 

.ring-4 { 
    --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color); 
    --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(4px + var(--tw-ring-offset-width)) var(--tw-ring-color); 
    box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000);
} 

.ring-white { 
    --tw-ring-opacity: 1; 
    --tw-ring-color: rgb(255 255 255 / var(--tw-ring-opacity, 1));
} 

.h-full { 
    height: 100%;
} 

.bxs-user:before { 
    content: "\eee1";
} 

.text-sm { 
    font-size: 0.875rem; 
    line-height: 1.25rem;
} 

.text-gray-500 { 
    --tw-text-opacity: 1; 
    color: rgb(107 114 128 / var(--tw-text-opacity, 1));
} 

.bxs-envelope:before { 
    content: "\ed9f";
} 

.bxs-phone:before { 
    content: "\ee66";
} 

.bxs-category:before { 
    content: "\ed27";
} 

.object-cover { 
    object-fit: cover;
} 

/* Division */
.min-h-screen .md\:flex-row{
 display:flex;
 align-items:center;
 width:600px;
 margin-top:88px;
}
/* Justify between */
.min-h-screen .md\:flex-row .justify-between{
 box-shadow:0px 2px 0px -50px rgba(0,0,0,0.075) !important;
 display:flex;
 align-items:center;
 justify-content:space-between;
}

/* Lol img */
.justify-between .relative .lol-img{
 display:flex;
 justify-content:center;
 align-items:center;
 border-style:solid;
 border-width:2px;
 border-color:#b8d7da;
}

/* Italic Tag */
.overflow-hidden .lol-img i{
 font-size:57px;
}

/* Division */
.min-h-screen .md\:flex-row{
 box-shadow:0px 0px 40px -17px #f0d83c;
 color:#334f6f;
 border-color:#cec10d !important;
 border-style:solid;
 border-width:1px;
}
/* Body */
body{
 height:100vh;
 background-color:#f7f2f2;
}

/* Heading */
.modal-body section h1{
 font-weight:700;
 color:#078607;
 text-align:center;
}

/* Paragraph */
.modal-body section p{
 font-weight:600;
 font-size:22px;
 transform:translatex(0px) translatey(0px);
 text-align:center;
}

/* Btnx */
.modal-body section .btnx{
 display:grid;
 justify-content:center;
 align-content:center;
 column-gap:26px;
}

/* Btnx */
#staticBackdrop .modal-dialog .modal-content .modal-body section .btnx{
 grid-template-columns:auto auto !important;
}

/* Paragraph */
#staticBackdrop .modal-dialog .modal-content .modal-body section p{
 display:inline-block !important;
}

/* Section */
.modal-dialog .modal-body section{
 text-align:center;
}

/* Link */
.modal-body section a{
 margin-bottom:29px !important;
 padding-bottom:16px;
 margin-top:14px;
}

/* Button */
.btnx p .btn-success{
 height:38px;
}

/* Button */
.btnx p .btn-primary{
 height:36px;
}

/* Small Tag */
.modal-body p small{
 font-weight:500;
 margin-top:5px;
 position:relative;
 top:6px;
}

/* Link */
.modal-body section a{
 font-weight:700;
}



</style>
<div class="fixed inset-0 flex items-center justify-center min-h-screen bg-gray-100">
    <!-- Content Wrapper -->
    <div class="flex flex-col md:flex-row relative max-w-md mx-auto rounded-lg shadow-md p-4 bg-white 
                border border-gray-300 hover:border-indigo-500 transition duration-300 ease-in-out">
        
        <!-- Logo at the top center -->
        <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white p-2 rounded-full shadow-md">
            <img src="{{ asset('path-to-your-logo.png') }}" alt="Logo" class="w-12 h-12">
        </div>

        <!-- Information Section -->
        <div class="flex-1 space-y-2">
            <h5 class="text-2xl font-bold text-gray-800 mb-2">{{ ucfirst($vcard->name) }} Prarang Page</h5>

            <!-- Business Info -->
            <div class="p-2 flex-1 space-y-2 snipcss0-2-6-7">
                {{-- <h3 class="text-2xl font-bold text-gray-800 mb-2 snipcss0-3-7-8">{{ ucfirst($vcard->name) }} Prarang Page</h3> --}}
        
                <!-- Business Info -->
                <div class="space-y-1 mb-2 snipcss0-3-7-9">
                  <div class="flex items-center space-x-2 p-2 hover:bg-gray-50 rounded-lg transition-colors snipcss0-4-9-10">
                    <i class="bx bxs-user text-gray-600 w-5 h-5 snipcss0-5-10-11"></i>
                    <span class="text-gray-500 text-sm snipcss0-5-10-12">नाम (Name):</span>
                    <span class="text-gray-700 font-semibold snipcss0-5-10-13">
                        {{ ucfirst($vcard->name) }}
                    </span>
                  </div>
        
                  
                  <div class="flex items-center space-x-2 p-2 hover:bg-gray-50 rounded-lg transition-colors snipcss0-4-9-18">
                    <i class="bx bxs-phone text-gray-600 w-5 h-5 snipcss0-5-18-19"></i>
                    <span class="text-gray-500 text-sm snipcss0-5-18-20">फ़ोन (Phone):</span>
                    <span class="text-gray-700 font-semibold snipcss0-5-18-21">{{ $vcard->phone }}</span>
                  </div>
        
                  <div class="flex items-center space-x-2 p-2 hover:bg-gray-50 rounded-lg transition-colors snipcss0-4-9-22">
                    <i class="bx bxs-category text-gray-600 w-5 h-5 snipcss0-5-22-23"></i>
                    <span class="text-gray-500 text-sm snipcss0-5-22-24">श्रेणी (Category):</span>
                    <span class="text-gray-700 font-semibold snipcss0-5-22-25">{{ $vcard->category ?? '??' }}</span>
                  </div>
                </div>
                <div class="flex items-center space-x-2 p-2 hover:bg-gray-50 rounded-lg transition-colors">
                    <i class="bx bxs-location-plus text-gray-600 w-5 h-5"></i>
                    <span class="text-gray-700">पता (Address):</span>
                    <span class="text-gray-600">
                        @if (!empty($user->address) && !empty($user->address->area_name) && !empty($user->address->city->name) && !empty($user->address->postal_code))
                            {{ $user->address->area_name }},
                            {{ $user->address->city->name }},
                            {{ $user->address->postal_code }}
                        @else
                            <span class="text-gray-500 font-semibold">??</span>
                        @endif
                    </span>
                </div>
                
                
                <!-- Social Media Section -->
                <div class="text-lg font-semibold text-gray-800 mt-2 snipcss0-3-7-30">सोशल मीडिया (Social Media)</div>
                <div class="flex items-center space-x-2 p-2 hover:bg-gray-50 rounded-lg transition-colors">
                    <i class="bx bxl-facebook text-gray-600 w-5 h-5 snipcss0-5-22-23"></i>
                    <span class="text-gray-500 text-sm snipcss0-5-22-24">Facebook:</span>
                    <span class="text-gray-700 font-semibold snipcss0-5-22-25">{{ $vcard->category ?? '??' }}</span>
                  </div>
                  
            </div>

            <div class="d-flex">
                <button type="button" class="btn btn-primary w-50" 
                        onclick="window.location.href='{{ route('yp.login') }}'">
                    लॉगिन (Login)
                </button>
            </div>
            
        
            
                             
            <!-- Address Section -->
           
        </div>

        <!-- Profile & QR Code Section -->
        <div class="bg-gradient-to-b from-indigo-50 to-white p-3 flex flex-col items-center justify-between md:w-64 rounded-lg shadow-sm">
            <div class="relative mb-2">
                <div class="w-24 h-24 md:w-32 md:h-32 rounded-full overflow-hidden shadow-lg flex items-center justify-center bg-gray-200">
                    @if (!empty($user->profile) && Storage::exists($user->profile))
                        <img src="{{ Storage::url($user->profile) }}" alt="{{ $user->name ?? 'User' }}'s Profile"
                            class="w-full h-full object-cover" />
                    @else
                        <div class=" lol-img w-full h-full flex items-center justify-center bg-gray-300 text-gray-600 text-5xl font-bold rounded-full">
                            <i class="bx bxs-camera"></i> 
                        </div>
                    @endif
                </div>
            </div>
        </div>
       
    </div>
    
</div>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        {{-- <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5> --}}
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <section>
            <h1>🎉 बधाई हो! 🎉</h1>
            <p>आपका अपना वेबपेज खुल गया है।</p>
            <br>
            <a href="{{ url()->current() }}">{{ url()->current() }}</a>  <i class="bx bx-copy fw-bold h4" id="copyBtn(this)"></i>
            <p> <small>आप अपनी वेबसाइट को याद रखें या इसे याद रखने के लिए खुद को
                    <strong>WhatsApp</strong> या <strong>SMS</strong> करें।</small>
            </p>
           <div class="btnx">
            <p>
                <a href="https://wa.me/?text={{ urlencode('मेरा वेब पेज देखें\n' . url()->current()) }}" 
                   class="btn btn-success btn-block mb-2"
                   target="_blank" rel="noopener noreferrer">
                    <i class="fab fa-whatsapp"></i> WhatsApp पर साझा करें
                </a>
            </p>
            <p>
                <a href="sms:?body={{ urlencode('मेरा वेब पेज देखें\n' . url()->current()) }}" 
                   class="btn btn-primary btn-block mb-2" 
                   target="_blank" rel="noopener noreferrer">
                    <i class="fas fa-sms"></i> SMS पर साझा करें
                </a>
            </p>
            
        </div>

        </section>
      </div>
     
    </div>
  </div>
</div>
{{-- <script>
    document.addEventListener("DOMContentLoaded", function () {
      var myModal = new bootstrap.Modal(document.getElementById('staticBackdrop'));
      myModal.show();
    });



    copyBtn=document.getElementById('copyBtn(this)');
    copyBtn.addEventListener('click', function() {
        var textToCopy = this.getAttribute('data-clipboard-text');
        navigator.clipboard.writeText(textToCopy)
        .then(function() {
            alert('Copied to clipboard: ' + textToCopy);
        })
        .catch(function(err) {
            console.error('Failed to copy: ', err);
        });
    });

  </script> --}}


  {{-- set cookie for modal show --}}
  <script>
    document.addEventListener("DOMContentLoaded", function () {
        var myModal = new bootstrap.Modal(document.getElementById('staticBackdrop'));
    
        // Function to get a cookie value
        function getCookie(name) {
            let match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
            return match ? match[2] : null;
        }
    
        // Function to set a cookie
        function setCookie(name, value, days) {
            let expires = "";
            if (days) {
                let date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = "; expires=" + date.toUTCString();
            }
            document.cookie = name + "=" + value + "; path=/" + expires;
        }
    
        // Check if the modal has been shown before
        if (!getCookie("modalShown")) {
            myModal.show();  // Show modal
    
            // Set cookie so it doesn't show again
            setCookie("modalShown", "true", 1);  // Expires in 1 day
        }
    
        // Copy to clipboard functionality
        var copyBtns = document.querySelectorAll('[id^="copyBtn"]');
    
        copyBtns.forEach(function(copyBtn) {
            copyBtn.addEventListener('click', function () {
                var textToCopy = this.getAttribute('data-clipboard-text');
                navigator.clipboard.writeText(textToCopy)
                .then(function () {
                    alert('Copied to clipboard: ' + textToCopy);
                })
                .catch(function (err) {
                    console.error('Failed to copy: ', err);
                });
            });
        });
    
    });
    </script>
    
  
@endsection

<!-- Modal Structure -->
<div class="modal" id="modal">
    <div class="modal__content">
        <span class="modal__close" onclick="closeModal()">&times;</span>
        <h1>🎉 बधाई हो! 🎉</h1>
        <p>आपका अपना वेबपेज खुल गया है। आप अपनी वेबसाइट को याद रखें या इसे याद रखने के लिए खुद को <strong>WhatsApp</strong> या <strong>SMS</strong> करें।</p>
    </div>
</div>
