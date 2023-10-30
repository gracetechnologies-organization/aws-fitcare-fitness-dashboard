<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light-style customizer-hide" dir="ltr"
    data-theme="theme-default" data-assets-path="{{ asset('dashboard') }}" data-template="vertical-menu-template-free">

<head>
    @include('components.head-links')
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @if (Auth::user()->role_id === 'emp')
            @include('livewire.employee.layout.navigation')
        @elseif (Auth::user()->role_id === 'admin')
            @include('livewire.admin.layout.navigation')
        @endif
        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
        @if (Auth::user()->role_id === 'emp')
            @include('livewire.employee.layout.footer')
        @elseif (Auth::user()->role_id === 'admin')
            @include('livewire.admin.layout.footer')
        @endif
    </div>
    @stack('footer')
    @stack('wire_script')
    @livewireScripts
</body>

</html>
<script src="{{ asset('dashboard/vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{ asset('dashboard/vendor/libs/popper/popper.js') }}"></script>
<script src="{{ asset('dashboard/vendor/js/bootstrap.js') }}"></script>
<script src="{{ asset('dashboard/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('dashboard/vendor/js/menu.js') }}"></script>
<script src="{{ asset('dashboard/js/main.js') }}"></script>
<script src="{{ asset('dashboard/js/dashboards-analytics.js') }}"></script>
<script>
    window.addEventListener('close-modal', event => {
        $('#' + event.detail.id).modal('hide');
    });

    window.addEventListener('show-modal', event => {
        $('#' + event.detail.id).modal('show');
    });

    window.addEventListener('reset-file-fields', () => {
        const inputFields = document.querySelectorAll("input[type=file]");
        for (let i = 0; i < inputFields.length; i++) inputFields[i].value = null;
    });

    window.addEventListener('copy-to-clipboard', () => {
        // Create a temporary textarea element
        const textarea = document.createElement('textarea');
        textarea.value = event.detail.token;
        // Append the textarea to the document body
        document.body.appendChild(textarea);
        // Select the text in the textarea
        textarea.select();
        // Copy the selected text to the clipboard
        document.execCommand('copy');
        // Remove the temporary textarea element
        document.body.removeChild(textarea);
        // Modify tooltip title
        var tooltipElement = document.getElementById(event.detail.id);
        tooltipElement.setAttribute('data-bs-original-title', 'Copied!');
        var tooltip = bootstrap.Tooltip.getInstance(tooltipElement);
        tooltip.show();
        tooltipElement.setAttribute('data-bs-original-title', 'Copy to clipboard');
    });

    window.addEventListener('select-checkboxes', () => {
        alert(event.detail.id);
        // const elements = document.querySelectorAll(`[id="${event.detail.id}"]`);

        let checkboxes = document.querySelectorAll(`[id="${event.detail.id}"]`);
        console.log(checkboxes);

        checkboxes.forEach((checkbox) => {
            checkbox.checked = !checkbox.checked;
        });
    });
    /*
    |--------------------------------------------------------------------------
    | Code for sidebar tree view begins
    |--------------------------------------------------------------------------
    */
    // Get all elements with class 'menu-item'
    var menuItems = document.querySelectorAll('.menu-item');
    // Loop through each element
    menuItems.forEach(function(item) {
        // Get the sub-menu element
        var subMenu = item.querySelector('.menu-sub-items');
        // If a sub-menu element exists
        if (subMenu) {
            // Hide the sub-menu by default
            subMenu.style.display = 'none';
            // Add a click event listener to the menu item
            item.addEventListener('click', function() {
                // Toggle the sub-menu visibility on click
                subMenu.style.display = subMenu.style.display === 'none' ? 'block' : 'none';
            });
        }
    });
    /*
    |--------------------------------------------------------------------------
    | Code for sidebar tree view ends
    |--------------------------------------------------------------------------
    */
</script>
