{{-- Quickview --}}
<div id="helpview" class="helpview-wrapper">
    <a class="btn-link helpview-toggle" data-toggle-element="#helpview" data-toggle="helpview">
        <i class="fa fa-times"></i>
    </a>
    <div class="tab-content">
        <div class="tab-pane fade active in no-padding" id="helpview-help">
            <div class="view-port clearfix helpview-help" id="help-quick">
                {!! $content !!}
            </div>
        </div>
    </div>
</div>

<style type="text/css">
    .helpview-wrapper {
        padding: 10px 25px;
        width: 275px;
        position: fixed;
        right: -275px;
        top: 0;
        bottom: 0;
        overflow-y: auto;
        z-index:5000;
        transition: all 0.3s;
        background-color: #fff;
    }
    .helpview-shown .helpview-wrapper {
        box-shadow: 0 0 200px rgba(0,0,0,0.3);
    }
    .helpview-wrapper h2 {
        max-width: 200px;
    }
    .helpview-wrapper .helpview-toggle {
        cursor: pointer;
    }
    .helpview-shown .helpview-wrapper {
        right: 0;
    }
</style>

@section('scripts')
    @parent
<script type="text/javascript">
    $(function(){
        $('[data-toggle="helpview"]').click(function(event){
            event.preventDefault();

            $('body').toggleClass('helpview-shown');
        });
    });
</script>
@stop