{{-- Quickview --}}
<div id="quickview" class="quickview-wrapper" data-pages="quickview" style="z-index:5000">
    <a class="btn-link quickview-toggle" data-toggle-element="#quickview" data-toggle="quickview">
        <i class="fa fa-times"></i>
    </a>
    <div class="tab-content">
        <div class="tab-pane fade active in no-padding" id="quickview-help">
            <div class="view-port clearfix quickview-help" id="help-quick">
                {!! $content !!}
            </div>
        </div>
    </div>
</div>

<style type="text/css">
    .quickview-wrapper {
        padding: 10px 25px;
    }
    .quickview-wrapper.open {
        box-shadow: 0 0 500px rgba(0,0,0,0.3);
    }
    .quickview-wrapper h2 {
        max-width: 200px;
    }
    .quickview-wrapper .quickview-toggle {
        cursor: pointer;
    }
</style>