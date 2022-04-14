 @if(isset($meta))
	<!-- Primary Meta Tags -->
	<title>{{ $metaTitle }}</title> 
	<meta name="title" content="{{ $metaTitle }}">
	<meta name="description" content="{{ $metaDescription }}">
	
	@if(isset($metaArticle))
		<!-- Open Graph / Facebook -->
		<meta property="og:type" content="website">
		<meta property="og:url" content="{{$metaArticleURL}}">
		<meta property="og:title" content="{{$metaArticleTitle}}">
		<meta property="og:description" content="{{$metaArticleDescription}}">
		<meta property="og:image" content="{{$metaArticleImageURL}}">

		<!-- Twitter -->
		<meta property="twitter:card" content="summary_large_image">
		<meta property="twitter:url" content="{{$metaArticleURL}}">
		<meta property="twitter:title" content="{{$metaArticleTitle}}">
		<meta property="twitter:description" content="{{$metaArticleDescription}}">
		<meta property="twitter:image" content="{{$metaArticleImageURL}}">
	@endif
@endif