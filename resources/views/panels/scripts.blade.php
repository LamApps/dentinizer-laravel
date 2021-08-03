{{-- Vendor Scripts --}}
<script src="{{ asset('new-assets/app-assets/vendors/js/vendors.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/ui/prism.min.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/vendors/js/screenfull/screenfull.min.js') }}"></script>
@yield('vendor-script')
{{-- Theme Scripts --}}
<script src="{{ asset('new-assets/app-assets/js/core/app-menu.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/js/core/app.js') }}"></script>
<script src="{{ asset('new-assets/app-assets/js/scripts/customizer.js') }}"></script>

{{-- page script --}}
@yield('page-script')
{{-- page script --}}
