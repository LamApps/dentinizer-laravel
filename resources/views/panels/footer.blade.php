<!-- BEGIN: Footer-->
<footer class="footer footer-static footer-light">
  <p class="clearfix mb-0">
    <span class="float-md-left d-block d-md-inline-block mt-25">&copy; {{ \Carbon\Carbon::now()->format('Y')}} <a class="ml-25" href="" target="_blank">{{ env('APP_NAME') }}</a>
      <span class="d-none d-sm-inline-block">, {{__('locale.all_rights_reserved') }}.</span>
    </span>
    <span class="float-md-right d-none d-md-block">{{__('locale.by') }} <a href="" target="_blank">team</a></span>
    <button class="btn btn-primary btn-icon scroll-top" type="button"><i data-feather="arrow-up"></i></button>
  </p>
</footer>
<!-- END: Footer-->
