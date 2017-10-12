<hr>
<h3>SEO</h3>
<hr>
<h4>Readability</h4>

<div id="seo_readability_content">
	@include('ignicms::admin.formElements.seoReadability')
</div>

<hr>
<h4>Social</h4>
<div class="form-group">
	<a id="seo_google" name="seo_google" href="#" class="btn btn-primary btn-seo-social" role="button"><i id="seo_google" class="fa fa-google"></i></a>
    <a id="seo_facebook" name="seo_facebook" href="#" class="btn btn-primary btn-seo-social" role="button"><i id="seo_facebook" class="fa fa-facebook"></i></a>
    <a id="seo_twitter" name="seo_twitter" href="#" class="btn btn-primary btn-seo-social" role="button"><i id="seo_twitter" class="fa fa-twitter"></i></a>
</div>

<div id="seo_google_div">
	@include('ignicms::admin.formElements.seoGoogle')
</div>

<div id="seo_facebook_div">
	@include('ignicms::admin.formElements.seoFacebook')
</div>

<div id="seo_twitter_div">
	@include('ignicms::admin.formElements.seoTwitter')
</div>

@push('additionalScripts')
    <script type="text/javascript">
    	var url = '{{ $field->getRoute() }}',
    		slug = $('#slug').val(),
    		active = '#seo_google',
    		activeDevice = '#seo_google_desktop';

    	@if ($errors->has('twitter_title') || $errors->has('twitter_description') | $errors->has('twitter_image'))
    		$('#seo_twitter').addClass('btn-danger').removeClass('btn-primary');
    	@endif
    	@if ($errors->has('facebook_title') || $errors->has('facebook_description') | $errors->has('facebook_image'))
        	$('#seo_facebook').addClass('btn-danger').removeClass('btn-primary');
        @endif
        @if ($errors->has('meta_description'))
        	$('#seo_google').addClass('btn-danger').removeClass('btn-primary');
        @endif

    	if ($('#slug').val() == undefined) {
    		slug = '{{ $field->getSlug() }}'
    	}

    	$('#seo_meta_title').html($('#title').val());
    	$('#seo_meta_url').html(url+'/'+slug);
    	$('#seo_meta_description').html($('#meta_description').val());
    	$(active).addClass('active');
    	$('#seo_facebook_div').hide();
    	$('#seo_twitter_div').hide();

    	$('#title').change(function() {
			$('#seo_meta_title').html($('#title').val());
		});

		$('#slug').change(function() {
			$('#seo_meta_url').html(url+'/'+$('#slug').val());
		});

		$('#meta_description').change(function() {
			$('#seo_meta_description').html($('#meta_description').val());
		});
	
		$('.btn-seo-social').click(function(event) {
			event.preventDefault();
			var targetId = event.target.id;

			if ('#'+targetId != active) {
				$(active+'_div').hide();
				$(active).removeClass('active');
				active = '#'+targetId;
				$(active+'_div').show();
				$(active).addClass('active');
			}
		});

		$(activeDevice).addClass('active');

		$('.btn-seo-google-switch').click(function(event) {
			event.preventDefault();
			var targetId = event.target.id;

			if ('#'+targetId != activeDevice) {
				// $(activeDevice+'_div').hide();
				$(activeDevice).removeClass('active');
				activeDevice = '#'+targetId;
				// $(activeDevice+'_div').show();
				$(activeDevice).addClass('active');
			}
		});

		function wysiwygTextChanged(editor) {
			var readabilityColumn = '{{ $field->getOptions('readabilityColumn') ?? 'content' }}';

		  	editor.on('mouseleave', function (e) {
		  		if (editor.id === readabilityColumn) {
		  			$.ajax({
		                url: '/admin/check/readability',
		                type: 'GET',
		                data: $('#'+readabilityColumn).serialize()
		            }).done(function (data) {
		                
		            }).fail(function (data) {
		                // setErrors(data.responseJSON, $self);
		            }).always(function (data) {
		               	
		            });
		  		}
       		});
		}
    </script>
@endpush
