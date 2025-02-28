@extends('yellowpages::layout.admin.admin')
@section('title', 'Approve Business Listing')
@section('content')

<div class="page-content">
    <!-- Breadcrumb -->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">व्यवस्थापक</div>
    </div>

    <!-- Main Form -->
    <form action="{{ route('checker.listing-approval-status', $listing->id) }}" method="POST" enctype="multipart/form-data" class="form-container">
        @csrf
        @method('PUT')

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Primary Details Section -->
        <div class="form-section" style="max-width: 900px; margin: 0 auto; background: #fff; padding: 20px; border: 1px solid #ddd;">
            <h5>प्राथमिक सूची विवरण</h5>
            <div style="border-bottom: 2px solid #000; margin-bottom: 15px;"></div>
            <div class="mb-3">
                <label for="location" class="form-label">जगह</label>
                <select id="location" name="location" class="form-select">
                    <option selected disabled>स्थान चुनें</option>
                    @foreach($cities as $city)
                    <option value="{{ $city->id }}" 
                        {{ (old('legal_type_id', $listing->city_id) == $city->id) ? 'selected' : '' }}>
                        {{ $city->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="listingTitle" class="form-label">लिस्टिंग शीर्षक</label>
                <input type="text" id="listingTitle" name="listingTitle" class="form-control" value="{{ old('listing_title', $listing->listing_title) }}">
            </div>
            <div class="form-check mb-3">
                <input type="checkbox" class="form-check-input" id="hasTagline" {{ $listing->tagline ? 'checked' : '' }}
                       onclick="toggleTaglineField()">
                <label class="form-check-label" for="hasTagline">क्या आपके व्यवसाय की कोई टैगलाइन है?
                </label>
            </div>
            <div class="mb-3" id="taglineField" style="display: {{ $listing->tagline ? 'block' : 'none' }};">
                <label for="tagline" class="form-label">टैगलाइन</label>
                <input type="text" id="tagline" name="tagline" class="form-control" value="{{ old('tagline', $listing->tagline) }}" placeholder="Enter tagline">
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="businessName" class="form-label">व्यवसाय/कंपनी का नाम</label>
                    <input type="text" id="businessName" name="businessName" class="form-control" value="{{ old('business_name', $listing->business_name) }}" placeholder="Enter business name">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="primaryPhone" class="form-label">फ़ोन नंबर</label>
                    <input type="text" id="primaryPhone" name="primaryPhone" class="form-control" value="{{ old('primary_phone', $user->phone) }}" placeholder="Enter primary phone">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="primaryContact" class="form-label">संपर्क नाम</label>
                    <input type="text" id="primaryContact" name="primaryContact" class="form-control" value="{{ old('primary_contact_name', $user->name) }}"placeholder="Enter primary contact name">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="primaryEmail" class="form-label">ईमेल</label>
                    <input type="email" id="primaryEmail" name="primaryEmail" class="form-control" value="{{ old('primary_contact_email', $user->email) }}" placeholder="Enter primary email">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="businessType" class="form-label">व्यवसाय/कंपनी कानूनी प्रकार *</label>
                    <select id="businessType" name="businessType" class="form-select">
                        <option value="">प्रकार चुनें</option>
                        @foreach($company_legal_types as $Cl_type)
                            <option value="{{ $Cl_type->id }}" 
                                {{ (old('legal_type_id', $listing->legal_type_id) == $Cl_type->id) ? 'selected' : '' }}>
                                {{ $Cl_type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>                
                <div class="col-md-6 mb-3">
                    <label for="employee_range" class="form-label">व्यवसाय/कंपनी कर्मचारियों की संख्या (लगभग) *</label>
                    <select id="employee_range" name="employees" class="form-select">
                        <option selected>कर्मचारियों की संख्या चुनें</option>
                        @foreach($number_of_employees as $number_employee)
                        <option value="{{ $number_employee->id }}" 
                            {{ (old('employee_range_id', $listing->employee_range_id) == $number_employee->id) ? 'selected' : '' }}>
                            {{ $number_employee->range }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="trunover" class="form-label">व्यवसाय/कंपनी का मासिक कारोबार (लगभग) *</label>
                    <select id="trunover" name="turnover" class="form-select">
                        <option selected>टर्नओवर चुनें</option>
                        @foreach($monthly_turnovers as $turnovers)
                        <option value="{{ $turnovers->id }}" 
                            {{ (old('turnover_id', default: $listing->turnover_id) == $turnovers->id) ? 'selected' : '' }}>
                            {{ $turnovers->range }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="advertising" class="form-label">व्यवसाय/कंपनी मासिक विज्ञापन (मध्यम)</label>
                    <select id="advertising" name="advertising" class="form-select">
                        <option selected>विज्ञापन का चयन करें</option>
                        @foreach($monthly_advertising_mediums as $advertising)
                        <option value="{{ $advertising->id }}" 
                            {{ (old('advertising_medium_id ', $listing->advertising_medium_id) == $advertising->id) ? 'selected' : '' }}>
                            {{ $advertising->medium}}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="advertising_price" class="form-label">व्यवसाय/कंपनी विज्ञापन (मध्यम) मूल्य*</label>
                    <select id="advertising_price" name="advertising_price" class="form-select">
                        <option selected>विज्ञापन मूल्य चुनें</option>
                        @foreach($monthly_advertising_prices as $advertising)
                        <option value="{{ $advertising->id }}" 
                            {{ (old('advertising_medium_id ', $listing->advertising_price_id) == $advertising->id) ? 'selected' : '' }}>
                            {{ $advertising->range }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
        <br>
        <div style="max-width: 900px; margin: 0 auto; background: #fff; padding: 20px; border: 1px solid #ddd;">
            <h5 style="margin-bottom: 15px;">श्रेणी और सेवाएँ</h5>
            <div style="border-bottom: 2px solid #000; margin-bottom: 15px;"></div>
            <div style="display: flex; gap: 20px;">
                <div style="flex: 1;">
                    <label for="state" class="form-label">वर्ग *</label>
                    <select id="state" class="form-select" name="category">
                        <option selected>श्रेणी चुनना</option>
                        @foreach($categories as $Cate)
                        <option value="{{ $Cate->id }}" 
                            {{ (old('advertising_medium_id ', $listing->category_id) == $Cate->id) ? 'selected' : '' }}>
                            {{ $Cate->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <br><br>
        <div style="max-width: 900px; margin: 0 auto; background: #fff; padding: 20px; border: 1px solid #ddd;">
            <h5 style="margin-bottom: 15px;">और जानकारी</h5>
            <div style="border-bottom: 2px solid #000; margin-bottom: 15px;"></div>
            <div style="margin-top: 15px;">
                <label for="description">विवरण</label>
                <textarea id="description" name="description" rows="4" placeholder="Enter description here..." style="width: 100%;">{{ old('description', $listing->description) }}</textarea>
            </div>
                     
        </div>
            <br>
            <div style="max-width: 800px; margin: 0 auto; background: #fff; padding: 20px; border: 1px solid #ddd; font-family: Arial, sans-serif;">
                <h5 style="margin-bottom: 15px; font-size: 18px; font-weight: bold;">काम करने के घंटे</h5>
                <div style="border-bottom: 2px solid #000; margin-bottom: 15px;"></div>
            
                <!-- Schedule Container -->
                <div id="schedule-container">
                    @if($listinghours->isNotEmpty())
                        @foreach($listinghours as $hour)
                            <div class="day-schedule">
                                <select name="day[]" class="day-select">
                                    <option value="">-- दिन चुनें --</option>
                                    <option value="monday" {{ $hour->day == 'monday' ? 'selected' : '' }}>सोमवार</option>
                                    <option value="tuesday" {{ $hour->day == 'tuesday' ? 'selected' : '' }}>मंगलवार</option>
                                    <option value="wednesday" {{ $hour->day == 'wednesday' ? 'selected' : '' }}>बुधवार</option>
                                    <option value="thursday" {{ $hour->day == 'thursday' ? 'selected' : '' }}>गुरुवार</option>
                                    <option value="friday" {{ $hour->day == 'friday' ? 'selected' : '' }}>शुक्रवार</option>
                                    <option value="saturday" {{ $hour->day == 'saturday' ? 'selected' : '' }}>शनिवार</option>
                                    <option value="sunday" {{ $hour->day == 'sunday' ? 'selected' : '' }}>रविवार</option>
                                </select>
            
                                <input type="time" name="open_time[]" class="time-input" value="{{ $hour->open_time }}">
                                <label>to</label>
                                <input type="time" name="close_time[]" class="time-input" value="{{ $hour->close_time }}">
            
                                {{-- <label>
                                    <input type="checkbox" name="is_24_hours[]" class="is-24-hours" value="0" {{ $hour->is_24_hours ? 'checked' : '' }}> 24 घंटे
                                </label> --}}
            
                                <label>
                                    <input type="checkbox" class="add-2nd-slot" {{ $hour->open_time_2 ? 'checked' : '' }}> दूसरा स्लॉट जोड़ें
                                </label>
            
                                <button type="button" class="remove-day-btn">&#x2716;</button>
            
                                <!-- Second Time Slot -->
                                <div class="second-time-slot" style="display: {{ $hour->open_time_2 ? 'block' : 'none' }}; margin-top: 10px;">
                                    <input type="time" name="open_time_2[]" class="time-input" value="{{ $hour->open_time_2 }}">
                                    <label>to</label>
                                    <input type="time" name="close_time_2[]" class="time-input" value="{{ $hour->close_time_2 }}">
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p>कोई व्यावसायिक घंटे सेट नहीं हैं।</p>
                    @endif
                </div>
            
                <!-- Add New Day Button -->
                {{-- <button type="button" id="add-day-btn">+ Add Day</button> --}}
            </div>            
            <br>
            <div style="max-width: 900px; margin: 0 auto; background: #fff; padding: 20px; border: 1px solid #ddd;">
                <h5 style="margin-bottom: 15px;">व्यवसाय/कंपनी का पता</h5>
                <div style="border-bottom: 2px solid #000; margin-bottom: 15px;"></div>
                <div style="margin-bottom: 10px;">
                    <label for="street_address">व्यवसाय/कंपनी का पता:</label>
                    <input type="text" id="street_address" name="fullAddress"  value="{{ old('primary_contact_email', $listing->full_address) }}" placeholder="123 Main St" style="width: 100%; padding: 8px;">
                </div>
               
                <h5 style="margin-bottom: 15px;">संपर्क जानकारी</h5>
                <div style="border-bottom: 2px solid #000; margin-bottom: 15px;"></div>
                <div style="margin-bottom: 10px;">
                    <label for="website">वेबसाइट:</label>
                    <input type="url" id="website" name="website" value="{{ old('primary_contact_email', $listing->website) }}" placeholder="https://example.com" style="width: 100%; padding: 8px;">
                </div>
            </div>
            <br>
            <div style="max-width: 800px; margin: 0 auto; background: #fff; padding: 20px; border: 1px solid #ddd;">
                <h5 style="margin-bottom: 15px;">सोशल मीडिया लिंक</h5>
                <div style="border-bottom: 2px solid #000; margin-bottom: 15px;"></div>
            
                <div id="social-media-container">
                    @if(!empty($social_media_data) && count($social_media_data) > 0)
                        @foreach($social_media_data as $data)
                            <div class="social-media-row" style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
                                <select name="socialId[]" style="flex: 1; padding: 8px;">
                                    <option value="">स्थान चुनें</option>
                                    @foreach($social_media as $social)
                                        <option value="{{ $social->id }}" 
                                            @if(isset($data->social_id) && $data->social_id == $social->id) selected @endif>
                                            {{ $social->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="text" name="socialDescription[]" value="{{ $data->description ?? '' }}" placeholder="अपना लिंक या विवरण दर्ज करें" style="flex: 2; padding: 8px;">
                                <button type="button" class="removeSocialMedia" style="padding: 10px; background-color: red; color: white; border: none; cursor: pointer;">-</button>
                            </div>
                    @endforeach
                    @else
                        <div class="social-media-row" style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
                            <select name="socialId[]"  style="flex: 1; padding: 8px;">
                                <option value="">स्थान चुनें</option>
                                @foreach($social_media as $social)
                                    <option value="{{ $social->id }}">{{ $social->name }}</option>
                                @endforeach
                            </select>
                            <input type="text" name="socialDescription[]" placeholder="अपना लिंक या विवरण दर्ज करें" style="flex: 2; padding: 8px;">
                            <button type="button" class="removeSocialMedia" style="padding: 10px; background-color: red; color: white; border: none; cursor: pointer;">-</button>
                        </div>
                    @endif
                </div>
        
                <!-- Add Button -->
                {{-- <button type="button" id="addSocialMedia" style="padding: 10px; background-color: green; color: white; border: none; cursor: pointer; margin-top: 10px;">+</button> --}}
            </div>
            <br>
            <div style="max-width: 900px; margin: 0 auto; background: #fff; padding: 20px; border: 1px solid #ddd; box-shadow: 0 0 5px rgba(0,0,0,0.1);">
                <h5 style="margin-bottom: 15px;">मिडिया</h5>
                <div style="border-bottom: 2px solid #000; margin-bottom: 15px;"></div>
            
                {{-- Image Upload --}}
                <div style="border: 1px dashed #ddd; padding: 20px; text-align: center; color: #888; margin-bottom: 10px;">
                     <label for="businessImage" class="form-label">व्यवसाय छवि</label>
                    <input type="file" name="image" style="display: block; margin-top: 10px;">
                    <div style="margin-top: 20px; text-align: center;">
                        @if (!empty($listing->business_img_url))
                            <img src="{{ $listing->business_img_url }}" alt="Business Image" style="max-width: 200px; margin-top: 10px;">
                        @endif
                    </div>
                </div>
            <br>
        <!-- Submit Button -->
        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary">सत्यापित करें</button>
        </div>
    </form>
</div>
</div>

<script>
      function toggleTaglineField() {
        const taglineField = document.getElementById('taglineField');
        taglineField.style.display = taglineField.style.display === 'none' ? 'block' : 'none';
    }

    document.getElementById('add-day-btn').addEventListener('click', () => {
    const container = document.getElementById('schedule-container');
    const firstSchedule = container.querySelector('.day-schedule');

    if (firstSchedule) {
        // Clone an existing schedule
        const newSchedule = firstSchedule.cloneNode(true);

        // Reset values for cloned inputs
        newSchedule.querySelectorAll('select, input').forEach(input => {
            if (input.type === 'checkbox') {
                input.checked = false;
            } else {
                input.value = '';
                input.disabled = false;
            }
        });

        // Hide second slot in the new schedule
        newSchedule.querySelector('.second-time-slot').style.display = 'none';

        // Append new schedule
        container.appendChild(newSchedule);
    } else {
        // Create a new schedule if none exist
        const newSchedule = document.createElement('div');
        newSchedule.classList.add('day-schedule');

        newSchedule.innerHTML = `
            <select name="day[]" class="day-select">
                <option value="">-- दिन चुनें --</option>
                <option value="monday">सोमवार</option>
                <option value="tuesday">मंगलवार</option>
                <option value="wednesday">बुधवार</option>
                <option value="thursday">गुरुवार</option>
                <option value="friday">शुक्रवार</option>
                <option value="saturday">शनिवार</option>
                <option value="sunday">रविवार</option>
            </select>
            <input type="time" name="open_time[]" class="time-input">
            <label>to</label>
            <input type="time" name="close_time[]" class="time-input">
         
            <label>
                <input type="checkbox" class="add-2nd-slot"> दूसरा स्लॉट जोड़ें
            </label>
            <button type="button" class="remove-day-btn">&#x2716;</button>
            
            <!-- Second Time Slot -->
            <div class="second-time-slot" style="display: none; margin-top: 10px;">
                <input type="time" name="open_time_2[]" class="time-input">
                <label>to</label>
                <input type="time" name="close_time_2[]" class="time-input">
            </div>
        `;

        container.appendChild(newSchedule);
    }
});

// Handle 24-hour checkbox toggle
document.addEventListener('change', (e) => {
    if (e.target.classList.contains('is-24-hours')) {
        const parent = e.target.closest('.day-schedule');
        parent.querySelectorAll('.time-input').forEach(input => {
            input.disabled = e.target.checked;
        });
    }
});

// Show or hide the second time slot
document.addEventListener('change', (e) => {
    if (e.target.classList.contains('add-2nd-slot')) {
        const parent = e.target.closest('.day-schedule');
        const secondSlot = parent.querySelector('.second-time-slot');
        secondSlot.style.display = e.target.checked ? 'block' : 'none';
    }
});

// Remove a day schedule
document.addEventListener('click', (e) => {
    if (e.target.classList.contains('remove-day-btn')) {
        e.target.closest('.day-schedule').remove();
    }
});
document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("listingForm").addEventListener("submit", function (event) {
        document.querySelectorAll('input[name="is_24_hours[]"]').forEach(checkbox => {
            let hiddenInput = document.createElement("input");
            hiddenInput.type = "hidden";
            hiddenInput.name = checkbox.name; 
            hiddenInput.value = checkbox.checked ? "yes" : "no";
            this.appendChild(hiddenInput);
            checkbox.remove(); 
        });
    });
});


// Collect and log schedules
document.getElementById('submit-btn')?.addEventListener('click', () => {
    const schedules = [];
    document.querySelectorAll('.day-schedule').forEach(schedule => {
        const day = schedule.querySelector('.day-select').value;
        const openTime = schedule.querySelector('input[name="open_time[]"]').value;
        const closeTime = schedule.querySelector('input[name="close_time[]"]').value;
        const is24Hours = schedule.querySelector('.is-24-hours').checked;
        let openTime2 = '', closeTime2 = '';
        const secondSlot = schedule.querySelector('.second-time-slot');
        if (secondSlot.style.display !== 'none') {
            openTime2 = secondSlot.querySelector('input[name="open_time_2[]"]').value;
            closeTime2 = secondSlot.querySelector('input[name="close_time_2[]"]').value;
        }

        schedules.push({
            day,
            openTime: is24Hours ? '24 Hours' : openTime,
            closeTime: is24Hours ? '24 Hours' : closeTime,
            is24Hours: is24Hours ? 1 : 0, // Set is_24_hours correctly // added the is24Hours to the object.
            secondSlot: openTime2 && closeTime2 ? { openTime2, closeTime2 } : null,
        });
    });

    console.log(schedules);
});

   function toggleMenu() {
    const menu = document.querySelector('.navmenu ul');
    menu.classList.toggle('show');
}

function toggleDropdown(category) {
    const dropdown = category.querySelector('.dropdown-menu');
    const icon = category.querySelector('.dropdown-icon');

    // Close all other dropdowns before opening this one
    document.querySelectorAll('.navmenu ul .dropdown').forEach(function(item) {
        if (item !== category) {
            item.classList.remove('show');
            item.querySelector('.dropdown-menu').style.display = 'none';
            item.querySelector('.dropdown-icon').classList.remove('show');
        }
    });

    // Toggle the current dropdown
    category.classList.toggle('show');
    dropdown.style.display = category.classList.contains('show') ? 'block' : 'none';
    icon.classList.toggle('show');
}

// Close dropdowns when clicking outside
document.addEventListener('click', function(event) {
    const navmenu = document.querySelector('.navmenu');
    const isClickInside = navmenu.contains(event.target);

    if (!isClickInside) {
        document.querySelectorAll('.navmenu ul .dropdown').forEach(function(item) {
            item.classList.remove('show');
            item.querySelector('.dropdown-menu').style.display = 'none';
            item.querySelector('.dropdown-icon').classList.remove('show');
        });
    }
});
document.addEventListener("DOMContentLoaded", function() {
    // Add new social media row
    document.getElementById("addSocialMedia").addEventListener("click", function() {
        let container = document.getElementById("social-media-container");
        console.log(container);
        let newRow = document.createElement("div");
        newRow.classList.add("social-media-row");
        newRow.style.display = "flex";
        newRow.style.alignItems = "center";
        newRow.style.gap = "10px";
        newRow.style.marginBottom = "10px";

        let select = document.createElement("select");
        select.name = "socialId[]";
        // select.required = true;
        select.style.flex = "1";
        select.style.padding = "8px";

        let defaultOption = document.createElement("option");
        defaultOption.text = "स्थान चुनें";
        defaultOption.value = "";
        select.appendChild(defaultOption);

        let socialMediaData = @json($social_media); // Convert Blade variable to JS array

        socialMediaData.forEach(function(social) {
            let option = document.createElement("option");
            option.value = social.id;
            option.text = social.name;
            select.appendChild(option);
        });

        let input = document.createElement("input");
        input.type = "text";
        input.name = "socialDescription[]";
        input.placeholder = "अपना लिंक या विवरण दर्ज करें";
        input.style.flex = "2";
        input.style.padding = "8px";

        let removeButton = document.createElement("button");
        removeButton.type = "button";
        removeButton.textContent = "-";
        removeButton.style.padding = "10px";
        removeButton.style.backgroundColor = "red";
        removeButton.style.color = "white";
        removeButton.style.border = "none";
        removeButton.style.cursor = "pointer";

        removeButton.addEventListener("click", function() {
            newRow.remove();
        });

        newRow.appendChild(select);
        newRow.appendChild(input);
        newRow.appendChild(removeButton);
        container.appendChild(newRow);
    });

    // Attach event listener to remove existing social media rows
    document.querySelectorAll(".removeSocialMedia").forEach(button => {
        button.addEventListener("click", function() {
            this.parentElement.remove();
        });
    });
});

</script>
@endsection
