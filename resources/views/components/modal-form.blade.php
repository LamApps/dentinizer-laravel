<!--begin::Modal Content-->
<div class="modal fade bd-example-modal-lg" id="{{ $id }}" role="dialog" aria-labelledby="{{$formName}}_MODAL_TITLE"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            
                <div class="modal-header">
                    <h4 class="modal-title">{!!\App\Library\Helpers\Helper::getSvgIconeByAction('EDIT')!!} <span
                            id="{{$formName}}_MODAL_TITLE"></span></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body modal-body-lg" >
                <form id="FORM_{{ $formName }}">
                    <div id="{{ $content }}"></div>
                </form>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="$('#FORM_{{ $formName }}').submit();"
                        class="btn btn-sm btn-outline-primary">
                        {!!\App\Library\Helpers\Helper::getSvgIconeByAction('SAVE')!!}
                        <span class="align-middle">{{ __('locale.save') }}</span>
                        <span id="SPAN_SAVE_{{ $formName }}" class="" role="status" aria-hidden="true"></span>
                    </button>
                    <button type="button" data-dismiss="modal" class="btn btn-sm btn-outline-danger">
                        {!!\App\Library\Helpers\Helper::getSvgIconeByAction('CANCEL')!!}
                        <span class="align-middle">{{ __('locale.cancel') }}</span>
                    </button>
                </div>
            
        </div>
    </div>
</div>
</div>
<!--end::Modal Content-->