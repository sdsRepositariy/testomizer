@extends('components.modal')

@section('form')

@include('admin.tasks.move_content')

<form method="POST" action="">
	{{ method_field('POST') }}
	{{ csrf_field() }}
</form>

<script>
var moveGetContentHandler = {
	init: function( options ) {
        this.options = {
            modal: "#app_modal",
        };
 
        // Allow overriding the default options
        $.extend( this.options, options );

        this.setup();
    },

    setup: function() {
    	//
    },

    getContent: function() {
    	//
    },

    select: function() {
    	//
    },

    delete: function(event) {
    	//
    },
}
</script>

@endsection