<!-- plugins/egerstudios/imagegallery/controllers/galleries/_list_toolbar.htm -->

<div data-control="toolbar">
    <a
        href="<?= Backend::url('egerstudios/imagegallery/galleries/create') ?>"
        class="btn btn-primary oc-icon-plus">
        New Gallery
    </a>
    
    <button
        class="btn btn-default oc-icon-trash-o"
        disabled="disabled"
        onclick="$(this).data('request-data', { checked: $('.control-list').listWidget('getChecked') })"
        data-request="onDelete"
        data-request-confirm="Are you sure you want to delete the selected galleries?"
        data-trigger-action="enable"
        data-trigger=".control-list input[type=checkbox]"
        data-trigger-condition="checked"
        data-request-success="$(this).prop('disabled', true)"
        data-stripe-load-indicator>
        Delete selected
    </button>
</div>