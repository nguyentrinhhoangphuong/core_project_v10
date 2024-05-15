<!-- Libs JS -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>


<script src="{{ asset('_admin/ckeditor/ckeditor.js') }}"></script>
<script>
    if (document.getElementById('editor1')) {
        CKEDITOR.replace('editor1', {
            filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
            filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token={{ csrf_token() }}',
            filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
            filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token={{ csrf_token() }}',
            toolbar: [{
                    name: 'clipboard',
                    items: ['Undo', 'Redo']
                },
                {
                    name: 'styles',
                    items: ['Styles', 'Format']
                },
                {
                    name: 'basicstyles',
                    items: ['Bold', 'Italic', 'Strike', '-', 'RemoveFormat']
                },
                {
                    name: 'paragraph',
                    items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote']
                },
                {
                    name: 'links',
                    items: ['Link', 'Unlink']
                },
                {
                    name: 'insert',
                    items: ['Image', 'EmbedSemantic', 'Table']
                },
                {
                    name: 'tools',
                    items: ['Maximize']
                },
                {
                    name: 'editing',
                    items: ['Scayt']
                }
            ],
            customConfig: '',
            extraPlugins: 'image2,imageresize',
            removePlugins: 'image',
            height: 600,
            stylesSet: [
                /* Inline Styles */
                {
                    name: 'Marker',
                    element: 'span',
                    attributes: {
                        'class': 'marker'
                    }
                },
                {
                    name: 'Cited Work',
                    element: 'cite'
                },
                {
                    name: 'Inline Quotation',
                    element: 'q'
                },

                /* Object Styles */
                {
                    name: 'Special Container',
                    element: 'div',
                    styles: {
                        padding: '5px 10px',
                        background: '#eee',
                        border: '1px solid #ccc'
                    }
                },
                {
                    name: 'Compact table',
                    element: 'table',
                    attributes: {
                        cellpadding: '5',
                        cellspacing: '0',
                        border: '1',
                        bordercolor: '#ccc'
                    },
                    styles: {
                        'border-collapse': 'collapse'
                    }
                },
                {
                    name: 'Borderless Table',
                    element: 'table',
                    styles: {
                        'border-style': 'hidden',
                        'background-color': '#E6E6FA'
                    }
                },
                {
                    name: 'Square Bulleted List',
                    element: 'ul',
                    styles: {
                        'list-style-type': 'square'
                    }
                },

                /* Widget Styles */
                // We use this one to style the brownie picture.
                {
                    name: 'Illustration',
                    type: 'widget',
                    widget: 'image',
                    attributes: {
                        'class': 'image-illustration'
                    }
                },
                // Media embed
                {
                    name: '240p',
                    type: 'widget',
                    widget: 'embedSemantic',
                    attributes: {
                        'class': 'embed-240p'
                    }
                },
                {
                    name: '360p',
                    type: 'widget',
                    widget: 'embedSemantic',
                    attributes: {
                        'class': 'embed-360p'
                    }
                },
                {
                    name: '480p',
                    type: 'widget',
                    widget: 'embedSemantic',
                    attributes: {
                        'class': 'embed-480p'
                    }
                },
                {
                    name: '720p',
                    type: 'widget',
                    widget: 'embedSemantic',
                    attributes: {
                        'class': 'embed-720p'
                    }
                },
                {
                    name: '1080p',
                    type: 'widget',
                    widget: 'embedSemantic',
                    attributes: {
                        'class': 'embed-1080p'
                    }
                }
            ],
        });
    }
</script>
{{-- <script src="https://cdn.datatables.net/v/dt/dt-2.0.7/datatables.min.js"></script> --}}
<!-- Drop Zone -->
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<!-- sort -->
<script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.js"></script>

<script src="{{ asset('_admin/js/simple-notif.js') }}"></script>
<script src="{{ asset('_admin/dist/js/tabler.min.js') }}"></script>
<script src="{{ asset('_admin/select2/select2.min.js') }}"></script>
<script src="{{ asset('_admin/js/my-js.js') }}"></script>
